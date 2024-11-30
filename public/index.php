<?php

use Slim\Factory\AppFactory;
use App\Controllers\UserController;

use App\Controllers\JobController;
use App\Controllers\CompanyReviewController;
use Selective\BasePath\BasePathMiddleware;
use App\Controllers\SocialLinkController;
use App\Controllers\ProfileController;
use App\Controllers\LoginController;

use App\Controllers\ApplicationController;

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




$app->get('/job', [JobController::class, 'getAllJobs']);
$app->get('/job/{id}', [JobController::class, 'getJobById']);

// Routes untuk CompanyRevieCRUDa
$app->post('/company-review', [CompanyReviewController::class, 'createReview']); // Tambah ulasan baru
$app->get('/company-review/company/{id_company}', [CompanyReviewController::class, 'getReviewsByCompany']); // Ambil semua ulasan berdasarkan ID perusahaan
$app->get('/company-review/{id_review}', [CompanyReviewController::class, 'getReviewById']); // Ambil ulasan berdasarkan ID ulasan
$app->put('/company-review/{id_review}', [CompanyReviewController::class, 'updateReview']); // Perbarui ulasan berdasarkan ID ulasan
$app->delete('/company-review/{id_review}', [CompanyReviewController::class, 'deleteReview']); // Hapus ulasan berdasarkan ID ulasan


$app->post('/users', [UserController::class, 'createUser']);
$app->get('/users', [UserController::class, 'getAllUsers']);
$app->get('/users/{id}', [UserController::class, 'getUserById']);
$app->put('/users/{id}', [UserController::class, 'updateUser']);
$app->delete('/users/{id}', [UserController::class, 'deleteUser']);

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



$app->get('/application', \App\Controllers\ApplicationController::class . ':getAllApplications');
$app->get('/application/{id}', \App\Controllers\ApplicationController::class . ':getApplicationById');
$app->post('/application', \App\Controllers\ApplicationController::class . ':createApplication');
$app->put('/application/{id}', \App\Controllers\ApplicationController::class . ':updateApplicationStatus');
$app->delete('/application/{id}', \App\Controllers\ApplicationController::class . ':deleteApplication');

// Jalankan aplikasi Slim
$app->run();
