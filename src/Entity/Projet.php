<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etatAvancement = null;

    #[ORM\ManyToMany(targetEntity: Chercheur::class, mappedBy: 'chercheurprojet')]
    private Collection $chercheurs;

    #[ORM\ManyToMany(targetEntity: Chercheur::class, inversedBy: 'projets')]
    private Collection $projetcherche;

    public function __construct()
    {
        $this->chercheurs = new ArrayCollection();
        $this->projetcherche = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getEtatAvancement(): ?string
    {
        return $this->etatAvancement;
    }

    public function setEtatAvancement(?string $etatAvancement): static
    {
        $this->etatAvancement = $etatAvancement;

        return $this;
    }

    /**
     * @return Collection<int, Chercheur>
     */
    public function getChercheurs(): Collection
    {
        return $this->chercheurs;
    }

    public function addChercheur(Chercheur $chercheur): static
    {
        if (!$this->chercheurs->contains($chercheur)) {
            $this->chercheurs->add($chercheur);
            $chercheur->addChercheurprojet($this);
        }

        return $this;
    }

    public function removeChercheur(Chercheur $chercheur): static
    {
        if ($this->chercheurs->removeElement($chercheur)) {
            $chercheur->removeChercheurprojet($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Chercheur>
     */
    public function getProjetcherche(): Collection
    {
        return $this->projetcherche;
    }

    public function addProjetcherche(Chercheur $projetcherche): static
    {
        if (!$this->projetcherche->contains($projetcherche)) {
            $this->projetcherche->add($projetcherche);
        }

        return $this;
    }

    public function removeProjetcherche(Chercheur $projetcherche): static
    {
        $this->projetcherche->removeElement($projetcherche);

        return $this;
    }
}
