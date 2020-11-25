<?php

namespace App\Controller;

use App\File\UploadService;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Message\UploadedFileFactoryInterface;
// use Twig\Template;

class HomeController extends AbstractController
{
    public function homepage
    (ResponseInterface $response,
     ServerRequestInterface $request,
     UploadService $uploadService,
     Connection $connection)
    {
       // Récupérer les fichiers envoyés:
       $listeFichiers = $request->getUploadedFiles();

        // Seulement SI le formulaire a été envoyé correctement
       if (isset($listeFichiers['fichier'])) {
        /** @var UploadedFileInterface $fichier */
        $fichier = $listeFichiers['fichier'];

        // Récupérer le nouveau nom du fichier
        $nouveauNom = $uploadService->saveFile($fichier);

        // Enregistrer les infos du fichier en base de données
        $connection->insert('fichier', [
            'nom' => $nouveauNom,
            'nom_original' => $fichier->getClientFilename(),
        ]);

        $connection->executeStatement('INSERT INTO fichier (nom, nom_original) VALUES (:nom, :nom_original)', [
            'nom' => $nouveauNom,
            'nom_original' => $fichier->getClientFilename(),
        ]);

        $query = $connection->prepare('INSERT INTO fichier (nom, nom_original) VALUES (:nom, :nom_original)');
        $query->bindValue('nom', $nouveauNom);
        $query->bindValue('nom_original', $fichier->getClientFilename());
        $query->execute();

        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder
            ->insert('fichier')
            ->values([
                'nom' => $nouveauNom,
                'nom_original' => $fichier->getClientFilename(),
            ])

        ;
        $queryBuilder->execute();

        // Afficher un message à l'utilisateur
        
    }

      // Pour récupérer les fichiers envoyés :
      return $this->template($response, 'home.html.twig');

    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiant: %d', $id));
        return $response;
    }
}