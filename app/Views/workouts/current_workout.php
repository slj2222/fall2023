
<!-- <div> <?php echo 'CURRENT WORKOUT ID' . json_encode($workoutId)?></div> -->
<!-- <div> <?php echo 'CURRENT WORKOUT DETAILS' . json_encode($currentWorkoutDetails)?></div> -->
<!-- <div> <?php echo 'LIST OF EXERCISES' . json_encode($listOfExercises)?></div> -->

<script>

</script>

<div style="width: 80vw; height: 40vh; background-color: #f7f7f7; display: flex; flex-direction: row; justify-content: center;">
    <div style="width: 50%">
        <?php foreach ($currentWorkoutDetails as $exercise => $exerciseSets) { ?>
            <span>
                <div style="width: 100%">
                    <h3> <?php echo $exercise . ": " ?>
                        <div style="display: flex; flex-direction: column; width: 25%; align-items: flex-end;">
                            <?php foreach($exerciseSets as $es) {?>
                        
                            
                                <h4>
                                    <?php echo $es['reps'] . " x " . $es['weight'] ?>
                                </h4>
                        
                    
                            <?php } ?>
                        </div>
                    </h3>
                </div>
            </span>
        <?php } ?>
    </div>
    <form action="<?php echo base_url('workouts/submitWorkoutExercise')?>" method="post" accept-charset="utf-8" style="width: 50%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <!-- <label for="exercise_name">add an exercise</label>
        <input type="text" name="exercise_name"> -->
        <div style="display: flex; flex-direction: column; width: 85%;">
            <input type="hidden" name="workout_id" value="<?php echo $workoutId?>">
            <select name="exercise_name">
                <?php foreach($listOfExercises as $loe) { ?>
                    <option><?php echo $loe?></option> 
                <?php }?>
            </select>
            <input type="integer" name="reps" placeholder="# of reps">
            <input type="integer" name="weight" placeholder="weight">
            <input type="submit">
        </div>
    </form>
        <!-- <?php if ($currentWorkoutDetails) { ?>
            <form action="<?php echo base_url('workouts/submitWorkoutSet')?>" method="post" accept-charset="utf-8">
                <label for="add-exercise">add an exercise</label>
                <input type="text" name="add-set">
            </form> 
        <?php } ?> -->
</div>