<?php 
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exception\InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException;



class AudioTrack {
    public int $id;

    protected string $titre;
    protected string $auteur;
    protected string $genre;
    protected int $duree;
    protected string $cheminaudio;

    public function __construct(string $titre, string $cheminaudio) {
        $this->titre = $titre;
        $this->cheminaudio = $cheminaudio;
        $this->auteur = "Inconnu";
        $this->genre = "Inconnu";
        $this->duree = 0;
    }

    public function __get($name) {
        if (!is_string($name) || $name === '') {
            throw new InvalidPropertyNameException("invalid property : $name");
        }
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException("invalid property : $name");
    }

    public function setAuteur(string $auteur): void {
        $this->auteur = $auteur;
    }
    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }
    public function setDuree(int $duree): void {
        if ($duree < 0) {
            throw new InvalidPropertyValueException("invalid value for duree: $duree");
        }
        $this->duree = $duree;
    }

}
