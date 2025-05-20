<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Job;

class AICVAnalyzerController extends Controller
{
    // Ollama API endpoint
    protected $ollamaEndpoint = 'http://localhost:11434/api/chat';
    protected $ollamaModel = 'llama3.2:3b';
    
    /**
     * Debug route to test the Ollama API directly
     */
    public function debugOllamaAPI()
    {
        $results = [];
        
        // Test API connection
        $results['api_test'] = $this->testOllamaAPI();
        
        // Test simple prompt
        try {
            $prompt = "Say hello in Arabic";
            $response = Http::timeout(10)->withHeaders([
                'Content-Type' => 'application/json'
            ])->post($this->ollamaEndpoint, [
                'model' => $this->ollamaModel,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]);
            
            $results['status_code'] = $response->status();
            $results['headers'] = $response->headers();
            
            if ($response->successful()) {
                $responseData = $response->json();
                $results['response_structure'] = array_keys($responseData);
                
                if (isset($responseData['message']['content'])) {
                    $results['response_text'] = $responseData['message']['content'];
                } else {
                    $results['error'] = 'Response structure does not contain expected fields';
                    $results['full_response'] = $responseData;
                }
            } else {
                $results['error'] = 'API request failed';
                $results['response_body'] = $response->body();
            }
        } catch (\Exception $e) {
            $results['exception'] = $e->getMessage();
        }
        
        return response()->json($results);
    }
    
    /**
     * Display the CV analyzer page
     */
    public function index(Request $request)
    {
        // Get available jobs for comparison
        $jobs = Job::where('status', 'active')->get();
        
        return view('student.ai-cv-analyzer', [
            'jobs' => $jobs
        ]);
    }
    
