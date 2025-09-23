<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest Assured</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        /* Base Container for Better Responsive Control */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Fluid Images */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Responsive Typography */
        html {
            font-size: 16px;
        }

        @media (max-width: 480px) {
            html {
                font-size: 14px;
            }
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: rgb(255, 242, 225);
            color: #3E2A1E;
        }

        header {
            display: flex;  
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: rgb(255, 242, 225);
            border-bottom: 2px solid #c2bfbb;
            flex-wrap: wrap;
            position: relative;
        }

        header .logo img {
            height: 80px;
            max-width: 100px;
        }

        nav {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        nav a {
            text-decoration: none;
            color: #664832;
            font-size: 15px;
            font-family: 'Montserrat', sans-serif;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 5px;
            white-space: nowrap;
        }

        nav a:hover {
            text-decoration: underline;
            color: #3E2A1E;
            font-weight: bold;
        }

        /* Mobile Menu Toggle Button */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 10px;
            background: none;
            border: none;
            z-index: 1001;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background-color: #664832;
            margin: 3px 0;
            transition: 0.3s;
            transform-origin: center;
        }

        /* Mobile Navigation Overlay */
        .mobile-nav-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(102, 72, 50, 0.95);
            backdrop-filter: blur(5px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .mobile-nav-overlay.active {
            display: flex;
        }

        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 30px;
            text-align: center;
        }

        .mobile-nav a {
            color: white;
            font-size: 24px;
            font-family: 'Montserrat', sans-serif;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .mobile-nav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        /* Hamburger Animation */
        .menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgb(255, 242, 225);
            min-height: 600px;
            padding: 50px;
            flex-wrap: wrap;
        }

        .hero .text {
            flex: 1;
            max-width: 600px;
            text-align: center;
        }

        .hero .dove-image {
            height: 80px;
            margin-left: 280px;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: clamp(40px, 8vw, 80px);
            margin-bottom: 10px;
            color: #664832;
            font-family: "Cormorant Garamond", serif;
            line-height: 1.2;
            margin-left: 240px;
            margin-top: -15px;
        }

        .hero h2 {
            font-size: clamp(25px, 5vw, 50px);
            margin-bottom: 30px;
            font-family: "Cormorant Garamond", serif;
            color: #664832;
            font-style: italic;
            font-weight: 400;
            margin-top: -15px;
            margin-right: -330px;
        }

        .vertical-line {
            border-left: 3px solid #664832;
            height: 80px;
            margin: 30px 435px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            font-family: "Titillium Web", sans-serif;
            color: #664832;
            line-height: 1.6;
            margin-right: -325px;
        }

        .hero .hero-image {
            flex: 1;
            text-align: center;
            max-width: 500px;
        }

        .hero .hero-image img {
            max-width: 800px;
            height: 900px;
            margin-left: -250px;
            max-height: 700px;
            object-fit: cover;
            margin-top: -51px;
            margin-bottom: -55px;
        }

        .section {
            padding: 80px 20px;
            text-align: center;
            background-color: #664832;
        }

        .section h1 {
            font-size: 24px;
            font-family: "Montserrat", sans-serif;
            color: #FFFFFF;
            font-weight: 300;
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: clamp(60px, 12vw, 120px);
            font-family: "Cormorant Garamond", serif;
            margin-bottom: 30px;
            color: #FFFFFF;
        }

        .section p {
            font-size: 20px;
            margin-bottom: 40px;
            color: white;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            font-family: "Montserrat", sans-serif;
            line-height: 1.6;
            font-weight: 300;
        }

        .section button {
            padding: 15px 30px;
            background-color: #fef3e5;
            color: #664832;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 20px;
            font-family: "Montserrat", sans-serif;
            transition: all 0.3s ease;
        }

        .section button:hover {
            background-color: rgb(255, 255, 255);
            color: #664832;
            transform: translateY(-2px);
        }

        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgb(255, 242, 225);
            padding: 60px 20px;
            position: relative;
        }

        .form .map-image {
            max-width: 100%;
            width: 600px;
            height: auto;
            margin-bottom: 40px;
            border-radius: 10px;
        }

        .form h2 {
            font-family: "Cormorant Garamond", serif;
            color: #664832;
            font-size: 40px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form p {
            font-family: "Cormorant Garamond", serif;
            color: #664832;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .form form {
            width: 100%;
            max-width: 600px;
        }

        .form-group {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .form-group input,
        .form-group select {
            flex: 1;
            min-width: 150px;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: rgb(255, 242, 225);
            color: #3E2A1E;
            font-family: 'Montserrat', sans-serif;
        }

        .form-group input::placeholder {
            color: #9E8B7E;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #664832;
            background-color: #fef3e5;
            outline: none;
            box-shadow: 0 0 5px rgba(102, 72, 50, 0.3);
        }

        .form button {
            width: 100%;
            padding: 15px 20px;
            background-color: #664832;
            color: #FFFFFF;
            border: none;
            font-family: "Montserrat", sans-serif;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .form button:hover {
            background-color: #8B5E3C;
            transform: translateY(-2px);
        }

        .sign-up-section {
            padding: 80px 20px;
            background-color: rgb(255, 242, 225);
            text-align: center;
            position: relative;
        }

        .horizontal-line {
            border-top: 2px solid #c2bfbb;
            width: 80%;
            margin: 0 auto 10px auto;
        }

        .sign-up-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
            gap: 30px;
        }

        .sign-up-section h2 {
            font-size: clamp(40px, 8vw, 60px);
            font-family: "Cormorant Garamond", serif;
            color: #664832;
            margin: 0;
            line-height: 1.2;
        }

        .sign-up-section p {
            font-size: 18px;
            font-family: "Montserrat", sans-serif;
            color: #664832;
            margin: 0;
            max-width: 300px;
        }

        .sign-up-button {
            padding: 20px 40px;
            background-color: rgb(255, 242, 225);
            color: #664832;
            border: 3px solid #8B5E3C;
            font-family: "Montserrat", sans-serif;
            cursor: pointer;
            font-size: 16px;
            border-radius: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .sign-up-button:hover {
            background-color: #8B5E3C;
            color: white;
            transform: translateY(-2px);
        }

        footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: rgb(255, 242, 225);
        border-top: 2px solid #c2bfbb;
        font-family: "Montserrat", sans-serif;
        flex-wrap: wrap;
        gap: 20px;
    }

    footer .logo img {
        height: 80px;
        max-width: 100%;
    }

    footer p {
        margin: 0;
        font-size: 14px;
    }

    footer a {
        color: #664832;
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }

        /* Enhanced Responsive Design */
        
        /* Large Desktop */
        @media (min-width: 1200px) {
            .container {
                max-width: 1200px;
                margin: 0 auto;
            }
        }

        /* Tablet Landscape */
        @media (max-width: 1024px) {
            header {
                padding: 15px 30px;
            }

            .hero {
                padding: 40px 30px;
                min-height: 500px;
            }

            .hero h1 {
                font-size: clamp(35px, 7vw, 65px);
            }

            .hero h2 {
                font-size: clamp(22px, 4.5vw, 40px);
            }

            .section {
                padding: 60px 30px;
            }

            .section h2 {
                font-size: clamp(50px, 10vw, 100px);
            }

            .form {
                padding: 50px 30px;
            }

            .sign-up-section {
                padding: 60px 30px;
            }

            footer {
                padding: 25px 30px;
            }
        }

        /* Tablet Portrait - Show hamburger menu */
        @media (max-width: 768px) {
            header {
                flex-direction: row;
                justify-content: space-between;
                padding: 20px;
            }

            header .logo img {
                height: 60px;
            }

            /* Hide desktop navigation */
            nav {
                display: none;
            }

            /* Show mobile menu toggle */
            .menu-toggle {
                display: flex;
            }

            .hero {
                flex-direction: column;
                padding: 30px 20px;
                min-height: auto;
                gap: 30px;
            }

            .hero .text {
                order: 2;
            }

            .hero .hero-image {
                order: 1;
                max-width: 100%;
            }

            .hero h1 {
                font-size: clamp(30px, 8vw, 50px);
                margin-bottom: 15px;
                margin-left: 0;
            }

            .hero h2 {
                font-size: clamp(20px, 5vw, 35px);
                margin-bottom: 25px;
                margin-right: 0;
            }

            .hero p {
                font-size: 16px;
                margin-bottom: 25px;
                margin-right: 0;
            }

            .hero .dove-image {
                height: 60px;
                margin-left: 0;
            }

            .vertical-line {
                height: 60px;
                margin: 20px auto;
            }

            .hero .hero-image img {
                margin-left: 0;
                height: auto;
                max-height: 400px;
                margin-top: 0;
                margin-bottom: 0;
            }

            .section {
                padding: 50px 20px;
            }

            .section h1 {
                font-size: 20px;
            }

            .section h2 {
                font-size: clamp(40px, 10vw, 80px);
                margin-bottom: 25px;
            }

            .section p {
                font-size: 18px;
                line-height: 1.5;
            }

            .section button {
                font-size: 18px;
                padding: 12px 25px;
            }

            .form {
                padding: 40px 20px;
            }

            .form .map-image {
                width: 100%;
                max-width: 400px;
            }

            .form h2 {
                font-size: 32px;
                margin-bottom: 15px;
            }

            .form-group {
                flex-direction: column;
                gap: 12px;
            }

            .form-group input,
            .form-group select {
                min-width: 100%;
                padding: 14px;
                font-size: 16px;
            }

            .sign-up-section {
                padding: 50px 20px;
            }

            .sign-up-content {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }

            .sign-up-section h2 {
                font-size: clamp(35px, 8vw, 50px);
            }

            .sign-up-section p {
                font-size: 16px;
                max-width: 100%;
            }

            .sign-up-button {
                padding: 18px 35px;
                font-size: 16px;
            }

            footer {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                padding: 25px 20px;
            }

            .footer-right {
                flex-direction: column;
                gap: 10px;
            }

            footer .logo img {
                height: 50px;
            }
        }

        /* Mobile Large */
        @media (max-width: 480px) {
            header {
                padding: 15px;
            }

            .mobile-nav a {
                font-size: 20px;
                padding: 12px 25px;
            }

            .hero {
                padding: 25px 15px;
                gap: 25px;
            }

            .hero .dove-image {
                height: 50px;
            }

            .hero h1 {
                font-size: clamp(28px, 9vw, 45px);
                line-height: 1.1;
            }

            .hero h2 {
                font-size: clamp(18px, 6vw, 30px);
                margin-bottom: 20px;
            }

            .hero p {
                font-size: 15px;
                line-height: 1.5;
            }

            .vertical-line {
                height: 50px;
                margin: 15px auto;
            }

            .section {
                padding: 40px 15px;
            }

            .section h1 {
                font-size: 18px;
                margin-bottom: 15px;
            }

            .section h2 {
                font-size: clamp(35px, 12vw, 70px);
                margin-bottom: 20px;
            }

            .section p {
                font-size: 16px;
                margin-bottom: 30px;
            }

            .section button {
                font-size: 16px;
                padding: 10px 20px;
                width: 100%;
                max-width: 200px;
            }

            .form {
                padding: 30px 15px;
            }

            .form .map-image {
                max-width: 100%;
                height: 200px;
            }

            .form h2 {
                font-size: 28px;
            }

            .form p {
                font-size: 16px;
            }

            .form-group input,
            .form-group select {
                padding: 12px;
                font-size: 15px;
            }

            .form button {
                padding: 14px;
                font-size: 16px;
            }

            .sign-up-section {
                padding: 40px 15px;
            }

            .sign-up-content {
                gap: 20px;
            }

            .sign-up-section h2 {
                font-size: clamp(30px, 10vw, 45px);
                line-height: 1.1;
            }

            .sign-up-section p {
                font-size: 15px;
            }

            .sign-up-button {
                padding: 16px 30px;
                font-size: 15px;
                width: 100%;
                max-width: 200px;
            }

            .horizontal-line {
                width: 90%;
            }

            footer {
                padding: 20px 15px;
                gap: 12px;
            }

            footer .logo img {
                height: 50px;
            }

            .footer-contact p {
                font-size: 14px;
            }
        }

        /* Mobile Small */
        @media (max-width: 320px) {
            .hero h1 {
                font-size: 32px;
            }

            .hero h2 {
                font-size: 22px;
            }

            .section h2 {
                font-size: 45px;
            }

            .form h2 {
                font-size: 24px;
            }

            .sign-up-section h2 {
                font-size: 32px;
            }

            .mobile-nav a {
                font-size: 18px;
                padding: 10px 20px;
            }
        }

        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            nav a,
            .section button,
            .form button,
            .sign-up-button,
            .mobile-nav a {
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .form-group input,
            .form-group select {
                min-height: 44px;
            }
        }

        /* Landscape Orientation for Mobile */
        @media (max-width: 768px) and (orientation: landscape) {
            .hero {
                flex-direction: row;
                min-height: 400px;
            }

            .hero .text {
                order: 1;
                flex: 1;
            }

            .hero .hero-image {
                order: 2;
                flex: 1;
                max-width: 50%;
            }

            .hero h1 {
                font-size: clamp(25px, 6vw, 40px);
            }

            .hero h2 {
                font-size: clamp(18px, 4vw, 28px);
            }
        }

        /* Placeholder for images that don't exist */
        .placeholder-image {
            background-color: #e0e0e0;
            border: 2px dashed #999;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-family: 'Montserrat', sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="RA_logo.png" alt="Rest Assured Logo"> 
        </div>
        <nav>
            <a href="new_main.php">HOME</a>
            <a href="new_memorial.php">MEMORIAL</a>
            <a href="new_cemeteries.php">CEMETERIES</a>
            <a href="new_aboutus.php">ABOUT US</a>
            <a href="new_contact.php">CONTACT US</a>
            <a href="#signin">SIGN IN</a>
            <a href="#signup">SIGN UP</a>
        </nav>
        <button class="menu-toggle" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay">
        <div class="mobile-nav">
            <a href="new_main.php" onclick="closeMobileMenu()">HOME</a>
            <a href="new_memorial.php" onclick="closeMobileMenu()">MEMORIAL</a>
            <a href="new_cemeteries" onclick="closeMobileMenu()">CEMETERIES</a>
            <a href="new_aboutus.php" onclick="closeMobileMenu()">ABOUT US</a>
            <a href="new_contact.php" onclick="closeMobileMenu()">CONTACT US</a>
            <a href="#signin" onclick="closeMobileMenu()">SIGN IN</a>
            <a href="#signup" onclick="closeMobileMenu()">SIGN UP</a>
        </div>
    </div>

    <section class="hero">
        <div class="text">
            <img src="dove.png" alt="Dove" class="dove-image" >
            <h1>HONORING</h1>
            <h2>memories, preserving peace.</h2>
            <div class="vertical-line"></div>
            <p>Rest Assured, your trusted partner in cemetery management.</p>
        </div>
        <div class="hero-image">
            <img src="candles.jpeg" alt="Candles">
        </div>
    </section>

    <div class="section">
        <h1>HONORING MEMORIES, PRESERVING PEACE</h1>
        <h2>Rest Assured</h2>
        <p>Rest Assured is your trusted partner in managing cemetery records efficiently. From locating graves to tracking payments and requesting services, the system ensures a seamless experience for both administrators and customers. Designed with care and precision, it simplifies cemetery management while honoring the memories of your loved ones.</p>
        <button onclick="location.href='#signup'">I'M READY</button>
    </div>

    <section class="form">
        <img src="map2.png" alt="Map" class="map-image">
        <h2>Locate your loved one here</h2>
        <p>Name*</p>
        <form>
            <div class="form-group">
                <input type="text" name="first_name" placeholder="FIRST NAME" required>
                <input type="text" name="last_name" placeholder="LAST NAME" required>
                <input type="text" name="middle_initial" placeholder="M.I.">
            </div>
            <div class="form-group">
                <select name="year_born">
                    <option value="">Year Born</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <!-- Add more years as needed -->
                </select>
                <select name="year_died">
                    <option value="">Year Died</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <!-- Add more years as needed -->
                </select>
                <input type="text" name="cemetery_location" placeholder="Cemetery Location">
            </div>
            <button type="submit">Locate Grave</button>
        </form>
    </section>

    <section class="sign-up-section">
        <div class="horizontal-line"></div>
        <div class="sign-up-content">
            <h2>New<br>here?</h2>
            <p>Sign up to access all features and manage your records effortlessly.</p>
            <a href="#signup" class="sign-up-button">Sign Up</a>
        </div>
        <div class="horizontal-line"></div>
    </section>

    <footer>
    <div class="logo">
        <img src="RA_logo.png" alt="Rest Assured Logo">
    </div>
    <p>
        <span>For assistance:</span> 
        <a href="mailto:r.assured@gmail.com">r.assured@gmail.com</a>
    </p>
    <p>09123456273</p>
    <p>&copy; 2024 Rest Assured. All Rights Reserved.</p>
</footer>

<script>
function toggleMobileMenu() {
    const overlay = document.getElementById('mobileNavOverlay');
    const menuToggle = document.querySelector('.menu-toggle');
    
    overlay.classList.toggle('active');
    menuToggle.classList.toggle('active');
    
    // Prevent body scrolling when menu is open
    if (overlay.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

function closeMobileMenu() {
    const overlay = document.getElementById('mobileNavOverlay');
    const menuToggle = document.querySelector('.menu-toggle');
    
    overlay.classList.remove('active');
    menuToggle.classList.remove('active');
    document.body.style.overflow = '';
}

// Close menu when clicking outside of it
document.getElementById('mobileNavOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMobileMenu();
    }
});

// Close menu on window resize if screen becomes larger
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        closeMobileMenu();
    }
});
</script>
</body>
</html>