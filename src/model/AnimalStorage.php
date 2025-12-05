<?php
namespace Model;

interface AnimalStorage {

    /**
     * Récupère un animal par son identifiant
     * 
     * @param string $id L'identifiant de l'animal
     * @return Animal|null L'animal trouvé ou null si aucun animal ne correspond
     */
    public function read($id);

    /**
     * Récupère tous les animaux
     * 
     * @return Animal[] Un tableau associatif avec l'identifiant comme clé et l'animal comme valeur
     */
    public function readAll();

    /**
     * Ajoute un nouvel animal dans la base
     * 
     * @param Animal $a L'animal à ajouter
     * @return string L'identifiant de l'animal ajouté
     */
    public function create(Animal $a);

    /**
     * Supprime un animal de la base
     * 
     * @param string $id L'identifiant de l'animal à supprimer
     * @return bool True si l'animal a été supprimé, false sinon
     */
    public function delete($id);

    /**
     * Met à jour un animal dans la base
     * 
     * @param string $id L'identifiant de l'animal à mettre à jour
     * @param Animal $a L'animal qui remplacera l'animal existant
     * @return bool True si l'animal a été mis à jour, false sinon
     */
    public function update($id, Animal $a);
}
