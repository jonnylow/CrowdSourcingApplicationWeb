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

/**
 * Resource controller that handles the logic when managing staff.
 *
 * @package App\Http\Controllers\Staff
 */
class StaffController extends Controller
{
    /**
     * Instantiate a new StaffController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply the staff.centre middleware to only edit, update and destroy methods.
        // We only allow admin, or regular staff from the same centre, to access them.
        $this->middleware('staff.centre', ['only' => ['edit', 'update', 'destroy']]);
    }

    /**
     * Show the index page for all staff.
     * Responds to requests to GET /staff
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->is_admin)
            $centreStaff = Staff::all();
        else
            $centreStaff = Staff::ofCentres(Auth::user())->get();

        return view('staff.index', compact('centreStaff'));
    }

    /**
     * Show the form to add a new staff.
     * Responds to requests to GET /staff/create
     *
     * @return Response
     */
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

    /**
     * Store a new staff.
     * Responds to requests to POST /staff
     *
     * @param  \App\Http\Requests\CreateStaffRequest  $request
     * @return Response
     */
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
            $message->subject('Your CareGuide Staff account has been created.');
            $message->bcc('imchosen6@gmail.com');
        });

        return redirect('staff')->with('success', 'Staff is added successfully!');
    }

    /**
     * Show the form to edit a staff.
     * Responds to requests to GET /staff/{id}/edit
     *
     * @param  int  $id  the ID of the staff
     * @return Response
     */
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

    /**
     * Update an existing staff.
     * Responds to requests to PUT /staff/{id}
     *
     * @param  int  $id  the ID of the staff
     * @param  \App\Http\Requests\EditStaffRequest  $request
     * @return Response
     */
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

    /**
     * Delete an staff.
     * Responds to requests to DELETE /staff/{id}
     *
     * @param  int  $id  the ID of the staff
     * @return Response
     */
    public function destroy($id)
    {
        if (Auth::user()->staff_id != $id) {
            $staff = Staff::findOrFail($id);
            $email = $staff->email;

            Mail::send('emails.remove_staff', compact('staff'), function ($message) use ($email) {
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
