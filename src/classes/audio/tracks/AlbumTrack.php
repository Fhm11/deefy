<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;



class AlbumTrack extends AudioTrack {
    private string $artiste;
    private string $album;
    private int $annee;
    private int $numpiste;

    public function __construct(string $titre, string $cheminaudio, string $album, int $numpiste) {
        parent::__construct($titre, $cheminaudio);
        $this->album = $album;
        $this->numpiste = $numpiste;
        $this->artiste = "Inconnu";
        $this->annee = 0;
    }

    public function __toString(): string {
        return json_encode([
            'titre' => $this->__get('titre'),
            'artiste' => $this->__get('artiste'),
            'album' => $this->__get('album'),
            'annee' => $this->__get('annee'),
            'numpiste' => $this->__get('numpiste'),
            'genre' => $this->__get('genre'),
            'duree' => $this->__get('duree'),
            'cheminaudio' => $this->__get('cheminaudio')
        ]);
    }

    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new \Exception("invalid property : $name");
    }

    public function setArtiste(string $artiste): void {
        $this->artiste = $artiste;
    }
    public function setAnnee(int $annee): void {
        $this->annee = $annee;
    }
}