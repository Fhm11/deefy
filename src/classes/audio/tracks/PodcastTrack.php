<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;


class PodcastTrack extends AudioTrack {
    private string $date;

    public function __construct(string $titre, string $cheminaudio) {
        parent::__construct($titre, $cheminaudio);
        $this->date = date('Y-m-d');
    }

    public function __toString(): string {
        return json_encode([
            'titre' => $this->__get('titre'),
            'auteur' => $this->__get('auteur'),
            'genre' => $this->__get('genre'),
            'duree' => $this->__get('duree'),
            'cheminaudio' => $this->__get('cheminaudio'),
            'date' => $this->__get('date')
        ]);
    }

    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new \Exception("invalid property : $name");
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }
}
