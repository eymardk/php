<?php
// namespace Model;

// class AnimalStorageStub implements AnimalStorage {

//     private $animals;

//     public function __construct() {
//         $this->animals = array(
//             'medor' => new \Animal('Médor', 'chien', 5),
//             'felix' => new \Animal('Félix', 'chat', 3),
//             'denver' => new \Animal('Denver', 'dinosaure', 100),
//             'dumbo' => new \Animal('Dumbo', 'éléphant', 10),
//             'nemo' => new \Animal('Nemo', 'poisson-clown', 2)
//         );
//     }

//     // Implémentation de la méthode read pour obtenir un animal par son identifiant
//     public function read($id) {
//         return isset($this->animals[$id]) ? $this->animals[$id] : null;
//     }

//     // Implémentation de la méthode readAll pour obtenir tous les animaux
//     public function readAll() {
//         return $this->animals;
//     }
// }
namespace Model;

class AnimalStorageStub implements AnimalStorage {

    private $animals = [];

    public function __construct() {
        
        $this->animals = [
            'medor' => new Animal('Médor', 'Chien', 5),
            'felix' => new Animal('Félix', 'Chat', 3),
            'denver' => new Animal('Denver', 'Dinosaure', 7),
            'dumbo' => new Animal('Dumbo', 'éléphant', 10),
            'nemo' => new Animal('Nemo', 'poisson-clown', 2)
        ];
    }

    public function read($id) {
        return isset($this->animals[$id]) ? $this->animals[$id] : null;
    }

    public function readAll() {
        return $this->animals;
    }

    /**
     * Ajoute un nouvel animal dans la base
     * 
     * @param Animal $a L'animal à ajouter
     * @return string L'identifiant de l'animal ajouté
     */
    public function create(Animal $a) {
        // Génère un identifiant unique
        $id = strtolower($a->getName()); // Utilise le nom de l'animal comme identifiant
        $this->animals[$id] = $a;
        return $id;
    }

    /**
     * Supprime un animal de la base
     * 
     * @param string $id L'identifiant de l'animal à supprimer
     * @return bool True si l'animal a été supprimé, false sinon
     */
    public function delete($id) {
        if (isset($this->animals[$id])) {
            unset($this->animals[$id]);
            return true;
        }
        return false;
    }

    /**
     * Met à jour un animal dans la base
     * 
     * @param string $id L'identifiant de l'animal à mettre à jour
     * @param Animal $a L'animal qui remplacera l'animal existant
     * @return bool True si l'animal a été mis à jour, false sinon
     */
    public function update($id, Animal $a) {
        if (isset($this->animals[$id])) {
            $this->animals[$id] = $a;
            return true;
        }
        return false;
    }
}