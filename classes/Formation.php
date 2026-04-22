<?php

class Formation
{
    // Attributs
    private int $id;
    private string $intitule;
    private int $nbMois;
    private string $dateDebut;

    // Constructeur
    public function __construct(int $unId, string $unIntitule, int $unNbMois, string $uneDateDebut)
    {
        $this->id = $unId;
        $this->intitule = $unIntitule;
        $this->nbMois = $unNbMois;
        $this->dateDebut = $uneDateDebut;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getIntitule(): string
    {
        return $this->intitule;
    }
    public function getNbMois(): int
    {
        return $this->nbMois;
    }
    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    // Setters
    public function setId(int $unId): void
    {
        $this->id = $unId;
    }
    public function setIntitule(string $unIntitule): void
    {
        $this->intitule = $unIntitule;
    }
    public function setNbMois(int $unNbMois): void
    {
        $this->nbMois = $unNbMois;
    }
    public function setDateDebut(string $uneDateDebut): void
    {
        $this->dateDebut = $uneDateDebut;
    }

    // To string
    public function __toString(): string
    {
        return "Formation : " . $this->intitule . " (" . $this->nbMois . " mois)";
    }

    //metode
    public function getDateDebutFormatee(): string
    {
        $date = new DateTime($this->dateDebut);
        return $date->format('d/m/Y');
    }
}
