<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Industry_Partner;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;


class IndustryPartnerController extends Controller
{
    // Apply authentication middleware.
    public function __construct() {
        $this->middleware('auth', ['except'=>['index', 'show']]);
    }
  
    // Display a paginated list of industry partners.
    public function index()
    {
        //$products = Product::all();
        $industry_partners = Industry_Partner::paginate(5);
        return view('industryPartners.list')->with('industry_partners', $industry_partners);
    }

    // Show the form to create a new industry partner, if the user is approved.
    public function create()
    {
        $industryPartner = auth()->user()->industry_partner;

        // Check if the industryPartner is approved or not
        if (!$industryPartner->is_approved) {
            return redirect()->back()->with('error', 'Your account has not been approved yet. You cannot create projects.');
        }
        return view('industryPartners.create_form')->with('projects', Project::all());
    }
    
    // Display details of a specific industry partner.
    public function show($id) 
    {
        $industry_partner = Industry_Partner::find($id);
        return view('industryPartners.detail')->with('industry_partner', $industry_partner);
    }

    // Display details of a specific project.
    public function showProject($id) 
    {
        $project = Project::findOrFail($id);
        return view('projects.detail')->with('project', $project);
    }


    // Delete a specific industry partner, if it matches the logged-in user.
    public function destroy(string $id)
    {
        $logged_in_industry_partner = Auth::user()->industry_partner;
    
        if ($logged_in_industry_partner && $logged_in_industry_partner->id == $id) {
            $industry_partner = Industry_Partner::find($id);
            $industry_partner->delete();
    
            Auth::logout();  // Logging out the user
    
            return redirect('/login')->with('message', 'Your account has been deleted.');
        }
        // If the IDs don't match, redirect to a suitable route with an error message
        return redirect()->back()->with('error', 'You can only delete your own account.');
    }
}
