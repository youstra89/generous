<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity(repositoryClass="App\Repository\UserRepository")
* @ORM\Table(name="user")
* @UniqueEntity(fields="email", message="Ce email est déjà pris")
* @UniqueEntity(fields="username", message="Ce nom d'utilisateur est déjà pris")
*/
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $password_changed_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $password_reset_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Puit", mappedBy="user")
     */
    private $puits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mosquee", mappedBy="user")
     */
    private $mosquees;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $donnateur;


    public function __construct()
    {
      $this->created_at = new \Datetime();
      $this->enabled = false;
      $this->donnateur = true;
      $this->roles = array_unique(['ROLE_USER']);
      $this->puits = new ArrayCollection();
      $this->mosquees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPasswordChangedAt(): ?\DateTimeInterface
    {
        return $this->password_changed_at;
    }

    public function setPasswordChangedAt(?\DateTimeInterface $password_changed_at): self
    {
        $this->password_changed_at = $password_changed_at;

        return $this;
    }

    public function getPasswordResetAt(): ?\DateTimeInterface
    {
        return $this->password_reset_at;
    }

    public function setPasswordResetAt(?\DateTimeInterface $password_reset_at): self
    {
        $this->password_reset_at = $password_reset_at;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Retour le salt qui a servi à coder le mot de passe
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // Nous n'avons pas besoin de cette methode car nous n'utilions pas de plainPassword
        // Mais elle est obligatoire car comprise dans l'interface UserInterface
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return Collection|Puit[]
     */
    public function getPuits(): Collection
    {
        return $this->puits;
    }

    public function addPuit(Puit $puit): self
    {
        if (!$this->puits->contains($puit)) {
            $this->puits[] = $puit;
            $puit->setUser($this);
        }

        return $this;
    }

    public function removePuit(Puit $puit): self
    {
        if ($this->puits->contains($puit)) {
            $this->puits->removeElement($puit);
            // set the owning side to null (unless already changed)
            if ($puit->getUser() === $this) {
                $puit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mosquee[]
     */
    public function getMosquees(): Collection
    {
        return $this->mosquees;
    }

    public function addMosquee(Mosquee $mosquee): self
    {
        if (!$this->mosquees->contains($mosquee)) {
            $this->mosquees[] = $mosquee;
            $mosquee->setUser($this);
        }

        return $this;
    }

    public function removeMosquee(Mosquee $mosquee): self
    {
        if ($this->mosquees->contains($mosquee)) {
            $this->mosquees->removeElement($mosquee);
            // set the owning side to null (unless already changed)
            if ($mosquee->getUser() === $this) {
                $mosquee->setUser(null);
            }
        }

        return $this;
    }

    public function getDonnateur(): ?bool
    {
        return $this->donnateur;
    }

    public function setDonnateur(?bool $donnateur): self
    {
        $this->donnateur = $donnateur;

        return $this;
    }
}
