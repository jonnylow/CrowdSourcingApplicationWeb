<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Elderly;

class RedirectIfElderlyDiffCentre
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
            $elderlyInCentres = collect(Elderly::ofCentreForStaff($this->auth->user())->get()->lists('elderly_id'));

            if ( ! $elderlyInCentres->contains($request->route()->parameter('elderly'))) {
                return redirect('/elderly');
            }
        }

        return $next($request);
    }
}
