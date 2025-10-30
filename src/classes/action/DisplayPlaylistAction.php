<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render\Renderer;
use iutnc\deefy\render\AudioListRenderer;

class DisplayPlaylistAction extends Action {

public function execute(): string {
        if (!isset($_SESSION['playlist'])) {
            return '<p>0 playist <a href="?action=add-playlist">Créer une playlist</a></p>';
        }
        $playlist = $_SESSION['playlist'];
        $renderer = new AudioListRenderer($playlist);
        return $renderer->render(Renderer::COMPACT);
    }

    public function __invoke(): string {
        if ($this->http_method === 'GET') {
            return $this->execute();
        }
        return 'jsp';
    }
}