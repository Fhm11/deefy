<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\lists\Playlist;

class AddTrackAction extends Action
{
    public function execute(): string {
        // verif si utilisateur connecté
        try {
            $user = AuthnProvider::getSignedInUser();
        } catch (\Exception $e) {
            return "<p>Tu dois être connecté pour ajouter une piste.</p>";
        }

        // verif si playlist courante est dans la session
        if (!isset($_SESSION['current_playlist']) || !$_SESSION['current_playlist'] instanceof Playlist) {
            return "<p>Tu dois sélectionner une playlist.</p>";
        }

        $playlist = $_SESSION['current_playlist'];

        // Si formulaire soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'] ?? '';
            $auteur = $_POST['auteur'] ?? '';
            $genre = $_POST['genre'] ?? '';
            $duree = (int)($_POST['duree'] ?? 0);
            $cheminaudio = $_POST['cheminaudio'] ?? '';

            if (empty($titre) || empty($cheminaudio)) {
                return "<p>Le titre et le chemin audio sont obligatoires.</p>";
            }

            // cree la piste
            $track = new AudioTrack($titre, $cheminaudio);
            $track->setAuteur($auteur ?: "Inconnu");
            $track->setGenre($genre ?: "Inconnu");
            $track->setDuree($duree);

            // Ajoute à la playlist en session
            $playlist->ajouterPiste($track);
            $repo = DeefyRepository::getInstance();
            $repo->savePodcastTrack([
                'titre' => $track->titre,
                'auteur' => $track->auteur,
                'genre' => $track->genre,
                'duree' => $track->duree,
                'cheminaudio' => $track->cheminaudio,
                'type' => 'P'
            ]);

            return "<p>c rajouter</p>";
        }

        //formulaire pour ajouter la playisit
        return <<<HTML
        <h2>ajoute une piste à la playlist "{$playlist->nom}"</h2>
        <form method="post">
            <label>Titre :</label><br>
            <input type="text" name="titre" required><br>
            <label>Auteur :</label><br>
            <input type="text" name="auteur"><br>
            <label>Genre :</label><br>
            <input type="text" name="genre"><br>
            <label>Durée (en secondes) :</label><br>
            <input type="number" name="duree"><br>
            <label>Chemin audio :</label><br>
            <input type="text" name="cheminaudio" required><br><br>
            <input type="submit" value="Ajouter la piste">
        </form>
HTML;
    }

    public function __invoke(): string {
        if ($this->http_method === 'GET' || $this->http_method === 'POST') {
            return $this->execute();
        }
        return "<p>t'es pas autorise</p>";
    }
}
