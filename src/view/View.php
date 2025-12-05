<?php

require_once('config/config.php');

class View
{
    private $title;
    private $content;
    private $router;
    private $menu;
    private $feedback;

    public function __construct($router, $feedback = null)
    {
        $this->router = $router;
        $this->feedback = $feedback;

   
        $this->menu = [
            $this->router->getHomeURL() => 'Accueil',
            $this->router->getListURL() => 'Liste des animaux',
            $this->router->getAnimalCreationURL() => 'Ajouter un animal'
        ];
    }

    public function render()
    {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($this->title); ?></title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f5f5f5;
                }
                h1 {
                    color: #333;
                    border-bottom: 2px solid #4CAF50;
                    padding-bottom: 10px;
                }
                .content {
                    background-color: white;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                }
                a {
                    color: #4CAF50;
                    text-decoration: none;
                }
                a:hover {
                    text-decoration: underline;
                }
                ul {
                    list-style-type: none;
                    padding: 0;
                }
                li {
                    padding: 10px;
                    margin: 5px 0;
                    background-color: #f9f9f9;
                    border-left: 3px solid #4CAF50;
                }
                .menu {
                    background-color: #f0f0f0;
                    padding: 10px;
                    margin-bottom: 20px;
                    border-radius: 5px;
                }
                .menu a {
                    margin-right: 15px;
                }
                input[type="text"], input[type="number"], input[type="file"] {
                    padding: 8px;
                    margin: 10px 0;
                    width: 100%;
                    box-sizing: border-box;
                }
                input[type="submit"] {
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    padding: 10px;
                    width: 100%;
                    cursor: pointer;
                }
                input[type="submit"]:hover {
                    background-color: #45a049;
                }
            </style>
        </head>
        <body>
            <div class="menu">
                <?php
                foreach ($this->menu as $url => $text) {
                    echo "<a href='" . htmlspecialchars($url) . "'>" . htmlspecialchars($text) . '</a>';
                }
                ?>
            </div>
            <?php if ($this->feedback !== null): ?>
            <div style='background-color: #ddffdd; border: 1px solid #00aa00; padding: 10px; margin: 20px 0; border-radius: 5px;'>
                <strong>✓</strong> <?php echo htmlspecialchars($this->feedback); ?>
            </div>
            <?php endif; ?>
            <h1><?php echo htmlspecialchars($this->title); ?></h1>
            <div class="content">
                <?php echo $this->content; ?>
            </div>
        </body>
        </html>
        <?php
    }

    public function prepareTestPage()
    {
        $this->title = 'Page de test';
        $this->content = '<p>Ceci est une page de test pour vérifier que la vue fonctionne correctement.</p>';
    }

    public function prepareUnknownAnimalPage()
    {
        $this->title = 'Erreur';
        $this->content = "<p style='color: red;'>Animal inconnu</p>";
    }

    public function prepareHomePage()
    {
        $this->title = 'Bienvenue';
        $this->content = '<p>Bienvenue sur le site des animaux !</p>';
    }

    public function prepareListPage($animals)
    {
        $this->title = 'Liste des animaux';

        $this->content = '<p>Voici la liste de tous les animaux du site :</p>';
        $this->content .= '<ul>';

        // Pour chaque animal, on crée un élément de liste avec un lien
        foreach ($animals as $id => $animal) {
            // Génère l'URL vers la page de l'animal via le routeur
            $url = $this->router->getAnimalURL($id);

            // Ajoute l'élément de liste
            $this->content .= '<li>';
            $this->content .= "<a href='" . htmlspecialchars($url) . "'>";
            $this->content .= htmlspecialchars($animal->getName());
            $this->content .= '</a>';
            $this->content .= ' (' . htmlspecialchars($animal->getSpecies()) . ')';
            $this->content .= '</li>';
        }

        $this->content .= '</ul>';
        // Utiliser le routeur pour le lien de retour
        $this->content .= "<p><a href='" . htmlspecialchars($this->router->getHomeURL()) . "'>Retour à l'accueil</a></p>";
    }

    public function prepareDebugPage($variable)
    {
        $this->title = 'Debug';
        $this->content = '<pre>' . htmlspecialchars(var_export($variable, true)) . '</pre>';
    }

    public function prepareAnimalCreationPage($builder)
    {
        $this->title = "Création d'un nouvel animal";

        $formAction = $this->router->getAnimalSaveURL();
        
        // Récupérer les données du builder
        $data = $builder->getData();
        $error = $builder->getError();
        
        // Utiliser les constantes de AnimalBuilder
        $name = isset($data[\Model\AnimalBuilder::NAME_REF]) ? htmlspecialchars($data[\Model\AnimalBuilder::NAME_REF]) : '';
        $species = isset($data[\Model\AnimalBuilder::SPECIES_REF]) ? htmlspecialchars($data[\Model\AnimalBuilder::SPECIES_REF]) : '';
        $age = isset($data[\Model\AnimalBuilder::AGE_REF]) ? htmlspecialchars($data[\Model\AnimalBuilder::AGE_REF]) : '';
        
        // Afficher le message d'erreur si présent
        $errorHtml = '';
        if ($error !== null) {
            $errorHtml = "<div style='background-color: #ffdddd; border: 1px solid #ff0000; padding: 10px; margin-bottom: 20px; border-radius: 5px;'>
                            <strong>Erreur :</strong> " . htmlspecialchars($error) . "
                          </div>";
        }

        // Utiliser les constantes pour les noms de champs
        $nameRef = \Model\AnimalBuilder::NAME_REF;
        $speciesRef = \Model\AnimalBuilder::SPECIES_REF;
        $ageRef = \Model\AnimalBuilder::AGE_REF;

        $this->content = $errorHtml . "
        <form action='" . htmlspecialchars($formAction) . "' method='POST' enctype='multipart/form-data'>
            <label for='$nameRef'>Nom de l'animal:</label>
            <input type='text' id='$nameRef' name='$nameRef' value='$name'>

            <label for='$speciesRef'>Espèce:</label>
            <input type='text' id='$speciesRef' name='$speciesRef' value='$species'>

            <label for='$ageRef'>Âge:</label>
            <input type='number' id='$ageRef' name='$ageRef' value='$age'>

            <input type='submit' value='Créer '>
        </form>
        <p><a href='" . htmlspecialchars($this->router->getHomeURL()) . "'>Retour à l'accueil</a></p>
        ";
    }

    public function prepareAnimalPage($animal)
    {
        $this->title = 'Page sur ' . $animal->getName();
        
        // Afficher l'image si elle existe
        $this->content = '';
        
        $this->content .= '<p><strong>' . htmlspecialchars($animal->getName()) . "</strong> est un animal de l'espèce <em>" . htmlspecialchars($animal->getSpecies()) . '</em>.</p>';
        $this->content .= '<p>Âge : ' . htmlspecialchars($animal->getAge()) . ' an(s).</p>';
        
        // Lien de retour vers la liste
        $this->content .= "<p><a href='" . htmlspecialchars($this->router->getListURL()) . "'>Retour à la liste</a></p>";
    }

    public function displayAnimalCreationSuccess($id)
    {
        $url = $this->router->getAnimalURL($id);
        $this->router->POSTredirect($url, 'Animal créé avec succès !');
    }
}
?>