<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\dispatch\Dispatcher;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

iutnc\deefy\repository\DeefyRepository::setConfig('db.ini');


$action=(isset($_GET['action'])) ? $_GET['action'] : 'default';
$app = new Dispatcher($action);
$app->run();
