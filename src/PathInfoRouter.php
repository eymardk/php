<?php

class PathInfoRouter
{
    public function main($animalStorage, $feedback = null)
    {
        require_once ('view/View.php');
        require_once ('control/Controller.php');
        require_once ('model/Animal.php');
        require_once ('model/AnimalStorage.php');
        require_once ('model/AnimalStorageSession.php');

        $view = new View($this, $feedback);

        $controller = new Controller($view, $animalStorage);

        $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        // Route pour la liste des animaux
        if ($path == '/liste') {
            $controller->showList();
        }
        // Route pour afficher le formulaire de création d'un nouvel animal
        elseif ($path == '/nouveau') {
            $controller->createNewAnimal();
        }
        // Route pour enregistrer le nouvel animal après soumission du formulaire
        elseif ($path == '/sauverNouveau' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->saveNewAnimal($_POST);
        }
        // Route pour afficher un animal spécifique
        elseif ($path != '/') {
            $id = trim($path, '/');
            $controller->showInformation($id);
        }
        // Route par défaut (accueil)
        else {
            $controller->showHome();
        }

        $view->render();
    }

        public function getAnimalURL($id)
    {
        return \Config\Config::url('site.php/' . urlencode($id));
    }

    public function getAnimalCreationURL()
    {
        return \Config\Config::url('site.php/nouveau');
    }

    public function getAnimalSaveURL()
    {
        return \Config\Config::url('site.php/sauverNouveau');
    }

    public function getHomeURL()
    {
        return \Config\Config::url('site.php/');
    }

    public function getListURL()
    {
        return \Config\Config::url('site.php/liste');
    }

    public function POSTredirect($url, $feedback)
    {
        
        $_SESSION['feedback'] = $feedback;
        
        header("HTTP/1.1 303 See Other");
        header("Location: $url");
        exit();
    }
}
?>