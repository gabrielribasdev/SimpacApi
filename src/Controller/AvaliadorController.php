<?php

// src/Controller/AvaliadorController.php

namespace App\Controller;

use App\Repository\UsuarioAvaliadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrador/avaliadores', name: 'app_avaliadores')]
class AvaliadorController extends AbstractController
{
    private UsuarioAvaliadorRepository $usuarioAvaliadorRepository;

    public function __construct(UsuarioAvaliadorRepository $usuarioAvaliadorRepository)
    {
        $this->usuarioAvaliadorRepository = $usuarioAvaliadorRepository;
    }

    #[Route('/listar', name: 'app_avaliadores_listar')]
    public function buscarAvaliadores(Request $request): JsonResponse
    {
        $page = (int) $request->query->get('pagina', 1);
        $limit = 30;

        // Garantir que a página é positiva
        if ($page < 1) {
            $page = 1;
        }

        $avaliadores = $this->usuarioAvaliadorRepository->findAvaliadoresPaginated($page, $limit);
        $totalCount = $this->usuarioAvaliadorRepository->countAvaliadores();

        $dados = [];

        foreach ($avaliadores as $avaliador) {
            $dados[] = [
                'id' => $avaliador->getId(),
                'nome' => $avaliador->getNome(),
                'email' => $avaliador->getUsername(),
                'telefone' => $avaliador->getTelefone(),
                'areaAtuacao' => $avaliador->getAreaAtuacao(),
            ];
        }

        return $this->json([
            'total' => $totalCount,
            'data' => $dados
        ]);
    }

    #[Route('/id', name: 'app_avaliadores_id')]
    public function buscarAvaliadoresId(Request $request): JsonResponse
    {
        $id = $request->query->get('id');

        $avaliadores = $this->usuarioAvaliadorRepository->findAvaliadoresId($id);

        $avaliador = $avaliadores[0]; 

        $dados = [
            'id' => $avaliador->getId(),
            'nome' => $avaliador->getNome(),
            'email' => $avaliador->getUsername(),
            'telefone' => $avaliador->getTelefone(),
            'areaAtuacao' => $avaliador->getAreaAtuacao(),
        ];

        return $this->json($dados);
    }

    #[Route('/excluir', name: 'app_avaliadores_excluir', methods: ['POST'])]
    public function deleteAvaliador(Request $request): JsonResponse
    {
        // Obtém o corpo da requisição JSON
        $data = json_decode($request->getContent(), true);
        $id = $data['id'] ?? null;
    
        if (!$id) {
            return new JsonResponse(['message' => 'ID não fornecido'], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        // Chama o método de exclusão
        $result = $this->usuarioAvaliadorRepository->deleteById($id);
    
        // Retorna uma resposta adequada
        if ($result) {
            return new JsonResponse(['message' => 'Avaliador excluído com sucesso'], JsonResponse::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Erro ao excluir avaliador'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    }
    

