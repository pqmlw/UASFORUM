<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller{
        public function register(Request $request): RedirectResponse
        {

        $validatedData = new User;
        // Validate the request data
        $validatedData = $request->validate([
            'username' => 'required|string|max:20|unique:users,username',
            'email' => 'required|email|unique:users,email|max:64',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'regex:/^(?=.*[0-9]).{8,32}$/',
            ],
            'confirm_password' => 'required|same:password',
        ]);


        // Remove confirm_password from validated data
        unset($validatedData['confirm_password']);


        // Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = new User($validatedData);
        $user->save();

        // Redirect to home
        return redirect('/');
    }

    }
