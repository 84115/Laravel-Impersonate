<?php

namespace J84115\Impersonate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImpersonateController extends Controller
{
    private string $route = 'dashboard';

    /**
     * Impersonate a user.
     */
    public function login(Request $request, $uid)
    {
        $me = $request->user();

        if ($me->id == $uid) {
            return redirect()->route($this->route);
        }

        $userModel = get_class($request->user());
        $user = $userModel::findOrFail($uid);

        if (! $user->impersonatable()) {
            return redirect()->route($this->route);
        }

        session([
            'impersonate' => [
                'id' => $uid,
                'name' => $user->name,
                'email' => $user->email
            ],
            'impersonator' => $me->id
        ]);

        return redirect()->route($this->route);
    }

    /**
     * Stop impersonating.
     */
    public function logout()
    {
        $impersonateAs = session('impersonate.id');

        if ($impersonateAs) {
            session([
                'impersonate' => null,
                'impersonator' => null
            ]);

            return redirect()->route($this->route);
        }

        return redirect()->route($this->route);
    }
}
