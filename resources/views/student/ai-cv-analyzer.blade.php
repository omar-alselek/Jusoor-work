@extends('layouts.student')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">AI CV Analyzer</h1>
            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                <span>AI Powered</span>
            </div>
        </div>
        
        <div class="prose max-w-none mb-8">
            <p class="text-gray-600">Upload your CV/resume and our AI will analyze it to provide feedback on its structure, content, and presentation. Get personalized suggestions to improve your CV and increase your chances of landing interviews.</p>
        </div>
        
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>New Features:</strong> Compare your CV with specific job requirements and get an improved version of your CV with our AI suggestions!
                    </p>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!isset($analysis))
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-indigo-100 mb-8">
                <div class="flex flex-col md:flex-row items-start md:items-center">
                    <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Upload your CV/Resume</h3>
                        <form action="{{ route('student.ai-cv-analyzer.analyze') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="flex flex-col space-y-2">
                                <label for="cv" class="text-sm font-medium text-gray-700">Select your CV file (PDF, DOC, DOCX)</label>
                                <input type="file" name="cv" id="cv" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100" required>
                                <p class="text-xs text-gray-500 mt-1">Maximum file size: 2MB</p>
                            </div>
                            
                            <!-- Compare with job option removed -->
                            <input type="hidden" name="job_id" value="">
                            
                            <div class="flex space-x-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                    Analyze CV
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Your CV will be analyzed using AI technology. The analysis is for informational purposes only and should be used as a guide to improve your CV.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Structure Analysis</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Get feedback on your CV's organization, sections, and overall layout.</p>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Content Review</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Evaluate the effectiveness of your skills, experience, and education descriptions.</p>
                </div>

                <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Improvement Tips</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Receive actionable suggestions to enhance your CV and stand out to employers.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <!-- CV Analysis Results -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                        <div class="p-5 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">CV Analysis Results</h3>
                                <a href="{{ route('student.ai-cv-analyzer') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Analyze Another CV
                                </a>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="prose max-w-none">
                                {!! Str::markdown($analysis) !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Job Comparison Results (if available) -->
                    @if(isset($jobComparison))
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                        <div class="p-5 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Job Match Analysis</h3>
                            </div>
                        </div>
                        <div class="p-5">
                            <!-- Show match percentage with visual indicator -->
                            <div class="mb-6">
                                @php
                                    // استخراج نسبة التطابق من نص المقارنة بطريقة أكثر دقة
                                    $matchPercentage = 70; // قيمة افتراضية
                                    
                                    // جميع الأنماط المحتملة لذكر النسبة المئوية
                                    $patterns = [
                                        '/Match\s*Percentage\s*:\s*(\d+)%/i',
                                        '/Match\s*Percentage\s*:\s*(\d+)\s*%/i',
                                        '/Match\s*Percentage\s*:\s*(\d+)/i',
                                        '/Match\s*:\s*(\d+)%/i',
                                        '/(\d+)%\s*match/i'
                                    ];
                                    
                                    foreach ($patterns as $pattern) {
                                        if (preg_match($pattern, $jobComparison, $matches)) {
                                            $matchPercentage = (int)$matches[1];
                                            break;
                                        }
                                    }
                                @endphp
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-medium text-gray-700">Match Percentage</span>
                                    <span class="text-2xl font-bold text-indigo-600">{{ $matchPercentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-4">
                                    <div class="bg-indigo-600 h-4 rounded-full" style="width: {{ $matchPercentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>0%</span>
                                    <span>50%</span>
                                    <span>100%</span>
                                </div>
                            </div>
                            <div class="prose max-w-none">
                                {!! Str::markdown($jobComparison) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Compare with other jobs form -->
                    @if(session()->has('last_cv_text'))
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                        <div class="p-5 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Compare with Other Jobs</h3>
                        </div>
                        <div class="p-5">
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            Select a job and click "Compare" to see how well your CV matches with job requirements. Results will appear on this page.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <form id="compareCvForm" method="POST" class="space-y-4">
                                @csrf
                                <div class="flex flex-col space-y-2">
                                    <label for="job_id" class="text-sm font-medium text-gray-700">Select a job to compare your CV against</label>
                                    <select name="job_id" id="job_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                        <option value="">Select a job</option>
                                        @foreach($jobs ?? [] as $job)
                                            <option value="{{ $job->id }}" {{ isset($selectedJobId) && $selectedJobId == $job->id ? 'selected' : '' }}>{{ $job->title }} - {{ $job->company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" id="compareButton" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Compare CV with Job
                                    </button>
                                    <div id="loading-message" class="hidden mt-3 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Please wait, analyzing CV against selected job...
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="analyze_in_place" value="1">
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set form action to current URL
    const compareForm = document.getElementById('compareCvForm');
    if (compareForm) {
        // Use the current URL as form action
        compareForm.action = window.location.href;
        
        // Form submission handling with loading indicator
        compareForm.addEventListener('submit', function() {
            const loadingMessage = document.getElementById('loading-message');
            const compareButton = document.getElementById('compareButton');
            
            if (loadingMessage && compareButton) {
                loadingMessage.classList.remove('hidden');
                compareButton.disabled = true;
                compareButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    }
});
</script>
@endpush
