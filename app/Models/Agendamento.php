<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrutor', 'sala', 'data_inicio', 'data_fim', 'turno', 'user_id', 'equipamentos'
    ];

    // Cast para tratar o campo 'equipamentos' como array
    protected $casts = [
        'equipamentos' => 'array',
    ];

    // Relação com Equipamento (hasOne)
    public function equipamentos()
    {
        return $this->hasOne(Equipamento::class);
    }

    // Relação com o usuário (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relação com os logs de agendamento (hasMany)
    public function logs()
    {
        return $this->hasMany(AgendamentoLog::class);
    }
}
