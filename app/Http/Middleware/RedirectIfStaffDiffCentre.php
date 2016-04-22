<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Staff;

/**
 * Redirection middleware that controls if staff is accessible.
 *
 * @package App\Http\Middleware
 */
class RedirectIfStaffDiffCentre
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! $this->auth->user()->is_admin) {
            // All staff that belongs to the centres that the authenticated user is in charge of
            $centreStaff = collect(Staff::ofCentres($this->auth->user())->get()->lists('staff_id'));

            // Redirect user if staff profile accessed is not in list
            if ( ! $centreStaff->contains($request->route()->parameter('staff'))) {
                return redirect('/staff');
            }
        }

        return $next($request);
    }
}
