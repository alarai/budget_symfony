<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moyen
 *
 * @ORM\Table(name="moyen")
 * @ORM\Entity
 */
class Moyen
{
    /**
     * @var int
     *
     * @ORM\Column(name="idMoyen", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmoyen;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=false)
     */
    private $nom;

    public function getIdmoyen(): ?int
    {
        return $this->idmoyen;
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


}
