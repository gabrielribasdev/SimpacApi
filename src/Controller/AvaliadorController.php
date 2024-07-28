<?php

namespace App\Controller;

use App\Repository\UsuarioAvaliadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function buscarAvaliadores(): JsonResponse
    {
        $avaliadores = $this->usuarioAvaliadorRepository->findAllAvaliadores();

        $dados = [];

        foreach ($avaliadores as $avaliador) {
            $dados[] = [
                'id' => $avaliador->getId(),
                'nome' => $avaliador->getNome(), 
                'email' => $avaliador->getUsername(), 
                'telefone' => $avaliador->getTelefone(), 
                'cidade' => $avaliador->getCidade(), 
            ];
        }

        return $this->json($dados);
    }
}
