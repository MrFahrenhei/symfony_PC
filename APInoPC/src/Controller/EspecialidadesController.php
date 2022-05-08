<?php

namespace App\Controller;

use App\Entity\Especialidade;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/especialidade", methods={"POST"})
     */
    public function nova(Request $request): Response
    {
       $dadosRequest = $request->getContent();
       $jsonData = json_decode($dadosRequest);

       $especialidade = new Especialidade();
       $especialidade->setDescricao($jsonData->descricao);

       $this->entityManager->persist($especialidade);
       $this->entityManager->flush();

       return new JsonResponse($especialidade);
    }
}
