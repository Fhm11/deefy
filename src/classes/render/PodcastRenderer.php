<?php
declare(strict_types=1);

namespace iutnc\deefy\render;



class PodcastRenderer extends AudioTrackRenderer {
    private \iutnc\deefy\audio\tracks\PodcastTrack $podcast;
    public function __construct(\iutnc\deefy\audio\tracks\PodcastTrack $podcast) {
        $this->podcast = $podcast;
    }
    protected function renderCompact(): string {
        $p = $this->podcast;
        return "<div>{$p->titre} par {$p->auteur}</div>";
    }
    protected function renderLong(): string {
        $p = $this->podcast;
        $html = "<div>";
        $html .= "Titre : {$p->titre}<br>";
        $html .= "Auteur : {$p->auteur}<br>";
        $html .= "Date : {$p->date}<br>";
        $html .= "Genre : {$p->genre}<br>";
        $html .= "Durée : {$p->duree} sec<br>";
        $html .= "<audio controls src=\"{$p->cheminaudio}\"></audio>";
        $html .= "</div>";
        return $html;
    }
}
