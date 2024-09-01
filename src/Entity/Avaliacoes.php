<?php

namespace App\Entity;

use App\Repository\AvaliacoesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvaliacoesRepository::class)]
class Avaliacoes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nota = null;

    #[ORM\ManyToOne(inversedBy: 'avaliacoes')]
    private ?Trabalhos $trabalho = null;

    #[ORM\ManyToOne(inversedBy: 'avaliacoes')]
    private ?usuarioavaliador $avaliador = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNota(): ?int
    {
        return $this->nota;
    }

    public function setNota(?int $nota): static
    {
        $this->nota = $nota;

        return $this;
    }

    public function getTrabalho(): ?Trabalhos
    {
        return $this->trabalho;
    }

    public function setTrabalho(?Trabalhos $trabalho): static
    {
        $this->trabalho = $trabalho;

        return $this;
    }

    public function getAvaliador(): ?usuarioavaliador
    {
        return $this->avaliador;
    }

    public function setAvaliador(?usuarioavaliador $avaliador): static
    {
        $this->avaliador = $avaliador;

        return $this;
    }
}
