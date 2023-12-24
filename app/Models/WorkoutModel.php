<?php 
namespace App\Models;  
use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

  
class WorkoutModel extends Model{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        

    }

    public function createWorkout($workoutData)
    {
        if ($workoutData) {
            $builder = $this->db->table('workouts');
            $builder->insert($workoutData);
        }
    }

    public function createNewWorkout($workoutData)
    {
        if ($workoutData) {
            $userId = $workoutData['user_id'];
            $workoutExists = $this->workoutExists($userId);
            echo "\n\n WORKOUTEXISTS: " . json_encode($workoutExists);
    
            if (!$workoutExists) {
                $query = $this->db->query(
                    'INSERT INTO workouts
                        (user_id) 
                    VALUES 
                        (' . $userId . ');'
                );
                return true;
            } else {
                return false;
            } 
        } else {
            return false;
        }  
    }

    public function completeWorkout($workoutData)
    {   
        if ($workoutData) {
            $userId = $workoutData['user_id'];
            $workoutId = $workoutData['id'];
            $workoutEndDate = date('Y-m-d H:i:s');
            $query = $this->db->query(
                'UPDATE workouts
                SET 
                    completed = 1, 
                    workout_end_date = ' . $workoutEndDate . '
                WHERE 
                    user_id = ' . $userId . '
                    AND id = ' . $workoutId . ';'
            );

            if ($query) {
                return true;
            } else {
                return false;
            }
        }
    }


    public function workoutExists($userId) 
    {
        if ($userId) {
            $query = $this->db->query(
                'SELECT 
                    id,
                    workout_start_date
                FROM workouts
                WHERE day(workout_start_date) = day(current_date())
                    AND completed = 0
                    AND user_id = ' . $userId . ';'
            );

            $results = $query->getResultArray();

            if (count($results) > 0) {
                return $results;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getCurrentWorkoutDetails($workoutId)
    {
        echo "WORKOUTID: " . $workoutId;
        if ($workoutId) {
            $query = $this->db->query(
                'SELECT 
                    w.id,
                    w.workout_start_date,
                    w.workout_end_date,
                    we.time_entered AS workouts_exercises_id_time_entered,
                    we.id AS workouts_exercises_id,
                    es.id AS exercises_sets_id,
                    e.exercise_name,
                    s.id AS set_id,
                    s.reps,
                    s.weight
                FROM workouts w
                JOIN workouts_exercises we ON we.workout_id = w.id
                JOIN exercises_sets es ON we.exercises_sets_id = es.id
                JOIN exercises e ON es.exercise_id = e.id
                JOIN sets s ON es.set_id = s.id
                WHERE 
                    w.id = ' . $workoutId . '
                ORDER BY we.time_entered asc;'
            );

            $results = $query->getResultArray();

            if ($results) {
                return $results;
            } else {
                return false;
            }
        }
    }
    
    public function addNewExercise($workoutData)
    {
        if ($workoutData) {
            $userId = $workoutData['user_id'];
            $workoutId = $workoutData['workout_id'];
            $exercise_name = $workoutData['exercise_name'];

            $exerciseAlreadyExists = $this->db->query(
                'SELECT * FROM exercises WHERE exercise_name = "' . $exercise_name . '";'
            );
            
            $exerciseAlreadyExistsResults = $exerciseAlreadyExists->getResultArray();

            if ($exerciseAlreadyExistsResults) {
                return $exerciseAlreadyExistsResults[0]['id'];
            } else {
                $query = $this->db->query(
                    'INSERT INTO exercises
                        (exercise_name) 
                    VALUES 
                        ("' . $exercise_name . '");'
                );
    
                $select = $this->db->query(
                    'SELECT * FROM exercises WHERE exercise_name = "' . $exercise_name . '";'
                );
                
                $results = $select->getResultArray();
    
                if ($results) {
                    echo json_encode($results);
                    return $results[0]['id'];
                } else {
                    return false;
                }            
            }
        } else {
            return false;
        }  
    }

    public function addNewSet($workoutData)
    {
        if ($workoutData) {
            // $userId = $workoutData['user_id'];
            $exercise_reps = $workoutData['exercise_reps'];
            $exercise_weight = $workoutData['exercise_weight'];

            //reps
            //weight

            $query = $this->db->query(
                'INSERT INTO sets
                    (reps, weight) 
                VALUES 
                    (' . $exercise_reps . ',' . $exercise_weight . ');'
            );

            $select = $this->db->query(
                'SELECT * FROM sets 
                WHERE reps = ' . $exercise_reps . ' 
                    AND weight = ' . $exercise_weight . ';'
            );
            
            $results = $select->getResultArray();

            if ($results) {
                return $results[0]['id'];
            } else {
                return false;
            }

            return true;
        } else {
            return false;
        }  
    }
    
    public function addNewExercisesSet($workoutData)
    {
        if ($workoutData) {
            $userId = $workoutData['user_id'];
            $workoutId = $workoutData['workout_id'];
            $exercise_name = $workoutData['exercise_name'];

            $exercise_id = $workoutData['exercise_id'];
            $set_id = $workoutData['set_id'];

            

            $query = $this->db->query(
                'INSERT INTO exercises_sets
                    (exercise_id, set_id) 
                VALUES 
                    (' . $exercise_id . ',' . $set_id . ');'
            );

            $select = $this->db->query(
                'SELECT * FROM exercises_sets 
                WHERE exercise_id = ' . $exercise_id . ' 
                    AND set_id = ' . $set_id . ';'
            );

            $results = $select->getResultArray();

            if ($results) {
                return $results[0]['id'];
            } else {
                return false;
            }



            return true;
        } else {
            return false;
        }  
    }
    
    public function addNewWorkoutsExercises($workoutData)
    {
        if ($workoutData) {
            // $userId = $workoutData['user_id'];
            log_message('debug', json_encode($workoutData));
            $exercise_set_id = $workoutData['exercise_reps'];
            $workoutId = $workoutData['workout_id'];

            try {
          
                $this->db->transException(true);
                $this->db->transStart();


                $exercise_id = $this->addNewExercise($workoutData);
                $set_id = $this->addNewSet($workoutData);
                $workoutData['exercise_id'] = $exercise_id;
                $workoutData['set_id'] = $set_id;
                $exercises_sets_id = $this->addNewExercisesSet($workoutData);

                $query = $this->db->query(
                    'INSERT INTO workouts_exercises
                        (workout_id, exercises_sets_id) 
                    VALUES 
                        (' . $workoutId . ',' . $exercises_sets_id . ');'
                );
                $this->db->transComplete();
                log_message("debug", "workoutData at the end: " . json_encode($workoutData));

                return true;
            } catch (DatabaseException $e) {
                log_message('error', 'DB EXCEPTION' . $e);
                return false;
            }
              
            
        } else {
            return false;
        }  
    }
    
    
    
    
    
    
    
    
    
    
    
    
    public function getMyWorkoutsHistory($userId)
    {
        if ($userId) {
            $query = $this->db->query(
                'SELECT 
                    u.name, 
                    w.workout_start_date,
                    w.workout_end_date 
                FROM workouts w
                JOIN users u ON w.user_id = u.id
                WHERE u.id = ' . $userId . '
                    AND w.completed = 1
                ORDER BY w.workout_start_date'
            );
            
            $results = $query->getResultArray();
            
            if ($results) {
                return $results;
            }
        }
    }









    public function workoutExistsInDb($exercise_name) {
        
        $exerciseAlreadyExists = $this->db->query(
            'SELECT * FROM exercises WHERE exercise_name = "' . addslashes($exercise_name) . '";'
        );

        log_message('debug', 'SELECT * FROM exercises WHERE exercise_name = "' . addslashes($exercise_name) . '";');

        $results = $exerciseAlreadyExists->getResultArray();

        if ($results) {
            log_message('debug', 'results from workoutExistsInDb: '. $exercise_name);
            return true;
        } else {
            log_message('error', 'not found in db: ' . $exercise_name);
            return false;
        }
    }

    public function addExerciseToDb($exerciseData)
    {
        if ($exerciseData) {
            
            $exercise_name = addslashes($exerciseData['name']);
            $exercise_type = $exerciseData['type'];
            $muscle = $exerciseData['muscle'];
            $equipment = $exerciseData['equipment'];
            $difficulty = $exerciseData['difficulty'];
            $instructions = addslashes($exerciseData['instructions']);

            $query = $this->db->query(
                'INSERT INTO exercises
                    (exercise_name, type, muscle, equipment, difficulty, instructions) 
                VALUES 
                    (   "' . $exercise_name . '", 
                        "' . $exercise_type . '",
                        "' . $muscle . '",
                        "' . $equipment . '",
                        "' . $difficulty . '",
                        "' . $instructions . '"
                    );'
            );

            $select = $this->db->query(
                'SELECT * FROM exercises WHERE exercise_name = "' . $exercise_name . '";'
            );
            
            $results = $select->getResultArray();

            if ($results) {
                echo json_encode($results);
                return true;
                // return $results[0]['id'];
            } else {
                return false;
            }            
           
        } else {
            return false;
        }  
    }
}

