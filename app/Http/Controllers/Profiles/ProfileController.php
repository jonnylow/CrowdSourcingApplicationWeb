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
    /**
     * Create a new profile controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $profile = Auth::user();

        return view('profiles.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:vwo_users,email,'.Auth::user()->vwo_user_id.',vwo_user_id',
            'current_password' => 'required',
            'new_password' => 'confirmed',
            'new_password_confirmation' => 'required_with:new_password|same:new_password',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {
            if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->input('current_password')])) {
                $user = Auth::user();

                $user->name = $request->input('name');
                $user->email = $request->input('email');

                if($request->has('new_password')) {
                    if(Hash::check($request->input('new_password'), Auth::user()->password)) { // New password is the same as current password
                        $validator->errors()->add('new_password', 'New password must differ from current password.');
                    } else {
                        $user->password = bcrypt($request->input('new_password'));
                    }
                }

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
}