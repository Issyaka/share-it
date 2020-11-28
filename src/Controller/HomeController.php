<?php

namespace App\Controller;

use App\Database\FichierManager;
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
     FichierManager $fichierManager)
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
        $fichier = $fichierManager->createFichier($nouveauNom, $fichier->getClientFilename());
        
        // Redirection vers la page de succès
        return $this->redirect('success', [
            'id' => $fichier->getId(),
            ]);
    }

        return $this->template($response, 'home.html.twig');

    }


    /**
     * Vérifier que l'identifiant (argument $id) correspond à un fichier existant
     * Si ce n'est pas le cas, rediriger vers une route qui affichera un message d'erreur
     */

        public function success(ResponseInterface $response, int $id,  FichierManager $fichierManager)
        {
            $fichier = $fichierManager->getById($id);
            if ($fichier === null) {
                return $this->redirect('file-error');
            }

            return $this->template($response, 'success.html.twig', [
                'fichier' => $fichier
            ]);         
        }

        public function fileError(ResponseInterface $response)
        {
            return $this->template($response, 'file-error.html.twig');
        }

    public function download(ResponseInterface $response, int $id, FichierManager $fichierManager)
    {

        $file = $fichierManager->getById($id);
        if ($file === null) {
            return $this->redirect('file-error');
        }

        $original_filename = $file->getNomOriginal();
        if (file_exists($original_filename)) {
        
            header('Content-Disposition: attachment; filename="' . basename($original_filename) . '"');   
            readfile($original_filename);
            exit;
    
        }

        return $response;
    }
}