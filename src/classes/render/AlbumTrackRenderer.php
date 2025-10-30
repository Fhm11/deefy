<?php
declare(strict_types=1);

namespace iutnc\deefy\render;



class AlbumTrackRenderer extends AudioTrackRenderer {
    private \iutnc\deefy\audio\tracks\AlbumTrack $track;
    
    public function __construct(\iutnc\deefy\audio\tracks\AlbumTrack $track) {
        $this->track = $track;
    }


    protected function renderCompact(): string {
        $p = $this->track;
        return "<div>{$p->titre} by {$p->artiste} (from {$p->album})</div>";
    }

    protected function renderLong(): string {
        $p = $this->track;
        $html = "<div>";
        $html .= "Titre : {$p->titre}<br>";
        $html .= "Artiste : {$p->artiste}<br>";
        $html .= "Album : {$p->album}<br>";
        $html .= "Piste n° : {$p->numpiste}<br>";
        $html .= "Année : {$p->annee}<br>";
        $html .= "Genre : {$p->genre}<br>";
        $html .= "Durée : {$p->duree} sec<br>";
        $html .= "Chemin audio : {$p->cheminaudio}<br>";
        $html .= "</div>";
        return $html;
    }

}