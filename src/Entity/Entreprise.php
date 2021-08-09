<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Experience::class, mappedBy="entreprise")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    public function __construct()
    {
        $this->nom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Experience[]
     */
    public function getNom(): Collection
    {
        return $this->nom;
    }

    public function addNom(Experience $nom): self
    {
        if (!$this->nom->contains($nom)) {
            $this->nom[] = $nom;
            $nom->setEntreprise($this);
        }

        return $this;
    }

    public function removeNom(Experience $nom): self
    {
        if ($this->nom->removeElement($nom)) {
            // set the owning side to null (unless already changed)
            if ($nom->getEntreprise() === $this) {
                $nom->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
