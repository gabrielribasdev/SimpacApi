<?php

namespace App\Entity;

use App\Repository\TrabalhosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrabalhosRepository::class)]
class Trabalhos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $protocolo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titulo = null;

    #[ORM\ManyToOne]
    private ?AreaAtuacao $area = null;

    #[ORM\ManyToOne]
    private ?cursos $curso = null;

    #[ORM\ManyToOne]
    private ?ModeloAvaliativo $modelo = null;

    /**
     * @var Collection<int, usuarioavaliador>
     */
    #[ORM\ManyToMany(targetEntity: usuarioavaliador::class, inversedBy: 'trabalhos')]
    #[ORM\JoinTable(name: 'avaliacoes_trabalhos')] // Nome personalizado para a tabela de junção

    private Collection $avaliadores;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_cadastro = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_atualizacao = null;

    /**
     * @var Collection<int, Avaliacoes>
     */
    #[ORM\OneToMany(targetEntity: Avaliacoes::class, mappedBy: 'trabalho')]
    private Collection $avaliacoes;

    public function __construct()
    {
        $this->avaliadores = new ArrayCollection();
        $this->avaliacoes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProtocolo(): ?int
    {
        return $this->protocolo;
    }

    public function setProtocolo(?int $protocolo): static
    {
        $this->protocolo = $protocolo;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getArea(): ?AreaAtuacao
    {
        return $this->area;
    }

    public function setArea(?AreaAtuacao $area): static
    {
        $this->area = $area;

        return $this;
    }

    public function getCurso(): ?cursos
    {
        return $this->curso;
    }

    public function setCurso(?cursos $curso): static
    {
        $this->curso = $curso;

        return $this;
    }

    public function getModelo(): ?ModeloAvaliativo
    {
        return $this->modelo;
    }

    public function setModelo(?ModeloAvaliativo $modelo): static
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * @return Collection<int, usuarioavaliador>
     */
    public function getAvaliadores(): Collection
    {
        return $this->avaliadores;
    }

    public function addAvaliadore(usuarioavaliador $avaliadore): static
    {
        if (!$this->avaliadores->contains($avaliadore)) {
            $this->avaliadores->add($avaliadore);
        }

        return $this;
    }

    public function removeAvaliadore(usuarioavaliador $avaliadore): static
    {
        $this->avaliadores->removeElement($avaliadore);

        return $this;
    }

    public function getDataCadastro(): ?\DateTimeInterface
    {
        return $this->data_cadastro;
    }

    public function setDataCadastro(?\DateTimeInterface $data_cadastro): static
    {
        $this->data_cadastro = $data_cadastro;

        return $this;
    }

    public function getDataAtualizacao(): ?\DateTimeInterface
    {
        return $this->data_atualizacao;
    }

    public function setDataAtualizacao(?\DateTimeInterface $data_atualizacao): static
    {
        $this->data_atualizacao = $data_atualizacao;

        return $this;
    }

    /**
     * @return Collection<int, Avaliacoes>
     */
    public function getAvaliacoes(): Collection
    {
        return $this->avaliacoes;
    }

    public function addAvaliaco(Avaliacoes $avaliaco): static
    {
        if (!$this->avaliacoes->contains($avaliaco)) {
            $this->avaliacoes->add($avaliaco);
            $avaliaco->setTrabalho($this);
        }

        return $this;
    }

    public function removeAvaliaco(Avaliacoes $avaliaco): static
    {
        if ($this->avaliacoes->removeElement($avaliaco)) {
            // set the owning side to null (unless already changed)
            if ($avaliaco->getTrabalho() === $this) {
                $avaliaco->setTrabalho(null);
            }
        }

        return $this;
    }

}
