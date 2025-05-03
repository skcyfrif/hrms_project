<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $url = '';


        if($request->user()->role === 'admin'){
            $url = 'admin/dashboards';
        }elseif($request->user()->role === 'agent'){
            $url =  'agent/dashboard';
        }elseif($request->user()->role === 'user'){
            $url =  'employee/dashboards';
        }elseif($request->user()->role === 'head'){
            $url =  'hr_head/dashboards';
        }elseif($request->user()->role === 'manager'){
            $url =  'hr_manager/dashboards';
        }
        elseif($request->user()->role === 'reportmanager'){
            $url =  'report_managers/dashboards';
        };

        // return redirect()->intended(route('dashboard', absolute: false));
        return redirect()->intended($url);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
