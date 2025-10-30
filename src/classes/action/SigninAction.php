<?php
declare(strict_types=1);

namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\exception\AuthnException;

class SigninAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'GET') {
            return <<<HTML
                <h2>Connexion</h2>
                <form method="post" action="?action=signin">
                    <label>Email :</label><br>
                    <input type="email" name="email" required><br><br>
                    <label>Mot de passe :</label><br>
                    <input type="password" name="passwd" required><br><br>
                    <button type="submit">Se connecter</button>
                </form>
            HTML;
        }

        try {
            $email = $_POST['email'] ?? '';
            $passwd = $_POST['passwd'] ?? '';
            AuthnProvider::signin($email, $passwd);
            return "<p>gg wp t co <b>{$email}</b> !</p>";
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
        return '<p>jsp</p>';
    }
}
