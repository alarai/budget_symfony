<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OpRecur
 *
 * @ORM\Table(name="op_recur", indexes={@ORM\Index(name="fk_oprecur_moyen_idx", columns={"moyen"}), @ORM\Index(name="fk_oprecur_categories_idx", columns={"categorie"})})
 *
 * @ORM\Entity(repositoryClass="App\Repository\OpRecurRepository")
 */
class OpRecur implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="idOp_recur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idopRecur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=false)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="valeur", type="float", precision=10, scale=0, nullable=false)
     * @Assert\Type(type="float")
     */
    private $valeur = '0';

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="idCategories")
     * })
     */
    private $categorie;

    /**
     * @var \Moyen
     *
     * @ORM\ManyToOne(targetEntity="Moyen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="moyen", referencedColumnName="idMoyen")
     * })
     */
    private $moyen;

    public function __construct()
    {
        return $this->valeur = null;
    }

    public function getIdopRecur(): ?int
    {
        return $this->idopRecur;
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

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getMoyen(): ?Moyen
    {
        return $this->moyen;
    }

    public function setMoyen(?Moyen $moyen): self
    {
        $this->moyen = $moyen;

        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'idopRecur' => $this->idopRecur,
            'nom' => $this->nom,
            'valeur' => $this->valeur,
            'nomMoyen' => $this->getMoyen()->getNom(),
            'nomCategorie' => $this->getCategorie()->getNom(),
        );
    }
}
