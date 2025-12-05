<?php

require_once("model/AnimalBuilder.php");



// class Controller {

//     private $view;

//     private $animalsTab;

//     public function __construct($view) {
//         $this->view = $view;

//         $this->animalsTab = array(
//             '0' => array('Médor', 'chien'),
//             '1' => array('Félix', 'chat'),
//             '2' => array('Denver', 'dinosaure'),
//             '3' => array('Dumbo', 'éléphant'),
//             '4' => array('Nemo', 'poisson-clown')
//         );
//     }

//     public function showInformation($id) {
//         if (array_key_exists($id, $this->animalsTab)) {
//             $animalData = $this->animalsTab[$id];
//             $name = $animalData[0];
//             $species = $animalData[1];
//             $age = 5;

//             $animal = new Animal($name, $species, $age);
//             $this->view->prepareAnimalPage($animal);

//         } else {

//             $this->view->prepareUnknownAnimalPage();
//         }
//     }
//     public function showList() {

//         $animals = [];
//         foreach ($this->animalsTab as $animalData) {
//             $animals[] = new Animal($animalData[0], $animalData[1], 5);  // L'âge est fixe ici à 5
//         }

//         $this->view->prepareListPage($animals);
//     }

//     public function showHome() {
//         $this->view->prepareHomePage();
//     }
// }

class Controller
{
    private $view;
    private $animalStorage;

    public function __construct($view, $animalStorage)
    {
        $this->view = $view;
        $this->animalStorage = $animalStorage;  // Stockage injecté dans le contrôleur
    }

 public function createNewAnimal()
{
    // Créer un builder vide
    $builder = new \Model\AnimalBuilder();
    $this->view->prepareAnimalCreationPage($builder);
}

public function saveNewAnimal(array $data)
{
    // Créer un builder avec les données reçues
    $builder = new \Model\AnimalBuilder($data);
    
    // Valider les données
    if (!$builder->isValid()) {
        // Réafficher le formulaire avec l'erreur
        $this->view->prepareAnimalCreationPage($builder);
        return;
    }
    
    // Créer et sauvegarder l'animal
    $animal = $builder->createAnimal();
    $animalId = $this->animalStorage->create($animal);
    
    // au lieu de renvoyer aficher l'animal créé on fais une rédirection
     $this->view->displayAnimalCreationSuccess($animalId);
}

    public function showInformation($id)
    {
        // Utilisation du stockage pour récupérer l'animal
        $animal = $this->animalStorage->read($id);

        if ($animal) {
            $this->view->prepareAnimalPage($animal);
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function showList()
    {
        // Récupère tous les animaux depuis le stockage
        $animals = $this->animalStorage->readAll();
        $this->view->prepareListPage($animals);
    }

    public function showHome()
    {
        $this->view->prepareHomePage();
    }

    public function showAddAnimal()
    {
        $this->view->prepareAddAnimalPage();
    }

    // public function handleAddAnimal()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $name = $_POST['name'];
    //         $species = $_POST['species'];
    //         $age = $_POST['age'];

    //         // Créer un nouvel objet Animal
    //         $animal = new Animal($name, $species, $age);

    //         // Ajouter l'animal au stockage
    //         $id = $this->animalStorage->create($animal);

    //         // Rediriger vers la page de l'animal ou vers la liste
    //         header("Location: /exoMVCR/site.php/$id");
    //         exit;
    //     }
    // }

    // public function handleDeleteAnimal($name)
    // {
    //     $animal = $this->animalStorage->read($name);
    //     if ($animal) {
    //         $this->animalStorage->delete($name);
    //     }

    //     // Rediriger après suppression
    //     header('Location: /exoMVCR/site.php');
    //     exit;
    // }

    // public function handleEditAnimal($name)
    // {
    //     $animal = $this->animalStorage->read($name);

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $updatedAnimal = new Animal($_POST['name'], $_POST['species'], $_POST['age']);
    //         $this->animalStorage->update($name, $updatedAnimal);

    //         header('Location: /exoMVCR/site.php/' . urlencode($_POST['name']));
    //         exit;
    //     }

    //     $this->view->prepareEditAnimalPage($animal);
    // }
}
?>