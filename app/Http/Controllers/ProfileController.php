<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Agendamento;

class ProfileController extends Controller
{
    /**
     * Exibir o formulário de perfil do usuário.
     */
    public function edit(Request $request): View
    {
        // Obtém o usuário logado
        $user = $request->user();
    
        // Obtém os agendamentos relacionados ao usuário logado
        $agendamentos = Agendamento::where('user_id', $user->id)->get();
    
        return view('profile.edit', [
            'user' => $user,
            'agendamentos' => $agendamentos, // Passa os agendamentos para a view
        ]);
    }

    /**
     * Atualizar as informações do perfil do usuário.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
            // Adicione outras validações conforme necessário
        ]);

        $user = $request->user();
        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Deletar a conta do usuário.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
