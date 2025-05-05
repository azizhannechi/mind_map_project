<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->route('home');
        }

        return redirect()->route('login')->with('error', 'Identifiants incorrects.');
    }
}
