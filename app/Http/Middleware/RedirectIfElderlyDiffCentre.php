<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Elderly;

/**
 * Redirection middleware that controls if elderly/senior is accessible.
 *
 * @package App\Http\Middleware
 */
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
            // All elderly that belongs to the centres that the authenticated user is in charge of
            $elderlyInCentres = collect(Elderly::ofCentreForStaff($this->auth->user())->get()->lists('elderly_id'));

            // Redirect user if elderly profile accessed is not in list
            if ( ! $elderlyInCentres->contains($request->route()->parameter('elderly'))) {
                return redirect('/elderly');
            }
        }

        return $next($request);
    }
}
