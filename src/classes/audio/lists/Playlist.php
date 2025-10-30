<?php

declare(strict_types=1);

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack;

class Playlist extends AudioList {
    public ?int $id = null; 
    public string $nom;

    public function ajouterPiste(AudioTrack $piste): void {
        $this->pistes[] = $piste;
        $this->nbPistes++;
        $this->dureeTotale += $piste->duree;
    }

    public function supprimerPiste(int $indice): void {
        if (isset($this->pistes[$indice])) {
            $this->dureeTotale -= $this->pistes[$indice]->duree;
            array_splice($this->pistes, $indice, 1);
            $this->nbPistes = count($this->pistes);
        }
    }

    public function ajouterListePistes(array $liste): void {
        foreach ($liste as $piste) {
            if ($piste instanceof AudioTrack && !in_array($piste, $this->pistes, true)) {
                $this->pistes[] = $piste;
                $this->nbPistes++;
                $this->dureeTotale += $piste->duree;
            }
        }
    }
}
