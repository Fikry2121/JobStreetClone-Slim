<?php

use Slim\Factory\AppFactory;
use App\Controllers\UserController;  // Ubah dari src\Models\User menjadi App\Models\User

use App\Controllers\JobPostController;
use App\Controllers\PageController;
use Selective\BasePath\BasePathMiddleware;
use App\Controllers\SocialLinkController;
use App\Controllers\ProfileController;
use App\Controllers\LoginController;

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

$app->get('/', [LoginController::class, 'login']);
$app->get('/users', [UserController::class, 'getAllUsers']);
$app->get('/users/{id}', [UserController::class, 'getUserById']);
$app->post('/users/add', [UserController::class, 'createUser']);
$app->put('/users/update/{id}', [UserController::class, 'updateUser']);
$app->delete('/users/delete/{id}', [UserController::class, 'deleteUser']);

$app->get('/Job_post', [JobPostController::class, 'getAllJobs']);
$app->get('/Job_post/{id}', [JobPostController::class, 'getJobById']);
$app->post('/Job_post/add', [JobPostController::class, 'createJob']);
$app->put('/Job_post/update/{id}', [JobPostController::class, 'updateJob']);
$app->delete('/Job_post/delete/{id}', [JobPostController::class, 'deleteJob']);

$app->get('/pages', [PageController::class, 'getAllPages']);
$app->get('/pages/{id}', [PageController::class, 'getPageById']);
$app->post('/pages/add', [PageController::class, 'createPage']);
$app->put('/pages/update/{id}', [PageController::class, 'updatePage']);
$app->delete('/pages/delete/{id}', [PageController::class, 'deletePage']);
$app->get('/pages/{id}/blocks', [PageController::class, 'getBlocksByPage']);
$app->get('/pages/{id}/user', [PageController::class, 'getUserByPage']);

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



// Jalankan aplikasi Slim
$app->run();