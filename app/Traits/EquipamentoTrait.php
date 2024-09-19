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
            // Captura a quantidade do equipamento diretamente, com o valor padrão sendo 0
            $quantidade = $request->input("equipamentos.{$equipamento}.quantity", 0);  
            $equipamentos[$equipamento] = [
                'quantity' => is_numeric($quantidade) ? (int) $quantidade : 0,  // Garante que seja numérico, senão usa 0
            ];
        }
        
        return $equipamentos;
    }
}
