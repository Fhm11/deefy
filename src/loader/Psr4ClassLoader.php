<?php
declare(strict_types=1);

namespace loader;


class Psr4ClassLoader
{
    private string $prefix;
    private string $racine;

    public function __construct(string $prefix, string $racine)
    {
        $this->prefix = $prefix;
        $this->racine = rtrim($racine, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function register(){
        spl_autoload_register([$this, 'loadClass']);
    }


    public function loadClass(string $class): ?bool
    {
        //echo "<br>DEBUG: Tentative de chargement de la classe: $class<br>";
        
        $len = strlen($this->prefix);
        //echo "DEBUG: Préfixe: '{$this->prefix}' (longueur: $len)<br>";
        
        if (strpos($class, $this->prefix) !== 0) {
            //echo "DEBUG: La classe ne commence pas par le préfixe, ignorée<br>";
            return null;
        }
        
        $relativeClass = substr($class, $len);
        //echo "DEBUG: Classe relative: '$relativeClass'<br>";
        
        $file = $this->racine . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
        //echo "DEBUG: Chemin du fichier: '$file'<br>";
        
        if (is_file($file)) {
            //echo "DEBUG: Fichier trouvé, chargement en cours...<br>";
            require_once $file;
            //echo "DEBUG: Classe '$class' chargée avec succès !<br><br>";
            return true;
        }
        
        //echo "DEBUG: Fichier non trouvé !<br><br>";
        return false;
    }
}