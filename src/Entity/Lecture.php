<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LectureRepository")
 */
class Lecture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debutLecture;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $finLecture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $indice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $decouverte;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Livre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebutLecture(): ?\DateTimeInterface
    {
        return $this->debutLecture;
    }

    public function setDebutLecture(\DateTimeInterface $debutLecture): self
    {
        $this->debutLecture = $debutLecture;

        return $this;
    }

    public function getFinLecture(): ?\DateTimeInterface
    {
        return $this->finLecture;
    }

    public function setFinLecture(?\DateTimeInterface $finLecture): self
    {
        $this->finLecture = $finLecture;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getIndice(): ?float
    {
        return $this->indice;
    }

    public function setIndice(?float $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDecouverte(): ?int
    {
        return $this->decouverte;
    }

    public function setDecouverte(?int $decouverte): self
    {
        $this->decouverte = $decouverte;

        return $this;
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivreId(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }
}
