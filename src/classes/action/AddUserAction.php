<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthnException;

class AddUserAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'GET') {
            return <<<HTML
                <h2>Inscription</h2>
                <form method="post" action="?action=add-user">
                    <label>Email :</label><br>
                    <input type="email" name="email" required><br><br>
                    <label>Mot de passe :</label><br>
                    <input type="password" name="passwd" required><br><br>
                    <label>Confirmez le mot de passe :</label><br>
                    <input type="password" name="passwd2" required><br><br>
                    <button type="submit">Créer un compte</button>
                </form>
            HTML;
        }

        $email = $_POST['email'] ?? '';
        $passwd = $_POST['passwd'] ?? '';
        $passwd2 = $_POST['passwd2'] ?? '';

        if ($passwd !== $passwd2) {
            return "<p> Pas les meme mdp </p>";
        }

        try {
            AuthnProvider::register($email, $passwd);
            return "<p> Inscription réussi <b>{$email}</b></p>";
        } catch (AuthnException $e) {
            return "<p {$e->getMessage()}</p>";
        }
    }

    public function __invoke(): string {
        if ($this->http_method === 'GET') {
            return $this->execute();
        } elseif ($this->http_method === 'POST') {
            return $this->execute();
        }
        return '<p>Méthode pas autorisé</p>';
    }
}
