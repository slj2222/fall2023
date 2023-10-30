<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\WorkoutModel;

class WorkoutController extends Controller
{
    public function index()
    {
    }

    public function planWorkout()
    {
        $session = session();
        echo view('layout/header');
        echo view('dashboard/main');
        echo view('layout/footer');
    }

    public function Test()
    {
        echo 'here';
        $workoutModel = new WorkoutModel();
        
        $workoutData = array(
            'user_id' => 1
        );

        // $testInsert = $workoutModel->createWorkout($workoutData);
        $testInsert = $workoutModel->getMyWorkouts(1);
    }

 
    

    public function getCurrentWorkoutDetails()
    {
        $workoutModel = new WorkoutModel();
        $userId = session('id');

        $currentWorkout = $workoutModel->workoutExists($userId);
        if ($currentWorkout) {
            $workoutId = $currentWorkout[0]['id'];
            $currentWorkoutDetails = $workoutModel->getCurrentWorkoutDetails($workoutId);
            echo "\n\n CURRENTWORKOUTDETAILS: " . json_encode($currentWorkoutDetails);
        }

        
        

        $workoutData = array(
            // 'workout_id' => $currentWorkoutDetails
        );
        

    }

    private function addExercise(){

    }

    private function updateExercise()
    {
        // helper(['form']);
        // $rules = [
        //     'name'          => 'required|min_length[2]|max_length[50]',
        //     'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
        //     'password'      => 'required|min_length[4]|max_length[50]',
        //     'confirmpassword'  => 'matches[password]'
        // ];
    }

















    public function createWorkout() {
        echo 'here';
        $workoutModel = new WorkoutModel();
        $userId = session('id');
        
        $workoutData = array(
            'user_id' => $userId
        );

        $createNewWorkout = $workoutModel->createNewWorkout($workoutData);
        echo "\n\n CREATENEWWORKOUT: " . json_encode($createNewWorkout);
    }


    public function myWorkoutsHistory()
    {
        $workoutModel = new WorkoutModel();   
        $userId = session('id');
        $workoutHistory = $workoutModel->getMyWorkoutsHistory($userId);
        echo "\n\n WORKOUTHISTORY: " . json_encode($workoutHistory);
    }

}
