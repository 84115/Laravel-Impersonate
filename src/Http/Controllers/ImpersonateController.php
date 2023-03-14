<?php

namespace J84115\Impersonate\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class ImpersonateController extends Controller
{
    /**
     * Impersonate as a user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, $uid)
    {
        $me = auth()->user();

        if ($me->id == $uid) {
            return response()->json(['impersonate' => false, 'error' => ['message' => 'You cannot masquerade as yourself!']], 400);
        }

        // check the user actually exists
        $user = User::findOrFail($uid);

        // WIP
        // $this->authorize('masquerade', $user);

        // WIP
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

        return response()->json(['impersonate' => true, 'redirect' => route('dashboard')]);
    }

    /**
     * Stop impersonate.
     *
     * @return \Illuminate\Http\JsonResponse
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
