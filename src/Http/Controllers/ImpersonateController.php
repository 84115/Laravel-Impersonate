<?php

namespace J84115\Impersonate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImpersonateController extends Controller
{
    /**
     * Impersonate a user.
     */
    public function login(Request $request, $uid)
    {
        $me = $request->user();

        if ($me->id == $uid) {
            return response()->json([
                'impersonate' => false,
                'error' => [
                    'message' => 'You cannot masquerade as yourself!'
                ]
            ], 400);
        }

        // check the user actually exists
        $userModel = get_class($request->user());
        $user = $userModel::findOrFail($uid);

        // TODO
        // $this->authorize('masquerade', $user);

        // TODO
        // if ($user->admin) {
        //     return response()->json(['impersonate' => false, 'error' => ['message' => 'You cannot masquerade as another admin!']], 400);
        // }

        session([
            'impersonate' => [
                'id' => $uid,
                'name' => $user->name,
                'email' => $user->email
            ],
            'impersonator' => $me->id
        ]);

        return response()->json([
            'impersonate' => true,
            'redirect' => route('dashboard')
        ]);
    }

    /**
     * Stop impersonating.
     */
    public function logout()
    {
        $impersonateAs = session('impersonate.id');

        if ($impersonateAs) {
            session(['impersonate' => null, 'impersonator' => null]);

            return redirect()->route('dashboard', $impersonateAs);
        }

        return redirect()->route('dashboard');
    }
}
