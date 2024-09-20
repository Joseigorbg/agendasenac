<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Agendamento;

class AgendamentoPolicy
{
    public function update(User $user, Agendamento $agendamento)
    {
        // Permite se o usuário for dono do agendamento ou se for administrador
        return $user->id === $agendamento->user_id || $user->role === 'admin';
    }
    
    public function delete(User $user, Agendamento $agendamento)
    {
        // Permite se o usuário for dono do agendamento ou se for administrador
        return $user->id === $agendamento->user_id || $user->role === 'admin';
    }
    
}
