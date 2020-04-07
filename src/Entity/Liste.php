<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListeRepository")
 */
class Liste
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Livre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livre_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Theme", inversedBy="listes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivreId(): ?Livre
    {
        return $this->livre_id;
    }

    public function setLivreId(?Livre $livre_id): self
    {
        $this->livre_id = $livre_id;

        return $this;
    }

    public function getThemeId(): ?Theme
    {
        return $this->theme_id;
    }

    public function setThemeId(?Theme $theme_id): self
    {
        $this->theme_id = $theme_id;

        return $this;
    }
}
