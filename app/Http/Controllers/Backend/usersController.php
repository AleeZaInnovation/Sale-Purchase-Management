<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;

class usersController extends Controller
{
    //---- users view ----//
    public function view(){
        $users = User::all();
    	return view('layouts.Backend.users.usersView', compact('users'));
    }
    //---- users Add ----//
    public function add(){
    	return view('layouts.Backend.users.usersAdd');
    }
    //---- users Store ----//
    public function store(Request $request){
        // Validation 

        $request->validate([
          'userRole' => 'required',
          'name'     => 'required',
          'email'    => 'required|unique:users,email',
          'password' => 'required|min:5',
          'mobile'   => 'required'
        ]);
        if($request->file('image')){
         $file = $request->file('image');
          $fileName = date('YmdHi'). $file->getClientOriginalName();
          $file->move(public_path('assets/backend/images'), $fileName);          
       }
 
       // insert data
        
       $data = new User;
       $data->userRole = $request->userRole;
       $data->name     = $request->name;
       $data->email    = $request->email;
       $data->password = Hash::make($request->password);
       $data->mobile   = $request->mobile;
       $data->designation   = $request->designation;
       $data->address  = $request->address;
       $data->gender = $request->gender;
       if($request->file('image')){
         $file = $request->file('image');
          $fileName = date('YmdHi'). $file->getClientOriginalName();
          $file->move(public_path('assets/backend/images'), $fileName);
       $data['image'] = $fileName;          
       }
       $data->save();

      

       // Redirect 
      return redirect()->route('users.view')->with('success', 'User Added Successfully');

    }
    //---- users Edit ----//
    public function edit($id){
    	$userEdit['edits'] = User::select()->find($id);
    	return view('layouts.Backend.users.usersEdit', $userEdit);
    }
    //---- users Update ----//
    public function update($id, Request $request){
         // Validation 
         $request->validate([
          'userRole' => 'required',
          'name'     => 'required',
          'email'    => 'required',
          'mobile'   => 'required'
        ]);
        // update
        $userUpdate = User::find($id);
        // Image Check
       // Update 
       $userUpdate->userRole = $request->userRole;
       $userUpdate->name     = $request->name;
       $userUpdate->email    = $request->email;
       $userUpdate->mobile   = $request->mobile;
       $userUpdate->designation = $request->designation;
       $userUpdate->address  = $request->address;
       $userUpdate->gender  = $request->gender;
       if($request->file('image')){
         $file = $request->file('image');
          @unlink(public_path('assets/Backend/images/'.$userUpdate->image));
          $fileName = date('YmdHi'). $file->getClientOriginalName();
          $file->move(public_path('/assets/Backend/images'), $fileName);
          $userUpdate['image'] = $fileName;
       }
       $userUpdate->save();
       // Redirect
       return redirect()->route('users.view')->with('success', 'User Updated Successfully');
    }
    //---- users Delete ----//
    public function delete($id){
        $userDelete = User::find($id);
        @unlink(public_path('/assets/Backend/images/'. $userDelete->profile));
        $userDelete->delete();
        return redirect()->route('users.view')->with('success', 'User Deleted Successfully');
    }
    //---- users Password View ----//
    public function passwordView(){
      return view('layouts.Backend.users.passwordChange');
    }
    //---- users Password Update ----//
    public function passwordUpdate(Request $request){
          if(Auth::attempt(['id'=>Auth::user()->id, 'password'=>$request->current_password])){
            // validation
            $validation = $request->validate([
              'password' => 'required|confirmed'
            ]);
            // Change Password
            $user = User::find(Auth::user()->id);
            $user->update([
              'password' => Hash::make($request->password)
            ]);
            // Redirect
            return redirect()->back()->with('success','Your Password Update Successfully');
          } else{
            return redirect()->back()->with('error','Your Current Password Not Match');
          }
    }
}
