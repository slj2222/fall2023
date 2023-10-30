<?php 
namespace App\Models;  
use CodeIgniter\Model;
  
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
                    we.id AS workouts_exercisess_id,
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
                    w.id = ' . $workoutId . ';'
            );

            $results = $query->getResultArray();
            if ($results) {
                return $results;
            } else {
                return false;
            }
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
}

