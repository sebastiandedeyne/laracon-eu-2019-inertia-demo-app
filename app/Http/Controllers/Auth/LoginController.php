<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/posts';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()
            ->intended($this->redirectPath())
            ->with('success', 'Welcome, ' . $user->name . '!');
    }

    protected function loggedOut(Request $request)
    {
        return redirect('login')->with('success', 'Goodbye!');
    }
}
