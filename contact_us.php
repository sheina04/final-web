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
    }

    /* Header Styles */
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

    /* Main Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .container h1 {
        font-size: clamp(36px, 5vw, 60px);
        text-align: center;
        margin-bottom: 20px;
        color: #6d4b3d;
        font-family: "Cormorant Garamond", serif;
    }

    .container > p {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 60px auto;
        font-size: 16px;
        line-height: 1.6;
    }

    /* Form Section */
    .form-section {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 40px;
        align-items: start;
        margin-bottom: 80px;
    }

    .form-container {
        width: 100%;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #6d4b3d;
        font-weight: 500;
    }

    .form-group input, 
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #5c3b28;
        border-radius: 10px;
        background-color: rgb(255, 242, 225);
        font-family: "Montserrat", sans-serif;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3E2A1E;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-container button {
        background-color: #6d4b3d;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-family: "Montserrat", sans-serif;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .form-container button:hover {
        background-color: #333;
    }

    /* Divider */
    .divider {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
    }

    .vertical-line {
        width: 3px;
        height: 100px;
        background-color: #c2bfbb;
        margin-bottom: 20px;
    }

    .divider p {
        font-size: 16px;
        color: #664832;
        margin: 0;
    }

    .vertical-line-bottom {
        width: 3px;
        height: 100px;
        background-color: #c2bfbb;
        margin-top: 20px;
    }

    /* Contact Info */
    .contact-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 15px;
        border: 2px solid #5c3b28;
        border-radius: 30px;
        padding: 15px 20px;
        background-color: rgb(255, 242, 225);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .contact-item:hover {
        transform: translateY(-2px);
    }

    .contact-item img {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
    }

    .contact-item span {
        font-size: 16px;
        color: #3E2A1E;
    }

    /* Sign Up Section */
    .sign-up-section {
        border-top: 3px solid #c2bfbb;
        padding: 60px 0;
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 40px;
        align-items: center;
    }

    .sign-up-section h2 {
        font-size: clamp(36px, 5vw, 60px);
        font-family: "Cormorant Garamond", serif;
        color: #664832;
        line-height: 1.2;
    }

    .sign-up-section p {
        font-size: 18px;
        color: #3E2A1E;
        margin: 0;
    }

    .sign-up-button {
        padding: 15px 30px;
        background-color: rgb(255, 242, 225);
        color: #664832;
        border: 3px solid #8B5E3C;
        border-radius: 20px;
        font-family: "Montserrat", sans-serif;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        justify-self: center;
    }

    .sign-up-button:hover {
        background-color: #8B5E3C;
        color: white;
    }

    /* Footer */
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

    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .container {
            padding: 30px 20px;
        }

        .form-section {
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
        }

        .divider {
            flex-direction: row;
            padding: 20px 0;
        }

        .vertical-line,
        .vertical-line-bottom {
            width: 100px;
            height: 3px;
        }

        .vertical-line {
            margin-bottom: 0;
            margin-right: 20px;
        }

        .vertical-line-bottom {
            margin-top: 0;
            margin-left: 20px;
        }

        .sign-up-section {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 20px;
        }
    }

    /* Mobile Styles - Show hamburger menu */
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

        .container {
            padding: 20px 15px;
        }

        .container > p {
            font-size: 15px;
        }

        .form-group input,
        .form-group textarea {
            padding: 10px;
        }

        .contact-item {
            padding: 12px 15px;
        }

        .contact-item span {
            font-size: 14px;
        }

        .sign-up-section {
            padding: 40px 0;
        }

        .sign-up-section p {
            font-size: 16px;
        }

        footer {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
    }

    /* Small Mobile Styles */
    @media (max-width: 480px) {
        header {
            padding: 15px;
        }

        .mobile-nav a {
            font-size: 20px;
            padding: 12px 25px;
        }

        .container {
            padding: 15px 10px;
        }

        .form-section {
            gap: 30px;
        }

        .contact-item {
            flex-direction: column;
            text-align: center;
            gap: 10px;
            padding: 15px;
        }

        .sign-up-button {
            width: 100%;
            max-width: 200px;
        }
    }

    /* Touch Device Optimizations */
    @media (hover: none) and (pointer: coarse) {
        .form-container button,
        .sign-up-button,
        .mobile-nav a {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group input,
        .form-group textarea {
            min-height: 44px;
        }
    }
</style>
</head>
<body>
<header>
    <div class="logo">
        <a href="index.php">
            <img src="RA_logo.png" alt="Rest Assured Logo">    
        </a>
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
        <a href="new_cemeteries.php" onclick="closeMobileMenu()">CEMETERIES</a>
        <a href="new_aboutus.php" onclick="closeMobileMenu()">ABOUT US</a>
        <a href="new_contact.php" onclick="closeMobileMenu()">CONTACT US</a>
        <a href="signIn.php" onclick="closeMobileMenu()">SIGN IN</a>
        <a href="signup.php" onclick="closeMobileMenu()">SIGN UP</a>
    </div>
</div>

<div class="container">
    <h1>Contact us at Rest Assured</h1>
    <p>
        We're here to assist you with any questions or concerns about our cemetery record system. No request is too big or small—reach out, and we'll be happy to help.
    </p>

    <div class="form-section">
        <div class="form-container">
            <form>
                <div class="form-group">
                    <label for="name">Name <span>(required)</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span>(required)</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message <span>(required)</span></label>
                    <textarea id="message" name="message" placeholder="Message" required></textarea>
                </div>
                <button type="submit">Send</button>
            </form>
        </div>

        <div class="divider">
            <div class="vertical-line"></div>
            <p>or</p>
            <div class="vertical-line-bottom"></div>
        </div>

        <div class="contact-container">
            <div class="contact-item">
                <img src="email-icon.png" alt="Email Icon">
                <span>Email us: r.assured@gmail.com</span>
            </div>
            <div class="contact-item">
                <img src="phone-icon.png" alt="Phone Icon">
                <span>Phone no.: 09193210292</span>
            </div>
            <div class="contact-item">
                <img src="telephone-icon.png" alt="Telephone Icon">
                <span>Telephone no.: 463 5289</span>
            </div>
        </div>
    </div>

    <section class="sign-up-section">
        <h2>New<br>here?</h2>
        <p>Sign up to access all features and manage your records effortlessly.</p>
        <a href="signup.php" class="sign-up-button">Sign Up</a>
    </section>
</div>

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