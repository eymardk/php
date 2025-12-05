<?php
namespace Model;

class AnimalBuilder
{
    // Constantes pour les noms de champs
    const NAME_REF = 'name';
    const SPECIES_REF = 'species';
    const AGE_REF = 'age';
    
    private $data;
    private $error;
    
    public function __construct(array $data = [])
    {
        $this->data = $data;
        $this->error = null;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function getError()
    {
        return $this->error;
    }
    
    #partie pour faire la vérification sur les donées 
    public function isValid()
    {
        $errors = [];
        
        // Vérifier le nom
        if (!isset($this->data[self::NAME_REF]) || trim($this->data[self::NAME_REF]) === '') {
            $errors[] = "Le nom ne peut pas être vide";
        }
        
        // Vérifier l'espèce
        if (!isset($this->data[self::SPECIES_REF]) || trim($this->data[self::SPECIES_REF]) === '') {
            $errors[] = "L'espèce ne peut pas être vide";
        }
        
        // Vérifier l'âge
        if (!isset($this->data[self::AGE_REF]) || !is_numeric($this->data[self::AGE_REF]) || $this->data[self::AGE_REF] < 0) {
            $errors[] = "L'âge n'est pas correct";
        }
        
        if (!empty($errors)) {
            $this->error = implode(". ", $errors);
            return false;
        }
        
        return true;
    }
    
    /**
     * Crée une instance d'Animal à partir des données
     * @return Animal
     */
    public function createAnimal()
    {
        return new Animal(
            $this->data[self::NAME_REF],
            $this->data[self::SPECIES_REF],
            (int)$this->data[self::AGE_REF]
        );
    }
}