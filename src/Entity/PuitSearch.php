<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PuitSearch
{
  /**
   *@var string|null
   */
  private $nom;

  /**
   *@var string|null
   */
  private $localisation;

  /**
   *@var User|null
   */
  private $user;


  /**
   *@var string|null
   */
  public function getNom(): ?string
  {
    return $this->nom;
  }

  /**
   *@param string|null $nom
   *@return PuitSearch
   */
  public function setNom(string $nom): PuitSearch
  {
    $this->nom = $nom;
    return $this;
  }

  /**
   *@var string|null
   */
  public function getLocalisation(): ?string
  {
    return $this->localisation;
  }

  /**
   *@param string|null $nom
   *@return PuitSearch
   */
  public function setLocalisation(string $localisation): PuitSearch
  {
    $this->localisation = $localisation;
    return $this;
  }

  /**
   *@var User|null
   */
  public function getUser(): ?User
  {
    return $this->user;
  }

  /**
   *@param User|null $user
   *@return PuitSearch
   */
  public function setUser(User $user): PuitSearch
  {
    $this->user = $user;
    return $this;
  }
}
