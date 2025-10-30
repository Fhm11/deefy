<?php
declare(strict_types=1);

namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AudioTrack;

class AudioListRenderer implements Renderer {
    private AudioList $list;

    public function __construct(AudioList $list) {
        $this->list = $list;
    }

    public function render(int $selector): string {
        $html = "<div class='audio-list'>\n";
        $html .= "<h2>" . htmlspecialchars($this->list->nom) . "</h2>\n";
        foreach ($this->list->pistes as $piste) {
            if ($piste instanceof AudioTrack) {
                $renderer = new class($piste) extends AudioTrackRenderer {
                    private AudioTrack $track;
                    public function __construct(AudioTrack $track) { $this->track = $track; }
                    protected function renderCompact(): string {
                        $t = $this->track;
                        return "<div>" . htmlspecialchars($t->titre) . " - " . htmlspecialchars($t->auteur) . " (" . htmlspecialchars((string)$t->duree) . " sec)</div>";
                    }
                    protected function renderLong(): string { return $this->renderCompact(); }
                };
                $html .= $renderer->render(self::COMPACT) . "\n";
            }
        }
        $html .= "<div class='audio-list-summary'>";
        $html .= $this->list->nbPistes . " piste(s), durée totale : " . $this->list->dureeTotale . " sec";
        $html .= "</div>\n</div>\n";
        return $html;
    }
}
