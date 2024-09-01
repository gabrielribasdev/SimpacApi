<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendUserCredentials($toEmail, $username, $password, $nome)
    {
        $email = (new Email())
        ->from('Simpac <gabrielribaspdev@gmail.com>')
            ->to($toEmail) 
            ->subject('Suas credenciais de conta')
            ->text("
Olá, $nome!

Voce foi cadastrado como avaliador do projeto Simpac, estamos felizes em fornecer a você o acesso ao nosso sistema de avaliação do Simpac. Abaixo, você encontrará as informações necessárias para fazer login.

Detalhes do Acesso:

- Nome de Usuário (e-mail): $username
- Senha: $password 

Para acessar o sistema, use o nome de usuário e a senha fornecidos. Lembre-se de que a senha é unica, então, por favor, guarde-a com segurança.

Caso precise de assistência adicional ou tenha qualquer dúvida, não hesite em nos contatar.

Obrigado por usar o Simpac!

Por favor, mantenha essas informações seguras e privadas. Se você tiver qualquer problema ou precisar de suporte adicional, nossa equipe está aqui para ajudar.

Atenciosamente,  
Equipe Atomic Code"
);

        $this->mailer->send($email);
    }
}
