<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;

use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\EditStaffRequest;
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

        return view('staff.index', compact('centreStaff'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\CreateStaffRequest');

        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');

        return view('staff.create', compact('validator', 'centreList'));
    }

    public function store(CreateStaffRequest $request)
    {
        $randomString = Str::random();

        $staff = Staff::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => $randomString,
            'is_admin'  => $request->get('admin'),
        ]);

        $staff->centres()->attach($request->get('centres'));

        Mail::send('emails.welcome_staff', compact('staff', 'randomString'), function ($message) {
            $message->from('imchosen6@gmail.com', 'Admin');
            $message->subject('Your CareGuide account has been created.');
            $message->to('imchosen6@gmail.com');
        });

        return redirect('staff')->with('success', 'Staff is added successfully!');
    }

    public function edit($id)
    {
        $validator = JsValidator::formRequest('App\Http\Requests\EditStaffRequest');

        $staff = Staff::findOrFail($id);
        $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');

        return view('staff.edit', compact('validator', 'staff', 'centreList'));
    }

    public function update($id, EditStaffRequest $request)
    {
        $staff = Staff::findOrFail($id);
        $adminType = $request->get('admin');
        if ($staff->is_admin)
            $adminType = true;

        $staff->update([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'is_admin'  => $adminType,
        ]);

        $staff->centres()->sync($request->get('centres'));

        return back()->with('success', 'Staff is updated successfully!');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return back()->with('success', 'Staff is removed successfully!');
    }
}
