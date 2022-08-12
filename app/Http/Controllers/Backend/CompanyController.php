<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //---- company View ----//
    public function view(){
    	$companies = company::select('id','name','mobile','email','address')->get();
    	return view('layouts.Backend.company.companyView', compact('companies'));
    }
    //---- company Add ----//
    public function add(){
    	return view('layouts.Backend.company.companyAdd');
    }
    //---- company Store ----//
    public function store(Request $request){
        // Insert Data
        $companyInsert = new company;
        $companyInsert->name       = $request->name;
        $companyInsert->mobile     = $request->mobile;
        $companyInsert->email      = $request->email;
        $companyInsert->address    = $request->address;
        $companyInsert->save();
      // Redirect 
      return redirect()->route('company.view')->with('success', 'Company Added Successfully');
    }
    //---- company Edit ----//
    public function edit($id){
        $companyEdit = company::find($id);
        return view('layouts.Backend.company.companyEdit', compact('companyEdit'));
    }
    //---- company Update ----//
    public function update($id, Request $request){
        // validation
        // Update
        $companyUpdate = company::find($id);
        $companyUpdate->name       = $request->name;
        $companyUpdate->mobile     = $request->mobile;
        $companyUpdate->email      = $request->email;
        $companyUpdate->address    = $request->address;
        $companyUpdate->save();
        // Redirect 
      return redirect()->route('company.view')->with('success', 'Company Updated Successfully');
    }
     //---- company Delete ----//
    public function delete($id){
        // Delete
        $companyDelete = company::find($id);
        $companyDelete->delete();
        // Redirect 
      return redirect()->route('company.view')->with('error', 'Company Deleted Successfully');
    }
}
