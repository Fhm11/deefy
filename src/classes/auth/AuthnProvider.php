<?php
declare(strict_types=1);

namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\exception\AuthnException;

class AuthnProvider {

    public static function signin(string $email, string $passwd): void {
        $repo = DeefyRepository::getInstance();
        $pdo = $repo->getPDO(); 
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$user) {
            throw new AuthnException("Utilisateur inconnu.");
        }
        if (!password_verify($passwd, $user['passwd'])) {
            throw new AuthnException("Mot de passe incorrect.");
        }
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
    }

    public static function register(string $email, string $passwd): void {
        if (strlen($passwd) < 10) {
            throw new AuthnException("Le mot de passe doit contenir au moins 10 caractères.");
        }
        $repo = DeefyRepository::getInstance();
        $pdo = $repo->getPDO();

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            throw new AuthnException("Un compte existe déjà avec cet email.");
        }
        $hash = password_hash($passwd, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO user (email, passwd, role) VALUES (?, ?, 1)");
        $stmt->execute([$email, $hash]);
    }

    public static function getSignedInUser(): array {
    if (!isset($_SESSION['user'])) {
        throw new AuthnException("Aucun utilisateur authentifié.");
    }
    return $_SESSION['user'];
}

}
