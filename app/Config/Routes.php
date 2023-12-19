<?php

use App\Controllers\WorkoutController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'SignupController::index');
 $routes->get('/signup', 'SignupController::index');
 $routes->match(['get', 'post'], 'SignupController/store', 'SignupController::store');
 $routes->match(['get', 'post'], 'LoginController/loginAuth', 'LoginController::loginAuth');
 $routes->get('/login', 'LoginController::index');
 $routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);
// $routes->get('/workouts/plan', [WorkoutController::class, 'index']);

//  $routes->get('/workouts/plan', 'WorkoutController::test');
 $routes->get('/workouts/history', 'WorkoutController::myWorkoutsHistory');
 $routes->get('/workouts/create', 'WorkoutController::createWorkout');
 $routes->get('/workouts/continue', 'WorkoutController::getCurrentWorkoutDetails');


 $routes->post('/workouts/submitWorkoutExercise', 'WorkoutController::submitWorkoutExercise');
 $routes->post('/workouts/submitWorkoutSet', 'WorkoutController::submitWorkoutSet');
//  $routes->




