<?php

namespace App\Helper;

use App\Entity\Medicos;
use App\Repository\EspecialidadeRepository;

class MedicoFactory
{
    /**
     * @var EspecialidadeRepository
     */
    private $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function createMedico(string $json): Medicos
    {
        $JsonConverter = json_decode($json);
        $especialidadeID = $JsonConverter->especialidadeId;
        $especialidade = $this->especialidadeRepository->find($especialidadeID);

        $medico = new Medicos();
        $medico
            ->setCrm($JsonConverter->crm)
            ->setNome($JsonConverter->nome)
            ->setEspecialidade($especialidade);

        return $medico;
    }

}