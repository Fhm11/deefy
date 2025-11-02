<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\lists\Playlist;

class PlayistUserAction extends Action
{
    public function execute(): string {
        // verif si utilisateur connecté
        try {
            $user = AuthnProvider::getSignedInUser();
        } catch (\Exception $e) {
            return "<p>tu dois etre connecter</p>";
        }

        $userId = $user['id'];
        $repo = DeefyRepository::getInstance();
        $pdo = $repo->getPdo();

        // recup les playlists de l'utilisateur
        $stmt = $pdo->prepare("
            SELECT pl.id, pl.nom
            FROM playlist pl
            JOIN user2playlist u2p ON pl.id = u2p.id_pl
            WHERE u2p.id_user = :uid
        ");
        $stmt->execute(['uid' => $userId]);
        $playlists = $stmt->fetchAll();

        if (empty($playlists)) {
            return "<p>0 playist</p>";
        }

        // Affiche les playlists avec lien 
        $html = "<h2>Mes playlists</h2><ul>";
        foreach ($playlists as $pl) {
            $html .= "<li><a href='?action=set-current-playlist&id={$pl['id']}'>" .$pl['nom'] . "</a></li>";
        }
        $html .= "</ul>";

        return $html;
    }
    public function __invoke(): string {
        if ($this->http_method === 'GET') {
            return $this->execute();
        }
        return "<p>t'es pas autorise</p>";
    }
}
