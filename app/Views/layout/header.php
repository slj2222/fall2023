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
                <li class="menu-item"><a href="#">Home</a></li>
                <li class="menu-item"><a href="#">Dropdown <i class="fas fa-angle-down"></i></a></li>
                <li class="menu-item"><a href="#">With Sub-dropdown <i class="fas fa-angle-down"></i></a></li>
                <li class="menu-item"><a href="#">Services</a></li>
                <li class="menu-item"><a href="#">About</a></li>
                <li class="menu-item"><a href="#">Contact</a></li>
            </ul>
        </div>
    </header>
    
<!-- </body>
</html> -->