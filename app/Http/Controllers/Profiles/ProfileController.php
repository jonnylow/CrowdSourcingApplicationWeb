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
    public function view()
    {
        $profile = Auth::user();
        return view('profile.profile', compact('validator', 'profile'));
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

            $user->update([
                'password' => bcrypt($request->get('new_password')),
            ]);

            return back()->with('success', 'Changes updated successfully!');
        } else {
            $errors = array_add($errors, 'current_password', 'Your current password is incorrect.');
            return back()
                ->withErrors($errors)
                ->withInput();
        }
    }
}
