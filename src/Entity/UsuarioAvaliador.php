<?php

namespace App\Entity;

use App\Repository\UsuarioAvaliadorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioAvaliadorRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class UsuarioAvaliador implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telefone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nome = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $areaAtuacao = null;

    /**
     * @var Collection<int, Trabalhos>
     */
    #[ORM\ManyToMany(targetEntity: Trabalhos::class, mappedBy: 'avaliadores')]
    private Collection $trabalhos;

    /**
     * @var Collection<int, Avaliacoes>
     */
    #[ORM\OneToMany(targetEntity: Avaliacoes::class, mappedBy: 'avaliador')]
    private Collection $avaliacoes;

    public function __construct()
    {
        $this->trabalhos = new ArrayCollection();
        $this->avaliacoes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(?string $telefone): static
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getAreaAtuacao(): ?string
    {
        return $this->areaAtuacao;
    }

    public function setAreaAtuacao(?string $areaAtuacao): static
    {
        $this->areaAtuacao = $areaAtuacao;

        return $this;
    }

    /**
     * @return Collection<int, Trabalhos>
     */
    public function getTrabalhos(): Collection
    {
        return $this->trabalhos;
    }

    public function addTrabalho(Trabalhos $trabalho): static
    {
        if (!$this->trabalhos->contains($trabalho)) {
            $this->trabalhos->add($trabalho);
            $trabalho->addAvaliadore($this);
        }

        return $this;
    }

    public function removeTrabalho(Trabalhos $trabalho): static
    {
        if ($this->trabalhos->removeElement($trabalho)) {
            $trabalho->removeAvaliadore($this);
        }

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
            $avaliaco->setAvaliador($this);
        }

        return $this;
    }

    public function removeAvaliaco(Avaliacoes $avaliaco): static
    {
        if ($this->avaliacoes->removeElement($avaliaco)) {
            // set the owning side to null (unless already changed)
            if ($avaliaco->getAvaliador() === $this) {
                $avaliaco->setAvaliador(null);
            }
        }

        return $this;
    }
}
