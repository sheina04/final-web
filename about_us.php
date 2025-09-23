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
    <link rel="icon" type="image/x-icon" href="icon.png">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: rgb(255, 242, 225);
            color: #3E2A1E;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: rgb(255, 242, 225);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(24px, 4vw, 32px);
            font-weight: 600;
            color: #664832;
            text-decoration: none;
        }

        .logo::before {
            content: "RA";
            margin-right: 10px;
        }

        nav {
            display: flex;
            gap: clamp(15px, 3vw, 30px);
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: #664832;
            font-size: clamp(12px, 2vw, 14px);
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        nav a:hover,
        nav a.active {
            background-color: rgba(102, 72, 50, 0.1);
            color: #3E2A1E;
            font-weight: 600;
        }

        nav a.active {
            border-bottom: 2px solid #664832;
        }

        /* Mobile menu toggle */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background-color: #664832;
            transition: 0.3s;
        }

        /* Main Content */
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: clamp(40px, 8vw, 120px) clamp(20px, 5vw, 60px);
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .about-content {
            text-align: center;
            max-width: 1200px;
            width: 100%;
        }

        .about-content h1 {
            font-size: clamp(48px, 10vw, 100px);
            margin-bottom: clamp(30px, 6vw, 60px);
            color: #6d4b3d;
            font-family: "Cormorant Garamond", serif;
            font-weight: 600;
            line-height: 1.2;
        }

        .about-content p {
            font-size: clamp(16px, 2.5vw, 20px);
            line-height: 2.2;
            color: #6d4b3d;
            font-family: "Montserrat", sans-serif;
            margin-bottom: clamp(25px, 4vw, 40px);
            text-align: justify;
            text-justify: inter-word;
        }

        .about-content p:last-child {
            margin-bottom: 0;
        }

        /* Footer */
        footer {
            background-color: rgb(255, 242, 225);
            padding: clamp(20px, 4vw, 40px);
            margin-top: auto;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            gap: clamp(20px, 4vw, 40px);
            align-items: center;
        }

        .footer-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(20px, 3vw, 28px);
            font-weight: 600;
            color: #664832;
        }

        .footer-logo::before {
            content: "RA";
        }

        .footer-info {
            font-size: clamp(12px, 2vw, 14px);
            color: #664832;
        }

        .footer-info a {
            color: #664832;
            text-decoration: none;
        }

        .footer-info a:hover {
            text-decoration: underline;
        }

        .footer-copyright {
            font-size: clamp(11px, 1.8vw, 13px);
            color: #8B6F4D;
            text-align: right;
        }

        /* Tablet Styles */
        @media (max-width: 1024px) {
            main {
                padding: clamp(30px, 6vw, 80px) clamp(20px, 4vw, 40px);
            }

            .about-content p {
                text-align: center;
                line-height: 2;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 20px;
            }

            .footer-copyright {
                text-align: center;
            }
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
            }

            nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: rgb(255, 242, 225);
                flex-direction: column;
                padding: 20px;
                gap: 15px;
                box-shadow: 0 4px 15px rgba(102, 72, 50, 0.1);
            }

            nav.active {
                display: flex;
            }

            .menu-toggle {
                display: flex;
            }

            .menu-toggle.active span:nth-child(1) {
                transform: rotate(-45deg) translate(-5px, 6px);
            }

            .menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }

            .menu-toggle.active span:nth-child(3) {
                transform: rotate(45deg) translate(-5px, -6px);
            }

            nav a {
                padding: 12px 20px;
                text-align: center;
                border-radius: 10px;
            }

            main {
                padding: clamp(20px, 5vw, 60px) clamp(15px, 4vw, 30px);
            }

            .about-content h1 {
                margin-bottom: clamp(20px, 4vw, 40px);
            }

            .about-content p {
                font-size: clamp(14px, 3vw, 18px);
                line-height: 1.8;
                margin-bottom: clamp(20px, 4vw, 30px);
                text-align: left;
            }
        }

        /* Small Mobile Styles */
        @media (max-width: 480px) {
            header {
                padding: 12px 15px;
            }

            main {
                padding: 20px 15px;
            }

            .about-content p {
                font-size: 14px;
                line-height: 1.7;
                margin-bottom: 20px;
            }
        }

        /* Very Small Mobile */
        @media (max-width: 320px) {
            .about-content h1 {
                font-size: 36px;
            }

            .about-content p {
                font-size: 13px;
                line-height: 1.6;
            }
        }

        /* Enhanced animations and interactions */
        .about-content {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .about-content p {
            transition: color 0.3s ease;
        }

        .about-content p:hover {
            color: #664832;
        }

        /* Focus states for accessibility */
        nav a:focus,
        .footer-info a:focus {
            outline: 2px solid #664832;
            outline-offset: 2px;
        }

        /* Print styles */
        @media print {
            header, footer {
                display: none;
            }
            
            main {
                padding: 20px;
            }
            
            .about-content h1 {
                font-size: 36px;
                margin-bottom: 20px;
            }
            
            .about-content p {
                font-size: 14px;
                line-height: 1.6;
                color: #000;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="new_main.php" class="logo"></a>
        <div class="menu-toggle" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav id="nav-menu">
            <a href="main.php">HOME</a>
            <a href="memorial.php">MEMORIAL</a>
            <a href="cemeteries.php">CEMETERIES</a>
            <a href="about_us.php" class="active">ABOUT US</a>
            <a href="contact.php">CONTACT US</a>
            <a href="signIn.php">SIGN IN</a>
            <a href="signup.php">SIGN UP</a>
        </nav>
    </header>

    <main>
        <div class="about-content">
            <h1>About Us</h1>
            <p>
                Rest Assured: The Cemetery Record System is a digital platform dedicated to simplifying cemetery management while honoring the memories of loved ones. Our system streamlines grave tracking, automates notifications, and securely stores essential records, ensuring efficiency and accuracy for both families and administrators.
            </p>
            <p>
                With features like real-time grave availability, a grave locator with map integration, and insightful analytics, we aim to provide a user-friendly and reliable experience. Rest Assured is built to bridge the gap between tradition and technology, delivering services that are both compassionate and efficient.
            </p>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-logo"></div>
            <div class="footer-info">
                <span>For assistance: </span>
                <a href="mailto:r.assured@gmail.com">r.assured@gmail.com</a>
            </div>
            <div class="footer-info">09193210292</div>
            <div class="footer-copyright">&copy; 2024 Rest Assured. All Rights Reserved.</div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMenu() {
            const nav = document.getElementById('nav-menu');
            const toggle = document.querySelector('.menu-toggle');
            nav.classList.toggle('active');
            toggle.classList.toggle('active');
        }

        // Close menu when clicking on a link (mobile)
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('nav-menu').classList.remove('active');
                document.querySelector('.menu-toggle').classList.remove('active');
            });
        });

        // Smooth scroll for better UX
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.about-content p');
            animatedElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = `opacity 0.6s ease ${index * 0.2}s, transform 0.6s ease ${index * 0.2}s`;
                observer.observe(el);
            });
        });
    </script>
</body>
</html>