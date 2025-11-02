<?php
declare(strict_types=1);
namespace iutnc\deefy\action;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPlaylistAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->traiterFormulaire();
        }
        return $this->afficherFormulaire();
    }


    public function afficherFormulaire(): string {
        return <<<HTML
        <h2>Créer une nouvelle playlist</h2>
        <form method="post" action="?action=add-playlist">
            <label for="nom">Nom de la playlist :</label><br>
            <input type="text" id="nom" name="nom" required>
            <br><br>
            <button type="submit">Créer</button>
        </form>
        HTML;
    }


    private function traiterFormulaire(): string {
        $nom = isset($_POST['nom']) ? filter_var($_POST['nom'], FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $playlist = new Playlist($nom);
        try {
            $repo = DeefyRepository::getInstance();
            $playlist = $repo->saveEmptyPlaylist($playlist);
        } catch (\Exception $e) {
            return "<p>Erreur BDD : {$e->getMessage()}</p>";
        }
        $_SESSION['playlist'] = $playlist;
        $renderer = new AudioListRenderer($playlist);
        $html = '<p>Playlist créée !</p>';
        $html .= $renderer->render(\iutnc\deefy\render\Renderer::COMPACT);
        $html .= '<p><a href="?action=add-track">Ajouter une piste</a></p>';
        return $html;
    }
    

    public function __invoke(): string {
        if ($this->http_method === 'GET') {
            return $this->afficherFormulaire();
        } elseif ($this->http_method === 'POST') {
            return $this->traiterFormulaire();
        }
        return '<p>jsp</p>';
    }

    
}
