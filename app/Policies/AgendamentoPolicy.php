<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Agendamento;

class AgendamentoPolicy
{
    public function update(User $user, Agendamento $agendamento)
    {
        // Permite se o usuário for dono do agendamento
        return $user->id === $agendamento->user_id;
    }

    public function delete(User $user, Agendamento $agendamento)
    {
        // Permite se o usuário for dono do agendamento
        return $user->id === $agendamento->user_id;
    }
}
