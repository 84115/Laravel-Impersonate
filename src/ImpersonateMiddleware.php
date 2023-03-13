<?php

namespace J84115\Impersonate;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\User;

class ImpersonateMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Array of routes to not impersonate on.
     *
     * @var array
     */
    protected $except = [];

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new filter instance.
     */
    public function __construct(Guard $auth, Request $request)
    {
        $this->auth = $auth;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (! $this->shouldIgnore() && null !== session('masquerading')) {
            $this->auth->setUser(User::find(session('masquerading.id')));
        }

        return $next($request);
    }

    /**
     * Should we ignore this request?
     */
    protected function shouldIgnore(): bool
    {
        foreach ($this->except as $except) {
            if ($this->request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
