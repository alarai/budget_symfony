<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Courant
 *
 * @ORM\Table(name="courant", indexes={@ORM\Index(name="fk_courant_moyen_idx", columns={"moyen"}), @ORM\Index(name="fk_courant_categories_idx", columns={"categorie"}), @ORM\Index(name="fk_courant_oprecur", columns={"op_recur"})})
 * @ORM\Entity
 */
class Courant
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCourant", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcourant;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="valeur", type="float", precision=10, scale=0, nullable=false)
     */
    private $valeur = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="surcompte", type="boolean", nullable=false, options={"default"="-1"})
     */
    private $surcompte = '-1';

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

    /**
     * @var \OpRecur
     *
     * @ORM\ManyToOne(targetEntity="OpRecur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="op_recur", referencedColumnName="idOp_recur")
     * })
     */
    private $opRecur;

    public function getIdcourant(): ?int
    {
        return $this->idcourant;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getSurcompte(): ?bool
    {
        return $this->surcompte;
    }

    public function setSurcompte(bool $surcompte): self
    {
        $this->surcompte = $surcompte;

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

    public function getOpRecur(): ?OpRecur
    {
        return $this->opRecur;
    }

    public function setOpRecur(?OpRecur $opRecur): self
    {
        $this->opRecur = $opRecur;

        return $this;
    }


}
