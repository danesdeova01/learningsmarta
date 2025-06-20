<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override: Redirect setelah login berdasarkan level user.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->level === 'admin' || $user->level === 'guru') {
            return redirect()->route('home');
        } else {
            return redirect()->route('welcome');
        }
    }
}
