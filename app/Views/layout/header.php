<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Layout</title>
    <link rel="stylesheet" href=<?= base_url("css/style.css")?>>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>
</head>
<body>
    <!-- <?= $this->renderSection('content') ?> -->
    
    <header>
        <a href="#" class="logo">logo</a>
        <div class="navigation">
            <ul class="menu">
                <div class="close-btn"></div>
                <li class="menu-item"><a href="#">Home</a></li>
                <li class="menu-item">
                    <a class="sub-btn href="#">Dropdown <i class="fas fa-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li class="sub-item"><a href="#">Sub Item 01</a></li>
                        <li class="sub-item"><a href="#">Sub Item 02</a></li>
                        <li class="sub-item"><a href="#">Sub Item 03</a></li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a class="sub-btn" href="#">With Sub-dropdown <i class="fas fa-angle-down"></i></a>
                    <ul class="sub-menu">
                        <li class="sub-item"><a href="#">Sub Item 01</a></li>
                        <li class="sub-item"><a href="#">Sub Item 02</a></li>
                        <li class="sub-item"><a href="#">Sub Item 03</a></li>
                        <li class="sub-item"><a href="#">Sub Item 04</a></li>
                        <li class="sub-item more">
                            <a class="more-btn" href="#">More Items<i class="fas fa-angle-right"></i></a>
                            <ul class="more-menu">
                                <li class="more-item"><a href="#">More Item 01</a></li>
                                <li class="more-item"><a href="#">More Item 02</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="menu-item"><a href="#">Services</a></li>
                <li class="menu-item"><a href="#">About</a></li>
                <li class="menu-item"><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="menu-btn"></div>
    </header>

    <section class="section-home">
        <!-- <h1>Dropdowns.</h1> -->
    <!-- </section> -->

    <script type="text/javascript">
        //jquery for toggle dropdown menus
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
        let menu = document.querySelector(".menu");
        let menuBtn = document.querySelector(".menu-btn");
        let closeBtn = document.querySelector(".close-btn");

        menuBtn.addEventListener("click", () => {
            menu.classList.add("active");
        })

        closeBtn.addEventListener("click", () => {
            menu.classList.remove("active");
        })


    </script>
    
<!-- </body>
</html> -->