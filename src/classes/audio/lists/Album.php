<?php

declare(strict_types=1);

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack;



class Album extends AudioList {
    private string $artiste;
    private string $dateSortie;

    public function __construct(string $nom, array $pistes, string $artiste = '', string $dateSortie = '') {
        if (empty($pistes)) {
            throw new \Exception('Un album doit contenir au moins une piste.');
        }
        parent::__construct($nom, $pistes);
        $this->artiste = $artiste;
        $this->dateSortie = $dateSortie;
    }

    public function setArtiste(string $artiste): void {
        $this->artiste = $artiste;
    }
    public function setDateSortie(string $dateSortie): void {
        $this->dateSortie = $dateSortie;
    }

    public function __get($name) {
        if ($name === 'artiste') return $this->artiste;
        if ($name === 'dateSortie') return $this->dateSortie;
        return parent::__get($name);
    }
}
