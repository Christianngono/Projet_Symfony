<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $pseudo = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Habit::class)]
    private Collection $habits;

    public function __construct()
    {
        $this->habits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    // Ajout des méthodes liées à la relation habits
    /**
     * @return Collection|Habit[]
     */
    public function getHabits(): Collection
    {
        return $this->habits;
    }

    public function addHabit(Habit $habit): self
    {
        if (!$this->habits->contains($habit)) {
            $this->habits[] = $habit;
            $habit->setUser($this);
        }

        return $this;
    }

    public function removeHabit(Habit $habit): self
    {
        if ($this->habits->removeElement($habit)) {
            // set the owning side to null (unless already changed)
            if ($habit->getUser() === $this) {
                $habit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Return an array of roles granted to the user.
     *
     * @see UserInterface
     */

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * Erase sensitive data,  temporary password.
     */

    
    public function eraseCredentials(): void
    {
        // Effacer les données temporaires comme le mot de passe
    }

    public function getSalt(): ?string
    {
        return null;
    }
    /**
     * Returns the username (email).
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    // Implémentation de la méthode getUserIdentifier() requise par UserInterface
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}