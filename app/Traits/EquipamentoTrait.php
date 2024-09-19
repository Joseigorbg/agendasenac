<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait EquipamentoTrait
{
    /**
     * Captura os equipamentos a partir da requisição.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function capturaEquipamentos(Request $request): array
    {
        $equipamentos = [];

        $listaEquipamentos = [
            'notebooks',
            'projetor',
            'camera_fotografica',
            'tripe',
            'fonte_caixa_som',
            'microfone',
            'caneta_quadro_interativo',
            'controle_tv',
            'controle_projetor'
        ];

        foreach ($listaEquipamentos as $equipamento) {
            $equipamentos[$equipamento] = $request->has($equipamento) ? 1 : 0;
        }

        return $equipamentos;
    }
}
