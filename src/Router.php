<?php
// class Router {
//     public function main() {
//         require_once("view/View.php");
//         require_once("control/Controller.php");
//         require_once("model/Animal.php");  // Inclure la classe Animal
        
//         $view = new View($this);
//         $controller = new Controller($view);

//         // Vérifier si action=liste est présent dans l'URL
//         if (isset($_GET['action']) && $_GET['action'] == 'liste') {
//             $controller->showList();  // Affiche la liste des animaux
//         } elseif (isset($_GET['id'])) {
//             $id = $_GET['id'];
//             $controller->showInformation($id);  // Affiche les informations sur un animal
//         } else {
//             $controller->showHome();  // Page d'accueil
//         }

//         $view->render();
//     }

//     public function getAnimalURL($name) {
//         return "site.php?id=" . urlencode($name);
//     }
// }

class Router {

    public function main() {
        require_once("view/View.php");
        require_once("control/Controller.php");
        require_once("model/Animal.php");
        require_once("model/AnimalStorage.php");
        require_once("model/AnimalStorageStub.php"); 
         

        // Créer une instance du stockage 
        $animalStorage = new \Model\AnimalStorageStub();

        // Créer la vue
        $view = new View($this);
        
        // Créer le contrôleur avec le stockage et la vue
        $controller = new Controller($view, $animalStorage);

        // Vérifier l'action dans l'URL
        if (isset($_GET['action']) && $_GET['action'] == 'liste') {
            $controller->showList();  // Affiche la liste des animaux
        } elseif (isset($_GET['id'])) {
            $id = $_GET['id'];
            $controller->showInformation($id);  // Affiche les informations sur un animal
        } else {
            $controller->showHome();  // Page d'accueil
        }

        // Rendu de la vue
        $view->render();
    }

    public function getAnimalURL($name) {
        return "site.php?id=" . urlencode($name);
    }
}
?>
