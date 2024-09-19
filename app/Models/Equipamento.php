<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'agendamento_id', 'notebooks', 'projetor', 'camera_fotografica', 'tripe',
        'fonte_caixa_som', 'microfone', 'caneta_quadro_interativo', 'controle_tv', 'controle_projetor'
    ];

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class);
    }
}
