
<?php
// require_once 'src/loader/Psr4ClassLoader.php';
// $loader = new \loader\Psr4ClassLoader("iutnc\\deefy\\", "src/classes");
// $loader->register();

require_once 'vendor/autoload.php';

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AlbumTrackRenderer;
use iutnc\deefy\render\PodcastRenderer;
use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\lists\Album;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\Renderer;

try {

	$piste1 = new AlbumTrack('Chanson Un', 'son/son1.mp3', 'Album 1', 1);
	$piste2 = new AlbumTrack('Chanson Deux', 'son/son1.mp3', 'Album 2', 2);

	$piste1->setArtiste('Artiste A');
	$piste1->setAnnee(2024);
	$piste1->setGenre('Pop');
	$piste1->setDuree(210);

	$piste2->setArtiste('Artiste B');
	$piste2->setAnnee(2025);
	$piste2->setGenre('Rock');
	$piste2->setDuree(185);

	// Exemple AudioList
	$liste = new AudioList('Ma sélection', [$piste1, $piste2]);
	echo "<br><b>Exemple AudioList</b><br>";
	echo "Nom : {$liste->nom}<br>";
	echo "Nombre de pistes : {$liste->nbPistes}<br>";
	echo "Durée totale : {$liste->dureeTotale} sec<br>";

	// Exemple Album
	$album = new Album('Super Album', [$piste1, $piste2], 'Artiste Album', '2025-09-12');
	echo "<br><b>Exemple Album</b><br>";
	echo "Nom : {$album->nom}<br>";
	echo "Artiste : {$album->artiste}<br>";
	echo "Date de sortie : {$album->dateSortie}<br>";
	echo "Nombre de pistes : {$album->nbPistes}<br>";
	echo "Durée totale : {$album->dureeTotale} sec<br>";

	// Exemple Playlist
	$playlist = new Playlist('Ma Playlist');
	$playlist->ajouterPiste($piste1);
	$playlist->ajouterPiste($piste2);
	echo "<br><b>Exemple Playlist</b><br>";
	echo "Nom : {$playlist->nom}<br>";
	echo "Nombre de pistes : {$playlist->nbPistes}<br>";
	echo "Durée totale : {$playlist->dureeTotale} sec<br>";
	echo "piste : {$piste1->cheminaudio}<br>"; 
	echo "<audio controls src=\"{$piste1->cheminaudio}\"><br></audio><br>";

	echo $piste1->album . " - Piste " . $piste1->numpiste . "<br>";
	echo $piste2->album . " - Piste " . $piste2->numpiste . "<br><br>";
	echo $piste2->titre . " par " . $piste2->artiste . " (" . $piste2->annee . ")<br><br>";

	print "--- Affichage avec print ---<br>";
	print $piste1->album . " - Piste " . $piste1->numpiste . "<br>";
	print $piste2->album . " - Piste " . $piste2->numpiste . "<br>";

	echo "<br>--- Affichage avec toString() ---<br>";
	echo $piste1->__toString() . "<br>";
	echo $piste2->__toString() . "<br>";

	$renderer1 = new AlbumTrackRenderer($piste1);
	$renderer2 = new AlbumTrackRenderer($piste2);
	echo $renderer1->render(1);
	echo $renderer2->render(2);

	$podcast = new PodcastTrack('Podcast Decouverte', 'son/son1.mp3');
	$podcast->setAuteur('Auteur Podcast');
	$podcast->setGenre('Culture');
	$podcast->setDuree(3600);
	$podcast->setDate('2025-09-10');

	echo "<br>--- Affichage podcast ---<br>";
	echo $podcast->__toString() . "<br>";

	$podcastRenderer = new PodcastRenderer($podcast);
	echo $podcastRenderer->render(Renderer::COMPACT);
	echo $podcastRenderer->render(Renderer::LONG);

} catch (\Exception $e) {
	echo '<b>Exception attrapée :</b> ' . $e->getMessage() . '<br>';
	echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
