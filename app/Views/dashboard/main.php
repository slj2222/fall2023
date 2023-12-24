<!-- <h2>main content / dashboard </h2> -->

<script type="text/javascript">
        //jquery for plan a workout button
        $(document).ready(function(){
            //toggle sub-menus
            $(".sub-btn").click(function(){
                $(this).next(".sub-menu").slideToggle();
            })

            //toggle more-menus
            $(".more-btn").click(function(){
                $(this).next(".more-menu").slideToggle();
            })
        });

        //javascript for the responsive navigation menu
        let actionBtn = document.getElementById("action-btn");

        // actionBtn.addEventListener("click", () => {
        //     menu.classList.add("active");
        // })
 
    </script>

    <button class="action-btn" onclick="window.location='<?= base_url();?>workouts/create'">
       <a style="text-decoration:none">Plan Workout</a>
    </button>
    <button class="action-btn" onclick="window.location='<?= base_url();?>workouts/continue'">
       <a style="text-decoration:none">Continue Workout</a>
    </button>
    <button class="action-btn" onclick="window.location='<?= base_url();?>workouts/history'">
       <a style="text-decoration:none">Workout History</a>
    </button>