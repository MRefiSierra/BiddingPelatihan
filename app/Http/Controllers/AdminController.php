<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
        // Admin (Create User)

        public function managementUser(){
            return view('admin.management-user');
        }

        public function inputUser(){
            return view('admin.add-user');
        }

        public function storeUser(Request $request){
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email:dns|unique:users',
                'password' => 'required|min:5|max:255'
            ]);
            
}
}