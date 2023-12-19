
<div> <?php echo 'CURRENT WORKOUT ID' . json_encode($workoutId)?></div>
<div> <?php echo 'CURRENT WORKOUT DETAILS' . json_encode($currentWorkoutDetails)?></div>
<div> <?php echo 'LIST OF EXERCISES' . json_encode($listOfExercises)?></div>


<div style="width: 600px; height: 600px; background-color: #f7f7f7">
    
        <form action="<?php echo base_url('workouts/submitWorkoutExercise')?>" method="post" accept-charset="utf-8">
        <!-- <label for="exercise_name">add an exercise</label>
            <input type="text" name="exercise_name"> -->
            <input type="hidden" name="workout_id" value="<?php echo $workoutId?>">
            <select name="exercise_name">
                <?php foreach($listOfExercises as $loe) { ?>
                    <option><?php echo $loe?></option> 
                <?php }?>
            </select>
            <input type="integer" name="reps" placeholder="# of reps">
            <input type="integer" name="weight" placeholder="weight">
            <input type="submit">

        </form>
        <?php if ($currentWorkoutDetails) { ?>
            <form action="<?php echo base_url('workouts/submitWorkoutSet')?>" method="post" accept-charset="utf-8">
                <label for="add-exercise">add an exercise</label>
                <input type="text" name="add-set">
            </form> 
        <?php } ?>
</div>