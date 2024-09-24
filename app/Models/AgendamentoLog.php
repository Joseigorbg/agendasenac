<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendamentoLog extends Model
{
    use HasFactory;

    protected $fillable = ['agendamento_id', 'user_id', 'action', 'description'];

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
