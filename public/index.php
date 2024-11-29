<?php

use Slim\Factory\AppFactory;
use App\Controllers\UserController;
use App\Controllers\JobController;
use App\Controllers\PageController;
use Selective\BasePath\BasePathMiddleware;
use App\Controllers\SocialLinkController;
use App\Controllers\ProfileController;
use App\Controllers\LoginController;
use App\Controllers\CareerResourceController;
use App\Controllers\ApplicationsController;

require __DIR__ . '/../vendor/autoload.php';

// Create Slim app
$app = AppFactory::create();

// Middleware untuk parsing body request dan routing
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

// Middleware untuk menambahkan BasePath jika dibutuhkan
$app->add(new BasePathMiddleware($app));

// Error Middleware
$app->addErrorMiddleware(true, true, true);

// Endpoint untuk testing
$app->get('/', function ($request, $response, $args) {
    $data = ['message' => 'Testing aja boskuh'];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

// Endpoint untuk jobs
$app->get('/jobs', [JobController::class, 'getAllJobs']);
$app->get('/job/{id}', [JobController::class, 'getJobById']);

// Endpoint untuk users
$app->get('/users', [UserController::class, 'getAllUsers']);
$app->get('/user/{id}', [UserController::class, 'getUserById']);
$app->post('/user', [UserController::class, 'createUser']); 
$app->put('/user/{id}', [UserController::class, 'updateUser']); 
$app->delete('/user/{id}', [UserController::class, 'deleteUser']); 

// End Point untuk social media
$app->get('/social-links', [SocialLinkController::class, 'getAllSocialLinks']);
$app->get('/social-link/{id}', [SocialLinkController::class, 'getSocialLinkById']); 
$app->post('/social-link', [SocialLinkController::class, 'createSocialLink']); 
$app->put('/social-link/{id}', [SocialLinkController::class, 'updateSocialLink']); 
$app->delete('/social-link/{id}', [SocialLinkController::class, 'deleteSocialLink']); 

// End Point untuk profiles
$app->get('/profiles', [ProfileController::class, 'getAllProfiles']);
$app->get('/profile/{id}', [ProfileController::class, 'getProfileById']); 
$app->post('/profile', [ProfileController::class, 'createProfile']); 
$app->put('/profile/{id}', [ProfileController::class, 'updateProfile']); 
$app->delete('/profile/{id}', [ProfileController::class, 'deleteProfile']); 

// End Point untuk resources
$app->get('/resources', [CareerResourceController::class, 'getAllResources']);
$app->get('/resource/{id}', [CareerResourceController::class, 'getResourceById']); 
$app->post('/resource', [CareerResourceController::class, 'createResource']); 
$app->put('/resource/{id}', [CareerResourceController::class, 'updateResource']); 
$app->delete('/resource/{id}', [CareerResourceController::class, 'deleteResource']); 

// End Point unntuk application
$app->post('/application/apply', [ApplicationsController::class, 'applyForJob']); 
$app->get('/application/{id}/status', [ApplicationsController::class, 'trackApplicationStatus']); 
$app->get('/applications/user/{id}', [ApplicationsController::class, 'getApplicationsByUser']); 

// Jalankan aplikasi Slim
$app->run();
