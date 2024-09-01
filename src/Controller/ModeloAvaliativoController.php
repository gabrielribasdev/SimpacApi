<?php

namespace App\Controller;

use App\Entity\ModeloAvaliativo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrador/modeloavaliativo', name: 'app_modelo_avaliativo')]
class ModeloAvaliativoController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inserir', name: 'app_modelo_avaliativo', methods: ['POST'])]
    public function insertAreaAtuacao(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nome'])) {
            return new JsonResponse(['message' => 'Dados incompletos'], Response::HTTP_BAD_REQUEST);
        }

        $modeloavaliativo = new ModeloAvaliativo();
        $modeloavaliativo->setNome($data['nome']);

        $this->entityManager->persist($modeloavaliativo);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Modelo avaliativo criada com sucesso', 'id' => $modeloavaliativo->getId()], Response::HTTP_CREATED);
    }
}
