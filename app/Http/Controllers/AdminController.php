<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;

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

            $request->validate([
                'nama' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required'
            ]);

            $user = User::Create([
                'name' => $request->input('nama'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role' => $request->input('role')
            ]);
            return back()->with('success', 'User has been added');
        }
}
