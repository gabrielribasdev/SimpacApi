<?php

namespace App\Controller;

use App\Entity\UsuarioAvaliador;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/administrador/avaliador', name: 'avaliador')]
class RegistrarAvaliadorController extends AbstractController
{
    
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/registrar', name: 'registrar_avaliador', methods: ['POST'])]
    public function registrarAvaliador(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): JsonResponse
    {
        set_time_limit(0);
        $em = $doctrine->getManager();
        $decoded = json_decode($request->getContent(), true);
        $username = $decoded['username']; 
        $password = $decoded['password'];
        $role = $decoded['role']; 
        $nome = $decoded['nome']; 
        $telefone = $decoded['telefone']; 
        $areaAtuacao = $decoded['areaAtuacao']; 

        $user = new UsuarioAvaliador();
        $user->setUsername($username); 
        $user->setRoles([$role]);
        $user->setNome($nome);
        $user->setTelefone($telefone);
        $user->setAreaAtuacao($areaAtuacao);
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);
        $em->persist($user);
        $em->flush();

        $this->emailService->sendUserCredentials($username, $username, $password, $nome);

        return $this->json(['message' => 'Usuário Avaliador registrado com sucesso!']);
    }
}
