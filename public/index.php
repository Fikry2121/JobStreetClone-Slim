<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\UserController;
use App\Controllers\OrderController;
use App\Controllers\ServiceController;
use App\Controllers\ReviewController;
use App\Controllers\ProjectBriefController;
use App\Controllers\CategoryController;

require __DIR__ . '/../vendor/autoload.php';

// Inisialisasi aplikasi
$app = AppFactory::create();

// Middleware untuk routing dan error handling
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);  // Gunakan log error saat pengembangan

// Route Definitions untuk User
$app->get('/users-data/all', [UserController::class, 'getAllUsers']);  // Ambil semua user
$app->post('/users-data/add', [UserController::class, 'addUser']);      // Tambah user
$app->put('/users-data/update/{id}', [UserController::class, 'updateUser']); // Update user
$app->delete('/users-data/delete/{id}', [UserController::class, 'deleteUser']); // Hapus user

// Route Definitions untuk Order
$app->get('/orders-data/all', [OrderController::class, 'getAllOrders']);  // Ambil semua orders
$app->post('/orders-data/add', [OrderController::class, 'addOrder']);      // Tambah order
$app->put('/orders-data/update/{id}', [OrderController::class, 'updateOrder']); // Update order
$app->delete('/orders-data/delete/{id}', [OrderController::class, 'deleteOrder']); // Hapus order

// Route Definitions untuk Service
$app->get('/services-data/all', [ServiceController::class, 'getAllServices']);  // Ambil semua services
$app->post('/services-data/add', [ServiceController::class, 'addService']);      // Tambah service
$app->put('/services-data/update/{id}', [ServiceController::class, 'updateService']); // Update service
$app->delete('/services-data/delete/{id}', [ServiceController::class, 'deleteService']); // Hapus service

// Route Definitions untuk Review
$app->get('/reviews-data/all', [ReviewController::class, 'getAllReviews']);  // Ambil semua reviews
$app->post('/reviews-data/add', [ReviewController::class, 'addReview']);      // Tambah review
$app->put('/reviews-data/update/{id}', [ReviewController::class, 'updateReview']); // Update review
$app->delete('/reviews-data/delete/{id}', [ReviewController::class, 'deleteReview']); // Hapus review

// Route Definitions untuk Project Brief
$app->get('/project-briefs-data/all', [ProjectBriefController::class, 'getAllProjectBriefs']);  // Ambil semua project briefs
$app->post('/project-briefs-data/add', [ProjectBriefController::class, 'addProjectBrief']);      // Tambah project brief
$app->put('/project-briefs-data/update/{id}', [ProjectBriefController::class, 'updateProjectBrief']); // Update project brief
$app->delete('/project-briefs-data/delete/{id}', [ProjectBriefController::class, 'deleteProjectBrief']); // Hapus project brief

// Route Definitions untuk Category
$app->get('/categories-data/all', [CategoryController::class, 'getAllCategories']);  // Ambil semua categories
$app->post('/categories-data/add', [CategoryController::class, 'addCategory']);      // Tambah category
$app->put('/categories-data/update/{id}', [CategoryController::class, 'updateCategory']); // Update category
$app->delete('/categories-data/delete/{id}', [CategoryController::class, 'deleteCategory']); // Hapus category

// Jalankan aplikasi
$app->run();
