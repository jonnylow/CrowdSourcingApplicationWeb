<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;

use App\Http\Requests\StaffRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Staff;
use Auth;
use JsValidator;
use Mail;

class StaffController extends Controller
{
    public function index()
    {
        $centreStaff = Staff::ofCentres(Auth::user())->get();

        return view('admin.index', compact('centreStaff'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\StaffRequest');

        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');

        return view('admin.create', compact('validator', 'centreList'));
    }

    public function store(StaffRequest $request)
    {
        $randomString = Str::random();

        $staff = Staff::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => $randomString,
            'is_admin'  => $request->get('admin'),
        ]);

        $staff->centres()->attach($request->get('centres'));

        Mail::send('emails.welcome', compact('staff', 'randomString'), function ($message) {
            $message->from('imchosen6@gmail.com', 'Admin');
            $message->subject('Your CareGuide account has been created.');
            $message->to('imchosen6@gmail.com');
        });

        return redirect('admin')->with('success', 'Staff has added successfully!');
    }

    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\StaffRequest');

        $staff = Staff::findOrFail($id);
        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');

        return view('admin.edit', compact('validator', 'staff', 'centreList'));
    }

    public function update($id, StaffRequest $request)
    {
        $staff = Staff::findOrFail($id);

        $staff->update([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'is_admin'  => $request->get('admin'),
        ]);

        $staff->centres()->sync($request->get('centres'));

        return back()->with('success', 'Staff has updated successfully!');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return back()->with('success', 'Staff has removed successfully!');
    }
}
