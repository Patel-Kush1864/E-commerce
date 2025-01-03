<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return view("login");
    }

    public function login_user(Request $request){
        $request->validate([
            'Name'=>'required|string|max:255',
            'Password'=>'required',
        ]);

          // Fetch user and admin data
          $user = DB::table('registers')->where('name', $request->Name)->first();
          $admin = DB::table('admins')->where('name', $request->Name)->first();
  
          // Check if the user exists and the password matches
          if ($user && $user->password === $request->Password) {
            
              // Set session variable for client login
              Session::put('client_id', $user->id); // Store client ID in session

              // User login successful
              return redirect()->route("login")
                            ->with("success","Login successful!");
             
          }
  
          // Check if the admin exists and the password matches
          if ($admin && $admin->password === $request->Password) {
              // Admin login successful
               // User login successful
             
             return redirect('/admin_dashboard')->with('success', 'Admin login successful!');
            //   return view('admin_dashboard');
          }
  
          // If no valid user or admin, return error
          return redirect('/login')->with('error', 'Invalid email or password.');
       
    }
   
    public function logout()
    {
        // Clear the session
        Session::flush(); // Or Session::forget('client_id');

        // Redirect the user to the login page with a success message
        return redirect('/login')->with('success_logout', 'You have logged out successfully.');
    }
}
