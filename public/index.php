<?php

use Slim\Factory\AppFactory;
use App\Controllers\UserController;  // Ubah dari src\Models\User menjadi App\Models\User

use App\Controllers\JobController;
use App\Controllers\PageController;
use Selective\BasePath\BasePathMiddleware;
use App\Controllers\SocialLinkController;
use App\Controllers\ProfileController;
use App\Controllers\LoginController;
use app\Controllers\CareerResourceController;
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



$app->get('/', function ($request, $response, $args) {
    $data = ['message' => 'Testing aja boskuh'];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/jobs', [JobController::class, 'getAllJobs']);
$app->get('/job/{id}', [JobController::class, 'getJobById']);



$app->get('/users', [UserController::class, 'getAllUsers']);
$app->get('/user/{id}', [UserController::class, 'getUserById']);
$app->post('/users', [UserController::class, 'createUser']);
$app->put('/users/update/{id}', [UserController::class, 'updateUser']);
$app->delete('/users/delete/{id}', [UserController::class, 'deleteUser']);

// Rute untuk mendapatkan semua social link
$app->get('/social-links', [SocialLinkController::class, 'getAllSocialLinks']);
$app->get('/social-links/{id}', [SocialLinkController::class, 'getSocialLinkById']);
$app->post('/social-links/add', [SocialLinkController::class, 'createSocialLink']);
$app->put('/social-links/update/{id}', [SocialLinkController::class, 'updateSocialLink']);
$app->delete('/social-links/delete/{id}', [SocialLinkController::class, 'deleteSocialLink']);

$app->get('/profiles', [ProfileController::class, 'getAllProfiles']);
$app->get('/profiles/{id}', [ProfileController::class, 'getProfileById']);
$app->post('/profiles/add', [ProfileController::class, 'createProfile']);
$app->put('/profiles/update/{id}', [ProfileController::class, 'updateProfile']);
$app->delete('/profiles/delete/{id}', [ProfileController::class, 'deleteProfile']);

$app->get('/resources', [CareerResourceController::class, 'getAllResources']);
$app->get('/resources/{id}', [CareerResourceController::class, 'getResourceById']);
$app->post('/resources', [CareerResourceController::class, 'createResource']);
$app->put('/resources/{id}', [CareerResourceController::class, 'updateResource']);
$app->delete('/resources/{id}', [CareerResourceController::class, 'deleteResource']);

$app->post('/applications/apply', [ApplicationsController::class, 'applyForJob']);
$app->get('/applications/{id}/status', [ApplicationsController::class, 'trackApplicationStatus']);
$app->get('/applications/user/{id}', [ApplicationsController::class, 'getApplicationsByUser']);

// Jalankan aplikasi Slim
$app->run();
