<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;

use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\EditStaffRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Staff;
use App\Centre;
use Auth;
use JsValidator;
use Mail;

class StaffController extends Controller
{
    public function __construct()
    {
        // Apply the staff.centre middleware to only edit, update and destroy methods.
        // We only allow admin, or regular staff from the same centre, to access them.
        $this->middleware('staff.centre', ['only' => ['edit', 'update', 'destroy']]);
    }

    public function index()
    {
        if (Auth::user()->is_admin)
            $centreStaff = Staff::all();
        else
            $centreStaff = Staff::ofCentres(Auth::user())->get();

        return view('staff.index', compact('centreStaff'));
    }

    public function create()
    {
        $validator = JsValidator::formRequest('App\Http\Requests\CreateStaffRequest');

        $staffType = [false => 'Regular Staff', true => 'Administrator'];

        if (Auth::user()->is_admin)
            $centreList = Centre::all()->lists('name', 'centre_id')->sort();
        else
            $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id')->sort();

        return view('staff.create', compact('validator', 'staffType', 'centreList'));
    }

    public function store(CreateStaffRequest $request)
    {
        $randomString = Str::random();

        $staff = Staff::create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => bcrypt($randomString),
            'is_admin'  => $request->has('admin') ? $request->get('admin') : false,
        ]);

        $staff->centres()->attach($request->get('centres'));

        $email = $staff->email;
        
        Mail::send('emails.welcome_staff', compact('staff', 'randomString'), function ($message) use ($email) {
            $message->from('imchosen6@gmail.com', 'CareGuide Account Registration');
            $message->subject('Your CareGuide Staff account has been created.');
            $message->bcc('imchosen6@gmail.com');
        });

        return redirect('staff')->with('success', 'Staff is added successfully!');
    }

    public function edit($id)
    {
        if (Auth::user()->staff_id == $id && ! Auth::user()->is_admin) {
            return redirect('staff')->withErrors(['You cannot edit your own profile.']);
        }

        $validator = JsValidator::formRequest('App\Http\Requests\EditStaffRequest');

        $staff = Staff::findOrFail($id);
        $staffType = [false => 'Regular Staff', true => 'Administrator'];

        if (Auth::user()->is_admin)
            $centreList = Centre::all()->lists('name', 'centre_id')->sort();
        else
            $centreList = Auth::user()->centres()->get()->lists('name', 'centre_id');

        return view('staff.edit', compact('validator', 'staff', 'staffType', 'centreList'));
    }

    public function update($id, EditStaffRequest $request)
    {
        $staff = Staff::findOrFail($id);

        $staff->update([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'is_admin'  => $request->has('admin') ? $request->get('admin') : false,
        ]);

        $staff->centres()->sync($request->get('centres'));

        return redirect('staff')->with('success', 'Staff is updated successfully!');
    }

    public function destroy($id)
    {
        if (Auth::user()->staff_id != $id) {
            $staff = Staff::findOrFail($id);
            $email = $staff->email;

            Mail::send('emails.remove_staff', compact('staff'), function ($message) use ($email) {
                $message->from('imchosen6@gmail.com', 'CareGuide Account Management');
                $message->subject('Your CareGuide Staff account has been removed.');
                $message->bcc('imchosen6@gmail.com');
            });

            $staff->delete();
            return back()->with('success', 'Staff is removed successfully!');
        } else {
            return redirect('staff')->withErrors(['You cannot remove your own profile.']);
        }
    }
}
