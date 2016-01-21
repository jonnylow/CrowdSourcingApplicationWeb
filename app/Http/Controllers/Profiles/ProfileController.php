<?php

namespace App\Http\Controllers\Profiles;

use Illuminate\Http\Request;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Controllers\Controller;
use Auth;
use JsValidator;

class ProfileController extends Controller
{
    public function edit()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\UpdateProfileRequest');

        $profile = Auth::user();
        return view('profile.profile', compact('validator', 'profile'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $errors = array();

        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->get('current_password')])) {
            $user = Auth::user();

            $user->name = $request->get('name');
            $user->email = $request->get('email');

            $user->save();
            return back()->with('success', 'Changes updated successfully!');
        } else {
            $errors = array_add($errors, 'current_password', 'Your current password is incorrect.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }
    }

    public function editPassword()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\UpdatePasswordRequest');

        $profile = Auth::user();
        return view('profile.password', compact('validator', 'profile'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $errors = array();

        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->get('current_password')])) {
            $user = Auth::user();

            $user->password = $request->get('new_password');

            $user->save();
            return back()->with('success', 'Changes updated successfully!');
        } else {
            $errors = array_add($errors, 'current_password', 'Your current password is incorrect.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }
    }
}
