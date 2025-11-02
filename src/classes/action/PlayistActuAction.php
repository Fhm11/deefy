<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\repository\DeefyRepository;

class PlayistActuAction extends Action
{
    public function execute(): string {
        // verif utilisateur connecté
        try {
            $user = AuthnProvider::getSignedInUser();
        } catch (\Exception $e) {
            return "<p>Tu dois être connecté pour accéder à cette playlist.</p>";
        }

        // Vérifie que l'id de la playlist est bien passer
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return "<p>Playlist non spécifiée.</p>";
        }

        $playlistId = (int)$_GET['id'];

        // Récupère la playlist
        $repo = DeefyRepository::getInstance();
        try {
            $playlist = $repo->findPlaylistById($playlistId);
        } catch (\Exception $e) {
            return "<p>Playlist introuvable.</p>";
        }

        // Vérifie que l'utilisateur est propriétaire
        $stmt = $repo->getPdo()->prepare("
            select * from user2playlist where id_user = :uid and id_pl = :pid
        ");
        $stmt->execute(['uid' => $user['id'], 'pid' => $playlistId]);
        if (!$stmt->fetch()) {
            return "<p>ta pas les acces a cette playist</p>";
        }

        // Stocke la playlist en session
        $_SESSION['playlist'] = $playlist;

        // Affiche la playlist
        return "<p>Playlist courante définie :</p>" . (new \iutnc\deefy\render\AudioListRenderer($playlist))->render(\iutnc\deefy\render\Renderer::COMPACT);
    }

    public function __invoke(): string {
        if ($this->http_method === 'GET') {
            return $this->execute();
        }
        return "<p>t'es pas autorise</p>";
    }
}
