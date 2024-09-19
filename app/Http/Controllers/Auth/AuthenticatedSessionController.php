<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'], // Pode ser email ou matrícula
            'password' => ['required', 'string'],
        ]);

        // Verifica se o campo de login é um email ou matrícula
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'matricula';

        // Autentica o usuário
        if (Auth::attempt([
            $fieldType => $request->login,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            // Redirecionar com base no cargo do usuário
            if (Auth::user()->cargo === 'Administrador') {
                return redirect()->route('profile.edit');
            }

            return redirect()->route('profile.edit');
        }

        return back()->withErrors([
            'login' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
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
