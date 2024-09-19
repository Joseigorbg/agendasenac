<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrutor', 'sala', 'data_inicio', 'data_fim', 'turno', 'user_id'
    ];

    public function equipamentos()
    {
        return $this->hasOne(Equipamento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
