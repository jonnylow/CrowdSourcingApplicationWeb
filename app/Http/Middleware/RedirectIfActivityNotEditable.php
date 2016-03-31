<?php

namespace App\Http\Middleware;

use App\Activity;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfActivityNotEditable
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
        $activity = Activity::findOrFail($request->route()->parameter('activities'));

        if (str_contains($activity->getApplicationStatus(), 'No application') && ! $activity->datetime_start->isToday()) {
            return $next($request);
        }

        return redirect('/activities');
    }
}
