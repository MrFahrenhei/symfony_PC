<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadesController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var EspecialidadeRepository
     */
    private EspecialidadeRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, EspecialidadeRepository $repository)
    {

        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/especialidades", methods={"POST"})
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

    /**
     * @Route("/especialidades", methods={"GET"})
     */
    public function getEverything(): Response
    {
        $espList = $this->repository->findAll();


        return new JsonResponse($espList);
    }

    /**
     * @Route ("/especialidades/{id}", methods={"GET"})
     */
    public function getById(int $id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Especialidade::class);
        $chosed = $repository->find($id);

        $returnCode = is_null($chosed)? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($chosed, $returnCode);
    }

    /**
     * @Route("/especialidades/{id}", methods={"PUT"})
     */
    public function updateEsp(int $id, Request $request): Response{
        $dadosRequest = $request->getContent();
        $jsonData = json_decode($dadosRequest);

        $especialidade = $this->repository->find($id);
        $especialidade->setDescricao($jsonData->descricao);

        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/especialidades/{id}", methods={"DELETE"})
     */
    public function remover(int $id): Response
    {
        $especialidade = $this->repository->find($id);
        $this->entityManager->remove($especialidade);
        $this->entityManager->flush();

        return new Response(' ', Response::HTTP_NO_CONTENT);

    }
}
