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
        
        $data['workoutData'] = array(
            'user_id' => $userId
        );

        //TODO: check if there is an existing workout?
        $currentWorkout = $workoutModel->workoutExists($userId);

        echo 'here';
        $data['listOfExercises'] = [];
        // $this->getAllMuscles();
        
        $listOfExercises = $this->getAllMuscles();
        
        foreach ($listOfExercises as $loe) {
            array_push($data['listOfExercises'], $loe['name']);
        }

        if ($currentWorkout) {
            $data['workoutId'] = $currentWorkout[0]['id'];
            $data['currentWorkoutDetails'] = $workoutModel->getCurrentWorkoutDetails($data['workoutId']);

            // foreach (currentWorkoutDetails[''])
        } else {
            $data['workoutId'] = $workoutModel->createNewWorkout($data['workoutData']);
            $data['currentWorkoutDetails'] = $workoutModel->getCurrentWorkoutDetails($data['workoutId']);
            // echo "\n\n CREATENEWWORKOUT: " . json_encode($data['createNewWorkout']);
        }
        

        echo view('layout/header');
        echo view('workouts/current_workout', $data);
        echo view('layout/footer');
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

    private function getAllMuscles() 
    {
        $curl = curl_init();      

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://exercises-by-api-ninjas.p.rapidapi.com/v1/exercises?difficulty=beginner",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: exercises-by-api-ninjas.p.rapidapi.com",
		        "X-RapidAPI-Key: 7e072d9e51mshd2d764fe7eddea6p1776b5jsna4133f3db280"
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return $err;
            // log_message('error', "cURL Error #:" . $err);
        } else {
            return json_decode($response, true);
            // log_message('debug', $response);
        }

    }

    private function getRequest($endpoint = null) 
    {
        // return true;
        $curl = curl_init();

        if ($endpoint) {
            $endpoint = $endpoint;
        } else {
            $endpoint = 'all';
        }        

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://exercises-by-api-ninjas.p.rapidapi.com/v1/exercises?muscle=biceps",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: exercises-by-api-ninjas.p.rapidapi.com",
		        "X-RapidAPI-Key: 7e072d9e51mshd2d764fe7eddea6p1776b5jsna4133f3db280"
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return $err;
            // log_message('error', "cURL Error #:" . $err);
        } else {
            return $response;
            // log_message('debug', $response);
        }
    }

    public function submitWorkoutExercise() 
    {
        $workoutModel = new WorkoutModel();   
        helper(['form']);
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $userId = session('id');

        $workoutData = array(
            'user_id' => $userId
        );

        $validation->setRules([
            'exercise_name' => 'required|min_length[2]|max_length[50]',
            'reps' => 'required|min_length[1]|max_length[3]',
            'weight' => 'required|min_length[1]|max_length[4]',
            'workout_id' => 'required|min_length[1]'
        ]);

        if ($validation->withRequest($request)->run()) {
            // If you want to get the validated data.
            $validData = $validation->getValidated();
            echo json_encode($validData);
            
            $workoutData['workout_id'] = $validData['workout_id'];
            $workoutData['exercise_name'] = $validData['exercise_name'];
            $workoutData['exercise_reps'] = $validData['reps'];
            $workoutData['exercise_weight'] = $validData['weight'];

            // $workoutModel->addNewExercise($workoutData);
            // $workoutModel->addNewSet($workoutData);
            $workoutModel->addNewExerciseSet($workoutData);
            // ...
        }


    }

    public function submitWorkoutSet()
    {
        echo "HERE";
        $this->getCurrentWorkoutDetails();
    }

    public function myWorkoutsHistory()
    {
        $workoutModel = new WorkoutModel();   
        $userId = session('id');
        $workoutHistory = $workoutModel->getMyWorkoutsHistory($userId);
        echo "\n\n WORKOUTHISTORY: " . json_encode($workoutHistory);
    }

}
