<?php

namespace App\Controller;

use App\Entity\Medicos;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedicosController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */

    public function newOne(Request $request): Response
    {
        $bodyRest = $request->getContent();
        $JsonConverter = json_decode($bodyRest);

        $medico = new Medicos();
        $medico->crm = $JsonConverter->crm;
        $medico->nome = $JsonConverter->nome;

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);
    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function getEverything(ManagerRegistry $doctrine): Response
    {

        $repository = $doctrine->getRepository(Medicos::class);
        $products = $repository->findAll();


        return new JsonResponse($products);
    }
}