<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\WorkoutModel;

// set_time_limit(300);


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
        $workoutModel = new WorkoutModel();
        $userId = session('id');
        
        $data['workoutData'] = array(
            'user_id' => $userId
        );

        //TODO: check if there is an existing workout?
        $currentWorkout = $workoutModel->workoutExists($userId);

        $data['listOfExercises'] = [];
        
        $listOfExercises = $this->getAllMuscles();
        
        foreach ($listOfExercises as $loe) {
            array_push($data['listOfExercises'], $loe['name']);
        }

        if ($currentWorkout) {
            $data['workoutId'] = $currentWorkout[0]['id'];
            $workoutDetailsArr = $workoutModel->getCurrentWorkoutDetails($data['workoutId']);

            $data['currentWorkoutDetails'] = $this->groupBy($workoutDetailsArr, 'exercise_name');

            // foreach (currentWorkoutDetails[''])
        } else {
            $data['workoutId'] = $workoutModel->createNewWorkout($data['workoutData']);
            $workoutDetailsArr = $workoutModel->getCurrentWorkoutDetails($data['workoutId']);

            $data['currentWorkoutDetails'] = $this->groupBy($workoutDetailsArr, 'exercise_name');
            // echo "\n\n CREATENEWWORKOUT: " . json_encode($data['createNewWorkout']);
        }
        

        echo view('layout/header');
        echo view('workouts/current_workout', $data);
        echo view('layout/footer');
    }

    public function continueWorkout()
    {
        $workoutModel = new WorkoutModel();
        $userId = session('id');
        
        $data['workoutData'] = array(
            'user_id' => $userId
        );

        //TODO: check if there is an existing workout?
        $currentWorkout = $workoutModel->workoutExists($userId);

        $data['listOfExercises'] = [];
        
        $listOfExercises = $this->getAllMuscles();
        
        foreach ($listOfExercises as $loe) {
            array_push($data['listOfExercises'], $loe['name']);
        }

        // if ($currentWorkout) {
            $data['workoutId'] = $currentWorkout[0]['id'];
            $workoutDetailsArr = $workoutModel->getCurrentWorkoutDetails($data['workoutId']);

            $data['currentWorkoutDetails'] = $this->groupBy($workoutDetailsArr, 'exercise_name');
        // } else {
        //     $data['workoutId'] = $workoutModel->createNewWorkout($data['workoutData']);
        //     $data['currentWorkoutDetails'] = $workoutModel->getCurrentWorkoutDetails($data['workoutId']);
        //     // echo "\n\n CREATENEWWORKOUT: " . json_encode($data['createNewWorkout']);
        // }
        

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

       
            $workoutModel->addNewWorkoutsExercises($workoutData);

            $this->continueWorkout();

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

    private function groupBy($array, $key) {   
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }

        log_message('debug', 'GROUPED ARR: ' . json_encode($return) . "\n");
        
        return $return;
    }
    







    //FOR API -> DB COPY (EXERCISES)
    public function populateExerciseDbFromApi() 
    {
        //ALL HAVE BEEN COPIED TO THE DB.
        $muscles = [
            'abductors',
            'calves',
            'forearms',
            'glutes',
            'adductors',
            'hamstrings',
            'lower_back',
            'middle_back',
            'biceps',
            'lats',
            'neck',
            'traps',
            'triceps',
            'abdominals',
            'chest',
            'quadriceps',
        ];
        
        forEach($muscles as $muscle) {
            for ($i = 510; $i <= 1000; $i+=10) {
                
                $offset = $i;
                log_message('debug', 'offset: ' . $offset . "\n");

                $this->apiGetAndInsertToDb($muscle, $offset);
            }
        }
    }

    public function apiGetAndInsertToDb($muscle, $offset) {
        $workoutModel = new WorkoutModel();

        $curl = curl_init();      

        curl_setopt_array($curl, [
            //option 1 :
            // CURLOPT_URL => "https://exercises-by-api-ninjas.p.rapidapi.com/v1/exercises?muscle=" . $muscle . "&offset=" . $offset,
            //option 2 :
            CURLOPT_URL => "https://api.api-ninjas.com/v1/exercises?muscle=" . $muscle . "&offset=" . $offset,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            //option 1 :
            // CURLOPT_HTTPHEADER => [
            //     "X-RapidAPI-Host: exercises-by-api-ninjas.p.rapidapi.com",
		    //     "X-RapidAPI-Key: 7e072d9e51mshd2d764fe7eddea6p1776b5jsna4133f3db280"
            // ],
            //option 2 :
            CURLOPT_HTTPHEADER => [
		        "X-Api-Key: FshIaeDVuL9/eTpYn9eNkA==spmv4QBeydduZEUb"
            ],
        ]);
 
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            log_message('error', "cURL Error #:" . $err);
        } else {

            $response = json_decode($response, true);
            
            foreach ($response as $exercise) {
                log_message('debug', json_encode($exercise));
                $exercise_name = $exercise['name'];
                echo $exercise_name;
                log_message('debug', "processing exercise: " . $exercise_name);
                $workoutExists = $workoutModel->workoutExistsInDb($exercise_name);
                log_message('debug', 'workoutExists results in controller: ' . $workoutExists);   
                
                if (!$workoutExists) {
                    log_message('debug', 'adding exercise to the db: ' . $exercise_name . "\n");
                    $addExerciseToDb = $workoutModel->addExerciseToDb($exercise);
                    
                } else {
                    log_message('debug', 'exercise already in the db: ' . $exercise_name . "\n");
                }
                
            }
        }
    }
}
