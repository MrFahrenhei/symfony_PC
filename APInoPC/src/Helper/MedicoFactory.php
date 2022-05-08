<?php

namespace App\Helper;

use App\Entity\Medicos;

class MedicoFactory
{
    public function createMedico(string $json): Medicos
    {
        $JsonConverter = json_decode($json);

        $medico = new Medicos();
        $medico->crm = $JsonConverter->crm;
        $medico->nome = $JsonConverter->nome;

        return $medico;
    }

}