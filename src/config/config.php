<?php
namespace Config;

class Config {

    public static function getBasePath() {
        // Récupère le chemin du répertoire contenant site.php
        $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
        
        // Normalise le chemin (enlève le trailing slash si présent)
        $basePath = rtrim($scriptPath, '/');
        
        return $basePath;
    }
    
    public static function url($path) {
        $basePath = self::getBasePath();
        $cleanPath = '/' . ltrim($path, '/');
        
        // Si on est à la racine (basePath vide), retourner juste le chemin
        if ($basePath === '' || $basePath === '/') {
            return $cleanPath;
        }
        
        // Sinon, combiner base path et chemin
        return $basePath . $cleanPath;
    }
}