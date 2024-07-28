<?php
 
namespace App\Controller;
 
use App\Entity\UsuarioAdministrador;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
 
#[Route('/adm', name: 'adm')]
class RegistrarAdministradorController extends AbstractController
{
    #[Route('/registrar', name: 'registrar_adm', methods: ['POST'])]
    public function registrarAdministrador(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): JsonResponse
    {
        $em = $doctrine->getManager();
        $decoded = json_decode($request->getContent(), true);
        $username = $decoded['username'];
        $password = $decoded['password'];
        $role = $decoded['role']; // Assumindo que o campo 'role' está sendo enviado

        $user = new UsuarioAdministrador();
        $user->setEmail($username);
        $user->setRoles([$role]);
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);
        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'Usuário Administrador registrado com sucesso!']);
    }

}