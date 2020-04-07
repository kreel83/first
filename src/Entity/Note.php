<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecture")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lecture_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Critere")
     * @ORM\JoinColumn(nullable=false)
     */
    private $critere_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getLectureId(): ?Lecture
    {
        return $this->lecture_id;
    }

    public function setLectureId(?Lecture $lecture_id): self
    {
        $this->lecture_id = $lecture_id;

        return $this;
    }

    public function getCritereId(): ?Critere
    {
        return $this->critere_id;
    }

    public function setCritereId(?Critere $critere_id): self
    {
        $this->critere_id = $critere_id;

        return $this;
    }
}