    /**
     * Analyze the uploaded CV
     */
    public function analyze(Request $request)
    {
        // Check if this is a comparison request from the same page
        if ($request->has('analyze_in_place') && $request->has('job_id')) {
            \Log::info('Received analyze_in_place request with job_id: ' . $request->job_id);
            
            // Check if we have the CV in session
            $cvText = $request->session()->get('last_cv_text');
            if (!$cvText) {
                return redirect()->route('student.ai-cv-analyzer')
                    ->with('error', 'Please upload your CV first before comparing with a job.');
            }
            
            // Get job details
            $job = Job::find($request->job_id);
            if (!$job) {
                return back()->with('error', 'Selected job not found.');
            }
            
            $jobDetails = "Job Title: {$job->title}\nCompany: {$job->company->name}\nDescription: {$job->description}\nRequirements: {$job->requirements}";
            
            // Compare CV with job
            $comparison = $this->compareWithJob($cvText, $jobDetails);
            
            // Parse match percentage from comparison text
            $match = null;
            if (preg_match('/Match Percentage:\s*(\d+)%/i', $comparison, $matches)) {
                $match = $matches[1];
            } else {
                $match = 70; // Default fallback percentage if not found
            }
            
            // Get the original analysis from session
            $analysis = $request->session()->get('last_analysis');
            $cvPath = $request->session()->get('last_cv_path');
            
            // Get available jobs for comparison
            $jobs = Job::where('status', 'active')->get();
            
            \Log::info('Returning view with comparison data, matchPercentage: ' . $match);
            
            // Return the view with everything needed
            return view('student.ai-cv-analyzer', [
                'analysis' => $analysis,
                'originalText' => $cvText,
                'jobs' => $jobs,
                'jobComparison' => $comparison,
                'cvPath' => $cvPath,
                'selectedJobId' => $request->job_id,
                'matchPercentage' => $match
            ]);
        }
        
        // Normal CV analyze logic follows...
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
            'job_id' => 'nullable|exists:jobs,id'
        ]);
        
        // Store the uploaded file
        $file = $request->file('cv');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('cv_uploads', $filename, 'public');
        $filePath = Storage::disk('public')->path($path);
        
        // Extract text from the CV
        $text = $this->extractTextFromCV($filePath);
        if ($text === 'NO_TEXT_EXTRACTED') {
            $jobs = Job::where('status', 'active')->get();
            return view('student.ai-cv-analyzer', [
                'analysis' => 'No text could be extracted from your PDF. This file is likely a scanned image. Please upload a text-based PDF or a DOCX file.',
                'originalText' => '',
                'jobs' => $jobs,
                'jobComparison' => null,
                'cvPath' => $path,
                'selectedJobId' => $request->job_id
            ]);
        }
        
        // Get job details if job_id is provided
        $jobDetails = null;
        $jobComparison = null;
        
        if ($request->has('job_id') && $request->job_id) {
            $job = Job::find($request->job_id);
            if ($job) {
                $jobDetails = "Job Title: {$job->title}\nCompany: {$job->company->name}\nDescription: {$job->description}\nRequirements: {$job->requirements}";
                $jobComparison = $this->compareWithJob($text, $jobDetails);
                
                // Parse match percentage from comparison text
                $matchPercentage = null;
                if (preg_match('/Match Percentage:\s*(\d+)%/i', $jobComparison, $matches)) {
                    $matchPercentage = $matches[1];
                } else {
                    $matchPercentage = 70; // Default fallback percentage if not found
                }
            }
        }
        
        // Analyze the CV using the Ollama model
        $analysis = $this->analyzeWithAI(['raw_text' => $text]);
        
        // Get available jobs for comparison
        $jobs = Job::where('status', 'active')->get();
        
        // Save the CV file path and text for later use
        $request->session()->put('last_cv_path', $path);
        $request->session()->put('last_cv_text', $text);
        $request->session()->put('last_analysis', $analysis);
        
        // Return the analysis results
        return view('student.ai-cv-analyzer', [
            'analysis' => $analysis,
            'originalText' => $text,
            'jobs' => $jobs,
            'jobComparison' => $jobComparison,
            'cvPath' => $path,
            'selectedJobId' => $request->job_id,
            'matchPercentage' => $matchPercentage ?? null
        ]);
    }
    
    /**
     * Handle job comparison request
     */
    public function handleJobComparison(Request $request)
    {
        // Validate the request
        $request->validate([
            'job_id' => 'required|exists:jobs,id'
        ]);
        
        // Get the CV text from session
        $cvText = $request->session()->get('last_cv_text');
        
        if (!$cvText) {
            return redirect()->route('student.ai-cv-analyzer')
                ->with('error', 'Please upload your CV first before comparing with a job.');
        }
        
        // Get job details
        $job = Job::find($request->job_id);
        $jobDetails = "Job Title: {$job->title}\nCompany: {$job->company->name}\nDescription: {$job->description}\nRequirements: {$job->requirements}";
        
        // Compare CV with job
        $comparison = $this->compareWithJob($cvText, $jobDetails);
        
        // Parse match percentage from comparison text
        $match = null;
        if (preg_match('/Match Percentage:\s*(\d+)%/i', $comparison, $matches)) {
            $match = $matches[1];
        } else {
            $match = 70; // Default fallback percentage if not found
        }
        
        // Get available jobs for comparison dropdown
        $jobs = Job::where('status', 'active')->get();
        
        // Get the original analysis from session
        $analysis = $request->session()->get('last_analysis');
        
        // Get cv path
        $cvPath = $request->session()->get('last_cv_path');
        
        // Return view directly - don't redirect - with all the data like in the analyze method
        return view('student.ai-cv-analyzer', [
            'analysis' => $analysis,
            'originalText' => $cvText,
            'jobs' => $jobs,
            'jobComparison' => $comparison,
            'cvPath' => $cvPath,
            'selectedJobId' => $request->job_id,
            'matchPercentage' => $match
        ]);
    }
    
    /**
     * Extract text from the uploaded CV file
     */
    private function extractTextFromCV($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($extension == 'pdf') {
            // استخدم smalot/pdfparser أولاً
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($filePath);
                $text = $pdf->getText();
                \Log::info('PDF direct extraction text: ' . mb_substr($text, 0, 500));
                if (trim($text) !== '') {
                    return $text;
                }
            } catch (\Exception $e) {
                \Log::error('PDF extraction error: ' . $e->getMessage());
            }
            // إذا لم يتم استخراج نص، جرب Tesseract OCR بالإنجليزية
            try {
                $outputFile = tempnam(sys_get_temp_dir(), 'ocr_');
                $cmd = 'tesseract ' . escapeshellarg($filePath) . ' ' . escapeshellarg($outputFile) . ' -l eng';
                shell_exec($cmd);
                $ocrText = @file_get_contents($outputFile . '.txt');
                \Log::info('Tesseract OCR extraction text (eng): ' . mb_substr($ocrText, 0, 500));
                @unlink($outputFile . '.txt');
                if ($ocrText && trim($ocrText) !== '') {
                    return $ocrText;
                }
            } catch (\Exception $e) {
                \Log::error('Tesseract OCR error (eng): ' . $e->getMessage());
            }
            // إذا لم يتم استخراج نص، جرب Tesseract OCR بالعربية
            try {
                $outputFile = tempnam(sys_get_temp_dir(), 'ocr_');
                $cmd = 'tesseract ' . escapeshellarg($filePath) . ' ' . escapeshellarg($outputFile) . ' -l ara';
                shell_exec($cmd);
                $ocrText = @file_get_contents($outputFile . '.txt');
                \Log::info('Tesseract OCR extraction text (ara): ' . mb_substr($ocrText, 0, 500));
                @unlink($outputFile . '.txt');
                if ($ocrText && trim($ocrText) !== '') {
                    return $ocrText;
                }
            } catch (\Exception $e) {
                \Log::error('Tesseract OCR error (ara): ' . $e->getMessage());
            }
            \Log::warning('No text could be extracted from PDF using parser or Tesseract (eng/ara).');
            return 'NO_TEXT_EXTRACTED';
        }

        if ($extension == 'docx') {
            // استخدم phpoffice/phpword
            try {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                    }
                }
                return $text;
            } catch (\Exception $e) {
                \Log::error('DOCX extraction error: ' . $e->getMessage());
                return '';
            }
        }

        return '';
    }
    
    /**
     * Analyze CV using local Ollama model
     */
    private function analyzeWithAI($cvData)
    {
        if (empty($cvData['raw_text'])) {
            return "# CV Analysis\n\nNo CV text was extracted. Please upload a different file format or try again.";
        }
        $prompt = $this->prepareAnalysisPrompt($cvData);
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(120)->post('http://127.0.0.1:5005/analyze', [
                'prompt' => $prompt
            ]);
            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['result'])) {
                    return $responseData['result'];
                } else {
                    return "# CV Analysis\n\n[DEBUG: Unexpected bridge response]\n" . print_r($responseData, true);
                }
            }
            \Log::error('Flask bridge error: ' . $response->body());
            return "# CV Analysis\n\nWe're experiencing technical difficulties with our AI analysis service. Please try again later.";
        } catch (\Exception $e) {
            \Log::error('Flask bridge exception: ' . $e->getMessage());
            return "# CV Analysis\n\nWe're experiencing technical difficulties with our AI analysis service. Please try again later.";
        }
    }
    
    /**
     * Compare CV with job requirements using Ollama API
     */
    private function compareWithJob($cvText, $jobDetails)
    {
        if (empty($cvText) || empty($jobDetails)) {
            return "# Job Match Analysis Report\n\nMatch Percentage: 0%\n\n## Analysis\nInsufficient information provided. Please ensure both CV and job details are available.";
        }
        $cleanCvText = $this->cleanTextForAPI($cvText);
        $cleanJobDetails = $this->cleanTextForAPI($jobDetails);
        
        // Update the prompt to EXPLICITLY request a percentage and matching format
        $prompt = "Compare this CV with the job description and provide a detailed matching analysis in the following format:

# Job Match Analysis Report

Match Percentage: [PROVIDE A CLEAR NUMERIC PERCENTAGE BETWEEN 0-100]%

## Strengths:
- [List key matching skills]
- [List other strengths]

## Areas to Improve:
- [List missing skills]
- [List other improvement areas]

## Detailed Analysis:
[Detailed analysis of how well the CV matches the job description]

CV Text:
$cleanCvText

Job Details:
$cleanJobDetails

IMPORTANT: You MUST include the Match Percentage clearly in the format 'Match Percentage: XX%' where XX is a number between 0 and 100. Make sure this percentage accurately reflects the detailed analysis you provide.";

        try {
            // Try first using the Flask bridge for more reliability
            $bridgeResponse = $this->compareUsingFlaskBridge($prompt);
            if ($bridgeResponse !== null) {
                // لضمان تنسيق متسق للنسبة المئوية
                return $this->standardizeMatchPercentage($bridgeResponse);
            }
            
            // If bridge fails, try direct API call to Ollama
            $response = \Illuminate\Support\Facades\Http::timeout(90)->post($this->ollamaEndpoint, [
                'model' => $this->ollamaModel,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['message']['content'])) {
                    // لضمان تنسيق متسق للنسبة المئوية
                    return $this->standardizeMatchPercentage($responseData['message']['content']);
                } elseif (isset($responseData['choices'][0]['message']['content'])) {
                    // لضمان تنسيق متسق للنسبة المئوية
                    return $this->standardizeMatchPercentage($responseData['choices'][0]['message']['content']);
                }
            }
            \Log::error('Ollama API job comparison error: ' . $response->body());
            
            // Fallback to local matching algorithm
            return $this->generateRealisticJobMatch($cleanCvText, $cleanJobDetails);
            
        } catch (\Exception $e) {
            \Log::error('Ollama API job comparison exception: ' . $e->getMessage());
            // Fallback to local matching algorithm
            return $this->generateRealisticJobMatch($cleanCvText, $cleanJobDetails);
        }
    }
    
    /**
     * ضمان تنسيق متسق للنسبة المئوية في النص
     */
    private function standardizeMatchPercentage($text)
    {
        // Check if there's a line that starts with "Match Percentage:" or contains it
        $patterns = [
            '/Match\s*Percentage\s*:\s*(\d+)%/i',
            '/Match\s*Percentage\s*:\s*(\d+)\s*%/i',
            '/Match\s*Percentage\s*:\s*(\d+)/i',
            '/Match\s*:\s*(\d+)%/i',
            '/(\d+)%\s*match/i'
        ];
        
        $matchPercentage = null;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $matchPercentage = (int)$matches[1];
                break;
            }
        }
        
        // إذا لم يتم العثور على نسبة، استخدم القيمة الافتراضية
        if ($matchPercentage === null) {
            $matchPercentage = 70;
        }
        
        // قم بتعديل النص لضمان وجود تنسيق متسق للنسبة المئوية
        // احذف أي سطر يحتوي على "Match Percentage:"
        $lines = explode("\n", $text);
        $newLines = [];
        $foundPercentage = false;
        
        foreach ($lines as $line) {
            $containsPercentage = false;
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $line)) {
                    $containsPercentage = true;
                    break;
                }
            }
            
            if ($containsPercentage) {
                if (!$foundPercentage) {
                    // أضف النسبة المئوية بتنسيق متسق
                    $newLines[] = "Match Percentage: {$matchPercentage}%";
                    $foundPercentage = true;
                }
                // تخطى السطر الأصلي
            } else {
                $newLines[] = $line;
            }
        }
        
        // إذا لم يتم العثور على سطر بالنسبة، أضفه بعد العنوان
        if (!$foundPercentage) {
            $newText = '';
            $foundTitle = false;
            
            foreach ($newLines as $line) {
                $newText .= $line . "\n";
                if (!$foundTitle && strpos($line, 'Job Match Analysis Report') !== false) {
                    $newText .= "Match Percentage: {$matchPercentage}%\n\n";
                    $foundTitle = true;
                }
            }
            
            return $newText;
        }
        
        return implode("\n", $newLines);
    }
    
    /**
     * Try to compare using Flask bridge
     */
    private function compareUsingFlaskBridge($prompt)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(120)->post('http://127.0.0.1:5005/analyze', [
                'prompt' => $prompt
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['result'])) {
                    $result = $responseData['result'];
                    
                    // Ensure there's a percentage match even if AI doesn't provide one
                    if (!preg_match('/Match Percentage:\s*\d+%/i', $result)) {
                        $result = str_replace('# Job Match Analysis Report', "# Job Match Analysis Report\n\nMatch Percentage: 75%", $result);
                    }
                    
                    \Log::info('Successfully received CV comparison from Flask bridge');
                    return $result;
                }
            }
            \Log::warning('Flask bridge returned unsuccessful response: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            \Log::error('Flask bridge error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Generate a realistic job match analysis when AI services fail
     */
    private function generateRealisticJobMatch($cvText, $jobDetails)
    {
        // Extract keywords from the job details
        $jobKeywords = $this->extractKeywords($jobDetails);
        
        // Count how many job keywords are found in the CV
        $matchCount = 0;
        foreach ($jobKeywords as $keyword) {
            if (stripos($cvText, $keyword) !== false) {
                $matchCount++;
            }
        }
        
        // Calculate match percentage
        $matchPercentage = count($jobKeywords) > 0 
            ? min(95, max(60, intval(($matchCount / count($jobKeywords)) * 100))) 
            : 75;
        
        // Extract potential strengths and weaknesses
        $strengths = [];
        $weaknesses = [];
        
        // Common skills to look for
        $commonSkills = ['communication', 'leadership', 'teamwork', 'problem solving', 
                        'programming', 'design', 'analysis', 'research', 'project management',
                        'javascript', 'php', 'python', 'java', 'html', 'css', 'react', 'angular', 
                        'vue', 'laravel', 'spring', 'node', 'express', 'database', 'sql', 'nosql'];
        
        foreach ($commonSkills as $skill) {
            if (stripos($jobDetails, $skill) !== false) {
                if (stripos($cvText, $skill) !== false) {
                    $strengths[] = ucfirst($skill) . " skills mentioned in your CV align with job requirements";
                } else {
                    $weaknesses[] = "Consider highlighting your " . $skill . " skills if you have them";
                }
                
                if (count($strengths) >= 3) break;
            }
        }
        
        // Add generic strengths if needed
        if (empty($strengths)) {
            $strengths = [
                "Technical skills match many of the job requirements",
                "Educational background appears relevant to the position",
                "Project experience demonstrates relevant capabilities"
            ];
        }
        
        // Add generic weaknesses if needed
        if (empty($weaknesses)) {
            $weaknesses = [
                "Consider adding more specific achievements with measurable results",
                "Some keywords from the job description could be more prominent in your CV",
                "Work experience section could be tailored more specifically to this role"
            ];
        }
        
        // Generate the response
        $response = "# Job Match Analysis Report\n\n";
        $response .= "Match Percentage: {$matchPercentage}%\n\n";
        
        $response .= "## Strengths:\n";
        foreach ($strengths as $strength) {
            $response .= "- {$strength}\n";
        }
        $response .= "\n";
        
        $response .= "## Areas to Improve:\n";
        foreach ($weaknesses as $weakness) {
            $response .= "- {$weakness}\n";
        }
        $response .= "\n";
        
        $response .= "## Detailed Analysis:\n";
        $response .= "Based on the information provided in your CV and the job description, there is a " . 
                    ($matchPercentage > 80 ? "strong" : ($matchPercentage > 65 ? "good" : "moderate")) . 
                    " alignment between your qualifications and the requirements. " .
                    "Your skills and experience match several key areas the employer is looking for.\n\n" .
                    "To improve your match rate, consider emphasizing specific achievements with measurable outcomes, " .
                    "highlighting keywords from the job description more prominently, and tailoring your work experience " .
                    "section to showcase the most relevant responsibilities to this specific role.";
        
        return $response;
    }
    
    /**
     * Extract meaningful keywords from text
     */
    private function extractKeywords($text)
    {
        // Convert to lowercase and remove punctuation
        $text = strtolower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        
        // Split into words
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        
        // Filter out common words
        $commonWords = ['the', 'and', 'or', 'in', 'to', 'with', 'for', 'a', 'an', 'of', 'on', 'at', 
                        'by', 'is', 'are', 'was', 'were', 'will', 'would', 'should', 'can', 'could', 
                        'may', 'might', 'must', 'have', 'has', 'had', 'be', 'been', 'being', 'do', 
                        'does', 'did', 'that', 'this', 'these', 'those', 'what', 'which', 'who', 
                        'whom', 'whose', 'how', 'when', 'where', 'why', 'job', 'work', 'company', 
                        'position', 'experience'];
        
        $keywords = [];
        foreach ($words as $word) {
            if (strlen($word) > 3 && !in_array($word, $commonWords)) {
                $keywords[] = $word;
            }
        }
        
        // Return unique keywords
        return array_unique($keywords);
    }
    
    /**
     * Clean and sanitize text for API submission to prevent UTF-8 encoding issues
     */
    private function cleanTextForAPI($text)
    {
        // Remove any invalid UTF-8 sequences
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        
        // Replace any remaining problematic characters
        $text = preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
        
        // Normalize line endings
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        
        // Limit text length if needed (Ollama has token limits)
        if (mb_strlen($text, 'UTF-8') > 10000) {
            $text = mb_substr($text, 0, 10000, 'UTF-8') . "... [text truncated due to length]";
        }
        
        return $text;
    }
    
    /**
     * Test the Ollama API with a simple prompt to verify it's working
     */
    private function testOllamaAPI()
    {
        try {
            // Simple test prompt
            $prompt = "Please respond with a simple 'Hello, the API is working!' message.";
            
            // Log the test request
            \Log::info('Testing Ollama API with simple prompt');
            
            // Make a simple API call
            $response = Http::timeout(10)->withHeaders([
                'Content-Type' => 'application/json'
            ])->post($this->ollamaEndpoint, [
                'model' => $this->ollamaModel,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]);
            
            // Log the full response for debugging
            \Log::info('Ollama API test response status: ' . $response->status());
            \Log::info('Ollama API test response body: ' . $response->body());
            
            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['message']['content'])) {
                    return true;
                }
            }
            
            return false;
        } catch (\Exception $e) {
            \Log::error('Ollama API test exception: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Extract sections from a CV text
     */
    private function extractCVSections($text)
    {
        $sections = [];
        
        // Extract contact information
        if (preg_match('/^(.+?(?:\n.+?){0,5})(?=\n\n|\n[A-Z])/s', $text, $matches)) {
            $sections['contact'] = trim($matches[1]);
        }
        
        // Extract professional summary/objective
        if (preg_match('/(?:summary|objective|profile)\s*:?\s*(.+?)(?=\n\n|\n[A-Z])/is', $text, $matches)) {
            $sections['summary'] = trim($matches[1]);
        }
        
        // Extract skills
        if (preg_match('/(?:skills|competencies|expertise)\s*:?\s*(.+?)(?=\n\n|\n[A-Z])/is', $text, $matches)) {
            $sections['skills'] = trim($matches[1]);
        }
        
        // Extract experience
        if (preg_match('/(?:experience|employment|work history)\s*:?\s*(.+?)(?=\n\n\s*(?:education|qualification|certification|skill|language|reference|additional|volunteer|project)|$)/is', $text, $matches)) {
            $sections['experience'] = trim($matches[1]);
        }
        
        // Extract education
        if (preg_match('/(?:education|qualification|academic)\s*:?\s*(.+?)(?=\n\n\s*(?:experience|employment|work|skill|language|reference|additional|volunteer|project|certification)|$)/is', $text, $matches)) {
            $sections['education'] = trim($matches[1]);
        }
        
        // Extract certifications
        if (preg_match('/(?:certification|certificate|license)\s*:?\s*(.+?)(?=\n\n\s*(?:experience|employment|work|skill|language|reference|additional|volunteer|project|education)|$)/is', $text, $matches)) {
            $sections['certifications'] = trim($matches[1]);
        }
        
        return $sections;
    }
    
    /**
     * إعداد برومبت التحليل للذكاء الاصطناعي
     */
    private function prepareAnalysisPrompt($cvData)
    {
        $cvText = isset($cvData['raw_text']) ? $cvData['raw_text'] : '';
        return "Analyze the following CV and provide feedback on its structure, content, and presentation. Suggest improvements and highlight strengths and weaknesses.\n\nCV:\n" . $cvText;
    }
}
