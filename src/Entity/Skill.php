<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="skills")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $likeOrNot;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    public function getLikeOrNot(): ?bool
    {
        return $this->likeOrNot;
    }

    public function setLikeOrNot(bool $likeOrNot): self
    {
        $this->likeOrNot = $likeOrNot;

        return $this;
    }
    public function __toString()
    {
        if($this->getLikeOrNot() == 1){
            $likeOrNot = "Like";
        } else {
            $likeOrNot= 'Don\'t Like';
        }
        return $this->getNom() . ", niveau:  " . $this->getNiveau() . ", " . $likeOrNot;
    }
}
