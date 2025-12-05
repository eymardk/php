<?php
namespace Model;

require_once ('model/Animal.php');
require_once ('model/AnimalStorage.php');

class AnimalStorageMySQL implements AnimalStorage
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère un animal par son identifiant
     */
    public function read($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM animals WHERE id = :id');

        // Exécution avec la valeur de $id
        $stmt->execute(['id' => $id]);

        // Récupération du résultat
        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        return new Animal(
            $row['name'],
            $row['species'],
            (int) $row['age']
        );
    }

    /**
     * Récupère tous les animaux
     */
    public function readAll()
    {
        // Requête SQL correcte
        $stmt = $this->pdo->query('SELECT * FROM animals ORDER BY name');

        // Créer le tableau d'animaux
        $animals = [];

        while ($row = $stmt->fetch()) {
            $animals[$row['id']] = new Animal(
                $row['name'],
                $row['species'],
                (int) $row['age'],
            );
        }

        return $animals;
    }

    /**
     * Ajoute un nouvel animal
     */
    public function create(Animal $a)
    {
        throw new \Exception('not yet implemented');
    }

    /**
     * Supprime un animal
     */
    public function delete($id)
    {
        throw new \Exception('not yet implemented');
    }

    /**
     * Met à jour un animal
     */
    public function update($id, Animal $a)
    {
        throw new \Exception('not yet implemented');
    }
}
