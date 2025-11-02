<?php

declare(strict_types=1);

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action;

class Dispatcher
{
    private string $action;
    public function __construct(string $action = '')
    {
        $this->action = $action;
    }

    public function run(): void
    {
        $html = "";
        switch ($this->action) {
            case 'add-playlist':
                $html = (new action\AddPlaylistAction())();
                break;
            case 'add-track':
                $html = (new action\AddPodcastTrackAction())();
                break;
            case 'signin':
                $html = (new action\SigninAction())();
                break;
            case 'add-user':
                $html = (new action\AddUserAction())();
                break;
            case 'display-playlist':
                $html = (new action\DisplayPlaylistAction())();
                break;
            case 'ma-playlists':
                $html = (new action\PlayistUserAction())();
                break;
            case 'playist-actu':
                $html = (new action\PlayistActuAction())();
                break;
            case 'add-track2':
                $html = (new action\AddTrackAction())();
                break;
            default:
                $html = (new action\DefaultAction())();
        }
        $this->renderPage($html);
    }

private function renderPage(string $html): void
{
    echo <<<FIN
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Deefy</title>
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                display: flex;
                height: 100vh;
                background-color: #121212;
                color: #fff;
            }

            nav {
                width: 220px;
                background-color: #1e1e1e;
                padding: 20px;
                box-sizing: border-box;
            }

            nav h2 {
                color: #1db954;
                font-size: 24px;
                margin-bottom: 20px;
            }

            nav ul {
                list-style: none;
                padding: 0;
            }

            nav ul li {
                margin-bottom: 15px;
            }

            nav ul li a {
                color: #fff;
                text-decoration: none;
                font-weight: bold;
            }

            nav ul li a:hover {
                color: #1db954;
            }

            main {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
            }

            h2 {
                color: #1db954;
            }

            form {
                background-color: #282828;
                padding: 15px;
                border-radius: 8px;
                max-width: 400px;
                margin-bottom: 20px;
            }

            form input, form button {
                width: 100%;
                padding: 8px;
                margin-bottom: 10px;
                border: none;
                border-radius: 4px;
                box-sizing: border-box;
            }

            form input {
                background-color: #3e3e3e;
                color: #fff;
            }

            form button {
                background-color: #1db954;
                color: #fff;
                cursor: pointer;
                font-weight: bold;
            }

            form button:hover {
                background-color: #1ed760;
            }

            .audio-list {
                background-color: #282828;
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
            }

            .audio-list div {
                padding: 5px 0;
            }

            .audio-list-summary {
                font-size: 0.9em;
                color: #aaa;
                margin-top: 10px;
            }

            a {
                color: #1db954;
            }
        </style>
    </head>
    <body>
        <nav>
            <h2>Deefy</h2>
            <ul>
            <li><a href='?action=default'>Accueil</a> </li>
            <li><a href='?action=add-playlist'>Ajouter une playlist</a> </li>
            <li><a href='?action=add-track'>Ajouter une piste de podcast</a></li>
            <li><a href='?action=signin'>connecte toi</a></li>
            <li><a href='?action=add-user'>inscris toi</a></li>
            <li><a href='?action=display-playlist&id=1'>Afficher la playlist 1</a></li>
            <li><a href='?action=ma-playlists'>Mes playlists</a></li>
            <li><a href='?action=add-track2'>ajouter une piste</a></li>
            </ul>
        </nav>
        <main>
            $html
        </main>
    </body>
    </html>
    FIN;
}

}
