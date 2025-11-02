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
            case 'my-playlists': 
                $html = (new action\PlayistUser())();
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
            <title>Deefy</title>
        </head>
        <body>
        <ul>
            <li><a href='?action=default'>Accueil</a> </li>
            <li><a href='?action=add-playlist'>Ajouter une playlist</a> </li>
            <li><a href='?action=add-track'>Ajouter une piste de podcast</a></li>
            <li><a href='?action=signin'>connecte toi</a></li>
            <li><a href='?action=add-user'>inscris toi</a></li>
            <li><a href='?action=display-playlist&id=1'>Afficher la playlist 1</a></li>
            <li><a href='?action=my-playlists'>Mes playlists</a></li>

        </ul>
        $html
        </body>
        </html>
        FIN;
    }
}
