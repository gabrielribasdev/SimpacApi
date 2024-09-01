<?php

namespace App\Controller;

use App\Entity\Cursos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrador/cursos', name: 'app_cursos')]
class CursosController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inserir', name: 'app_insert_cursos', methods: ['POST'])]
    public function insertCursos(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nome'])) {
            return new JsonResponse(['message' => 'Dados incompletos'], Response::HTTP_BAD_REQUEST);
        }

        $cursos = new Cursos();
        $cursos->setNome($data['nome']);

        $this->entityManager->persist($cursos);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Cursos criada com sucesso', 'id' => $cursos->getId()], Response::HTTP_CREATED);
    }
}
