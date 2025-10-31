<?php
declare(strict_types=1);
namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\exception\AuthnException;


class Authz {

    // Vérifie que l'utilisateur a le rôle attendu
    public static function checkRole(int $roleExpected): void {
        $user = AuthnProvider::getSignedInUser();
        if ((int)$user['role'] !== $roleExpected) {
            throw new AuthnException("Accès refusé");
        }
    }

    // Vérifie que l'utilisateur est propriétaire de la playlist ou ADMIN
    public static function checkPlaylistOwner(int $playlistId): void {
    $user = AuthnProvider::getSignedInUser();
    $userId = (int)$user['id'];
    
    // Administrateur = toujours autorisé
    if ((int)$user['role'] === 100) return;

    // Vérifie dans user2playlist si l'utilisateur possède la playlist
    $repo = DeefyRepository::getInstance();
    $pdo = $repo->getPdo();
    
    $stmt = $pdo->prepare("select * from user2playlist where id_user = :uid and id_pl = :pid");
    $stmt->execute(['uid' => $userId, 'pid' => $playlistId]);
    $row = $stmt->fetch();

    if (!$row) {
        throw new AuthnException("Accès refusé");
    }
}

}
