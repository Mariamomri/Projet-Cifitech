<?php

class Stagiaire
{
    // Attributs
    private int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $dateNaissance;

    // Constructeur
    public function __construct(int $unId, string $unNom, string $unPrenom, string $unEmail, string $uneDateNaissance)
    {
        $this->id = $unId;
        $this->nom = $unNom;
        $this->prenom = $unPrenom;
        $this->email = $unEmail;
        $this->dateNaissance = $uneDateNaissance;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    // Setters
    public function setId(int $unId): void
    {
        $this->id = $unId;
    }
    public function setNom(string $unNom): void
    {
        $this->nom = $unNom;
    }
    public function setPrenom(string $unPrenom): void
    {
        $this->prenom = $unPrenom;
    }
    public function setEmail(string $unEmail): void
    {
        $this->email = $unEmail;
    }
    public function setDateNaissance(string $uneDateNaissance): void
    {
        $this->dateNaissance = $uneDateNaissance;
    }

    // To string
    public function __toString(): string
    {
        return $this->prenom . " " . $this->nom . " (" . $this->email . ")";
    }

    // metode
    public function getDateNaissanceFormatee(): string
    {
        $date = new DateTime($this->dateNaissance);
        return $date->format('d/m/Y');
    }

    // Calcul de l'âge
    public function getAge(): int
    {
        $aujourdhui = new DateTime();
        $naissance = new DateTime($this->dateNaissance);
        return $aujourdhui->diff($naissance)->y;
    }
}
