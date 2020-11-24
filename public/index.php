<?php
/**
 * This file is the Front Controller
 * HTTP traffic must be redirected to this file
 *
 * @var App $app
 */

use App\Controller\HomeController;
use Slim\App;

// App configuration
require_once __DIR__ . '/../config/bootstrap.php';
 // $app->setBasePath ('slim-app');

// Application routes
// $app
   // ->get('/', [HomeController::class, 'homepage'])
   // ->setName('homepage')
//  ;

$app
    ->map(['GET', 'POST'], '/', [HomeController::class, 'homepage'])
    ->setName('homepage')
;

// On peut indiquer des paramètres dans les routes entre accolades: {param}
// On peut indiquer leur format avec des RegEx: \d+ (constitué d'un ou plusieurs chiffres)
// Les paramètres seront envoyés en argument de la méthode du controlleur

$app
    ->get('/download/{id:\d+}', [HomeController::class, 'download'])
    ->setName('download')
;

 // $app
 //   ->get('/a-propos', [HomeController::class, 'about'])
 //   ->setName('about')
 // ;

// Start the application
$app->run();

