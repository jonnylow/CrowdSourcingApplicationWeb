<?php

namespace App\Http\Controllers\Profiles;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Auth::user();
        return view('profiles.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:staff,email,'.Auth::user()->staff_id.',staff_id',
            'current_password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->get('current_password')])) {
                $user = Auth::user();

                $user->name = $request->get('name');
                $user->email = $request->get('email');

                $user->save();
                return back()->with('success', 'Changes updated successfully!');
            } else {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
    }

    public function editPassword()
    {
        $profile = Auth::user();
        return view('profiles.password', compact('profile'));
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required_with:new_password|same:new_password',
            'current_password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->get('current_password')])) {
                $user = Auth::user();

                if(Hash::check($request->get('new_password'), $user->password)) { // New password is the same as current password
                    $validator->errors()->add('new_password', 'New password must differ from current password.');
                } else {
                    $user->password = $request->get('new_password');
                    $user->save();
                    return back()->with('success', 'Changes updated successfully!');
                }

                return back()
                    ->withErrors($validator)
                    ->withInputs();
            } else {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
    }
}
