<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

use iutnc\deefy\render\Renderer;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\auth\Authz;

class DisplayPlaylistAction extends Action {

    public function execute(): string {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        return "<p>Veuillez sélectionner une playlist à afficher.</p>";
    }

    $id = (int)$_GET['id'];

    try {
        // Contrôle d'accès
        Authz::checkPlaylistOwner($id);

        // Récupération de la playlist
        $repo = DeefyRepository::getInstance();
        $playlist = $repo->findPlaylistById($id);

    } catch (\Exception $e) {
        return "<p>Erreur : {$e->getMessage()}</p>";
    }

    $renderer = new AudioListRenderer($playlist);
    return $renderer->render(Renderer::COMPACT);
}


    public function __invoke(): string {
        if ($this->http_method === 'GET') {
            return $this->execute();
        }
        return '<p>Méthode non autorisée</p>';
    }
}
