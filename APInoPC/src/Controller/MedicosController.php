<?php

namespace App\Controller;

use App\Entity\Medicos;
use App\Helper\MedicoFactory;
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

    /**
     * @var MedicoFactory
     */
    private MedicoFactory $medicoFactory;

    public function __construct(EntityManagerInterface $entityManager, MedicoFactory $medicoFactory){
        $this->entityManager = $entityManager;
        $this->medicoFactory = $medicoFactory;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */

    public function newOne(Request $request): Response
    {
        $bodyRest = $request->getContent();
        $medico = $this->medicoFactory->createMedico($bodyRest);

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

    /**
     * @Route ("/medicos/{id}", methods={"GET"})
     */
    public function getById(int $id, ManagerRegistry $doctrine): Response
    {
        //$repository = $doctrine->getRepository(Medicos::class);
        //$chosed = $repository->find($id);
        $chosed = $this->buscarMedico($id, $doctrine);

        $returnCode = is_null($chosed)? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($chosed, $returnCode);
    }

    /**
     * @Route("/medicos/{id}", methods={"PUT"})
     */
    public function updateUsers(int $id, ManagerRegistry $doctrine, Request $request): Response{

        $bodyRest = $request->getContent();
        $medicoEscolhido = $this->medicoFactory->createMedico($bodyRest);
        $chosedExisted = $this->buscarMedico($id, $doctrine);

        if(is_null($chosedExisted)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $chosedExisted
            ->setCrm($medicoEscolhido->getCrm())
            ->setNome($medicoEscolhido->getNome())
            ->setEspecialidade($medicoEscolhido->getEspecialidade());


        $this->entityManager->flush($chosedExisted);

        return new JsonResponse($chosedExisted);
    }

    /**
     *@Route("/medicos/{id}", methods={"DELETE"})
     */
    public function remover(int $id, ManagerRegistry $doctrine): Response{
        $medico = $this->buscarMedico($id, $doctrine);
        $this->entityManager->remove($medico);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function buscarMedico(int $id, ManagerRegistry $doctrine){
        $repository = $doctrine->getRepository(Medicos::class);
        $medico = $repository->find($id);
        return $medico;
    }

}