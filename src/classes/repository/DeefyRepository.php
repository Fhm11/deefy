<?php

namespace iutnc\deefy\repository;


use iutnc\deefy\audio\lists\Playlist;
use PDO;

class DeefyRepository
{
    private \PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf)
    {
        $this->pdo = new \PDO(
            $conf['dsn'],
            $conf['user'],
            $conf['pass'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function getInstance(): DeefyRepository
    {
        if (is_null(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file): void
    {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Erreur lecture du fichier de config");
        }
        $dbName = $conf['dbname'] ?? $conf['database'] ?? null;
        $user = $conf['username'] ?? $conf['user'] ?? '';
        $pass = $conf['password'] ?? $conf['pass'] ?? '';
        self::$config = [
            'dsn' => $conf['driver'] . ':host=' . $conf['host'] . ';dbname=' . $dbName,
            'user' => $user,
            'pass' => $pass
        ];
    }


    public function saveEmptyPlaylist(Playlist $pl): Playlist
    {
        $stmt = $this->pdo->prepare("INSERT INTO playlist (nom) VALUES (?)");
        $success = $stmt->execute([$pl->nom]);
        if (!$success) {
            throw new \Exception("Impossible d'insérer la playlist en base.");
        }
        $pl->id = (int)$this->pdo->lastInsertId();
        return $pl;
    }


    public function savePodcastTrack(array $trackData): int
    {
        $sqlCheck = "SELECT id FROM track WHERE titre = ? AND artiste_album = ?";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute([$trackData['titre'], $trackData['auteur']]);
        $existing = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        if ($existing) {
            return 0;
        }
        $sql = "INSERT INTO track (titre, genre, duree, filename, type, artiste_album )
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $trackData['titre'],
            $trackData['genre'] ?? 'jsp',
            $trackData['duree'],
            $trackData['cheminaudio'],
            $trackData['type'] ?? 'P',
            $trackData['auteur']
        ]);
        return (int)$this->pdo->lastInsertId();
    }


    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
