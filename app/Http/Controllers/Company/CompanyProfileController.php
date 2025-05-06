<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    /**
     * Show the form for editing the company profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $company = $user->company;
        
        return view('company.profile.edit', compact('company', 'user'));
    }

    /**
     * Update the company profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;
        
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'field_of_work' => 'required|string|max:255',
            'company_size' => 'required|string|in:small,medium,large',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'about' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'company_logo.max' => 'The company logo file size must not exceed 5 MB.',
            'company_logo.image' => 'The uploaded file must be an image.',
            'company_logo.mimes' => 'The company logo must be a file of type: jpeg, png, jpg, gif.',
            'company_size.in' => 'The selected company size is invalid.',
        ]);

        // Handle logo upload if provided
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
                Storage::disk('public')->delete($company->logo_path);
            }
            
            $path = $request->file('company_logo')->store('company_logos', 'public');
            $company->logo_path = $path;
        }

        // Remove company_logo from validated data since we handled it separately
        unset($validated['company_logo']);
        
        $company->update($validated);

        // Update user name if company name changed
        if ($request->filled('company_name') && $user->name !== $request->company_name) {
            $user->name = $request->company_name;
            $user->save();
        }

        return redirect()->route('company.profile.edit')
            ->with('success', 'Company profile updated successfully!');
    }

    /**
     * Show the public profile for a company.
     * Accessible by students/guests.
     */
    public function showPublicProfile($id)
    {
        $company = \App\Models\Company::findOrFail($id);
        $user = $company->user;
        return view('company.profile.public', compact('company', 'user'));
    }
}
