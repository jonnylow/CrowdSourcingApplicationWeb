<?php

namespace App\Http\Middleware;

use App\Activity;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfActivityDiffCentre
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
            $activitiesInCentres = collect(Activity::ofCentreForStaff($this->auth->user())->get()->lists('activity_id'));

            if ( ! $activitiesInCentres->contains($request->route()->parameter('activities'))) {
                return redirect('/activities');
            }
        }

        return $next($request);
    }
}
