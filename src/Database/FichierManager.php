<?php

namespace App\Database;

use App\Database\Fichier;
use Doctrine\DBAL\Connection;



/**
 * Ce service est en charge de la gestion des données de la table "fichier"
 * Elle doit utiliser des objets de la classe Ficher 
 */

 class FichierManager
 {
     private Connection $connection;

     /**
      * Les objets FichierManager pourront être demandés en argument dans les controlleurs
      * Pour les instancer, le conteneur de services va lire la liste d'arguments du constructeur
      * Ici, il va d'abord instancier le service Connection pour pouvoir, instancier. FichierManager
      */
      public function __construct(Connection $connection)
     {
        $this->connection = $connection;
     }

     /**
      * Récupérer 1 fichier par son id
      *
      * @param int $id l'identifiant en base du fichier
      * @return Fichier|null le fichier trouvé ou null en l'absence de résultat
      */
      public function getById(int $id): ?Fichier
      {
        $query = $this->connection->prepare('SELECT * FROM fichier WHERE id = :id');
        $query->bindValue('id', $id);
        $result = $query->execute();

        // Tableau associatif contenant les données du fichier, ou false si aucun résultat
        $fichierData = $result->fetchAssociative();

        if ($fichierData === false) {
            return null;
        }

        // Création d'une instance de fichier
        return $this->createObject($fichierData['id'], $fichierData['nom'], $fichierData['nom_original']);
      }

      /**
       * Enregistrer un nouveau fichier en base de données
       */
      public function createFichier(string $nom, string $nomOriginal): Fichier
      {
          // Enregistrer en base de données (voir HomeController:homepage() )
          $this->connection->insert('fichier', [
            'nom' => $nom,
            'nom_original' => $nomOriginal,
        ]);

          // Récupéer l'identifiant généré au fichier enregistré
          $id = $this->connection->lastInsertId();

          // Créer un objet Fichier et le retourner : créer une méthode createObject()
          return $this->createObject($id, $nom, $nomOriginal);
      }
      /**
       * Créer un objet fichier à partir de ces informations
       */

      private function createObject(int $id, string $nom, string $nomOriginal): Fichier{
          $fichier = new Fichier();
          $fichier
            ->setId($id)
            ->setNom($nom)
            ->setNomOriginal($nomOriginal)
        ;
        return $fichier;
      }
 }