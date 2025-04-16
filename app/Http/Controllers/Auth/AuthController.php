<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Device;

class AuthController extends Controller
{
    /**
     * Write code on Method
     * 
     * #return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }
    /**
     * Write code on Method
     * 
     * #return response()
     */
    public function register(): View
    {
        return view('auth.register');
    }
    /**
     * Write code on Method
     * 
     * #return response()
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('home')->with('success', 'Login successful');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }
    /**
     * Write code on Method
     * 
     * #return response()
     */
    public function registerUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = $request->all();
        $user = $this->create($data);
        Auth::login($user);
        return redirect()->intended('login')->with('success', 'Registration successful');   
    }
    /**
     * Write code on Method
     * 
     * #return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            $devices = Device::with('item')->paginate(10);
            return view('dashboard.home', compact('devices'));
        }
        return redirect('login')->with('error', 'You are not allowed to access');
    }
    /**
     * Write code on Method
     * 
     * #return response()
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return redirect('login')->with('success', 'Logout successful');
    }
    /**
     * Write code on Method
     * 
     * #return response()
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
