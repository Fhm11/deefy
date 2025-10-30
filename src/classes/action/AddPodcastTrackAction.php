<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPodcastTrackAction extends Action
{

    public function execute(): string
    {
        return $this->afficherFormulaire();
    }

    private function traiterFormulaire(): string
    {
        $titre = isset($_POST['titre']) ? filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $auteur = isset($_POST['auteur']) ? filter_var($_POST['auteur'], FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $duree = isset($_POST['duree']) ? (int)$_POST['duree'] : 0;
        $fichier = isset($_POST['fichier']) ? filter_var($_POST['fichier'], FILTER_SANITIZE_SPECIAL_CHARS) : '';
        if ($titre === '' || $auteur === '' || $duree <= 0 || $fichier === '') {
            return '<p>remplis tout</p>' . $this->afficherFormulaire();
        }
        if (!isset($_SESSION['playlist'])) {
            return '<p>0 playist<a href="?action=add-playlist">Créer une playlist</a></p>';
        }
        $track = new PodcastTrack($titre, $fichier);
        $track->setAuteur($auteur);
        $track->setDuree($duree);
        $_SESSION['playlist']->ajouterPiste($track);

        if (isset($_SESSION['playlist']->id) && $_SESSION['playlist']->id !== null) {
            $repo = DeefyRepository::getInstance();
            $trackId = $repo->savePodcastTrack([
                'titre' => $titre,
                'auteur' => $auteur,
                'duree' => $duree,
                'cheminaudio' => $fichier,
                'type' => 'podcast',
                'playlist_id' => $_SESSION['playlist']->id
            ]);
            $track->id = $trackId;
        }
        if ($trackId === 0) {
            $message = '<p>sa existe deja</p>';
        } else {
            $track->id = $trackId;
            $message = '<p>c ajouter</p>';
        }
        $_SESSION['playlist'] = $_SESSION['playlist'];
        $renderer = new AudioListRenderer($_SESSION['playlist']);
        $html = $message . $renderer->render(Renderer::COMPACT);
        $html .= '<p><a href="?action=add-track">Ajouter encore une piste</a></p>';

        return $html;
    }

    private function afficherFormulaire(): string
    {
        return <<<HTML
        <h2>Ajouter une piste à la playlist</h2>
        <form method="post" action="?action=add-track">
            <label for="titre">Titre :</label><br>
            <input type="text" id="titre" name="titre" required><br><br>

            <label for="auteur">Auteur :</label><br>
            <input type="text" id="auteur" name="auteur" required><br><br>

            <label for="duree">Durée (en secondes) :</label><br>
            <input type="number" id="duree" name="duree" min="1" required><br><br>

            <label for="fichier">Lien/fichier :</label><br>
            <input type="text" id="fichier" name="fichier" required><br><br>

            <button type="submit">Ajouter</button>
        </form>
        HTML;
    }

    public function __invoke(): string
    {
        if ($this->http_method === 'GET') {
            return $this->afficherFormulaire();
        } elseif ($this->http_method === 'POST') {
            return $this->traiterFormulaire();
        }
        return '<p>jsp</p>';
    }
}
