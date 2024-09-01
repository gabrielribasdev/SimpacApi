<?php


namespace App\Controller;

use App\Entity\AreaAtuacao;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrador/areaatuacao', name: 'app_area_atuacao')]
class AreaAtuacaoController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inserir', name: 'app_insert_area_atuacao', methods: ['POST'])]
    public function insertAreaAtuacao(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Valida os dados recebidos
        if (!isset($data['nome'])) {
            return new JsonResponse(['message' => 'Dados incompletos'], Response::HTTP_BAD_REQUEST);
        }

        $areaatuacao = new AreaAtuacao();
        $areaatuacao->setNome($data['nome']);

        // Persistir e salvar a nova área de atuação
        $this->entityManager->persist($areaatuacao);
        $this->entityManager->flush();

        // Retorna uma resposta adequada
        return new JsonResponse(['message' => 'Área de Atuação criada com sucesso', 'id' => $areaatuacao->getId()], Response::HTTP_CREATED);
    }
}
