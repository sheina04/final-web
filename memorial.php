<?php
// Include the database connection
include('db.connection.php'); // Make sure the path is correct

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle form submission for grave search
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);
    $middleInitial = htmlspecialchars($_POST['middle_initial']);
    $yearBorn = htmlspecialchars($_POST['year_born']);
    $yearDied = htmlspecialchars($_POST['year_died']);
    $cemeteryLocation = htmlspecialchars($_POST['cemetery_location']);

    try {
        // Query to search the grave based on the input fields using PDO
        $sql = "SELECT * FROM graves_locator WHERE first_name LIKE :firstName 
                AND last_name LIKE :lastName 
                AND middle_initial LIKE :middleInitial 
                AND year_born LIKE :yearBorn 
                AND year_died LIKE :yearDied 
                AND cemetery_location LIKE :cemeteryLocation";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);

        // Bind parameters to avoid SQL injection
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':middleInitial', $middleInitial, PDO::PARAM_STR);
        $stmt->bindParam(':yearBorn', $yearBorn, PDO::PARAM_STR);
        $stmt->bindParam(':yearDied', $yearDied, PDO::PARAM_STR);
        $stmt->bindParam(':cemeteryLocation', $cemeteryLocation, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Check if any results were found
        if ($stmt->rowCount() > 0) {
            $searchResult = "Grave record found:";
            // Loop through the results
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $searchResult .= "<br>Name: " . $row["first_name"] . " " . $row["middle_initial"] . " " . $row["last_name"];
                $searchResult .= " | Born: " . $row["year_born"] . " | Died: " . $row["year_died"];
                $searchResult .= " | Location: " . $row["cemetery_location"];
            }
        } else {
            // If no matches found
            $searchError = "No matches found for '$firstName $middleInitial $lastName'.";
        }
    } catch (PDOException $e) {
        $searchError = "Error: " . $e->getMessage();
    }
}

// Close the connection (optional with PDO as it's handled automatically)
$conn = null;
?>

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
        padding: 5px 20px;
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
        gap: 20px;
        flex-wrap: wrap;
    }

    nav a {
        text-decoration: none;
        color: #664832;
        font-size: 15px;
        padding: 5px 10px;
        transition: all 0.3s ease;
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

    /* Main Content */
    .content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Memorial Section */
    .memorial-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
        margin-bottom: 80px;
    }

    .form-container {
        background-color: rgb(255, 242, 225);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        font-family: "Cormorant Garamond", serif;
        color: #664832;
        font-size: clamp(32px, 4vw, 50px);
        margin-bottom: 30px;
        text-align: center;
    }

    .form-label {
        font-family: "Cormorant Garamond", serif;
        color: #664832;
        font-size: 18px;
        margin-bottom: 15px;
        display: block;
    }

    /* Form Groups */
    .form-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .form-group.name-group {
        grid-template-columns: 2fr 2fr 1fr;
    }

    .form-group input,
    .form-group select {
        padding: 12px;
        font-size: 16px;
        border: 2px solid #5c3b28;
        border-radius: 10px;
        background-color: rgb(255, 242, 225);
        color: #3E2A1E;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group input::placeholder {
        color: #9E8B7E;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #3E2A1E;
        background-color: #fef3e5;
        box-shadow: 0 0 8px rgba(102, 72, 50, 0.3);
    }

    .form-container button {
        padding: 15px 30px;
        background-color: #664832;
        color: white;
        font-family: "Montserrat", sans-serif;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        display: block;
        margin: 20px auto 0;
        min-width: 150px;
    }

    .form-container button:hover {
        background-color: #8B5E3C;
    }

    /* Results and Error Messages */
    .results, .error {
        margin-top: 25px;
        padding: 15px;
        border-radius: 8px;
        font-size: 16px;
    }

    .results {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
    }

    .error {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
    }

    /* Map Container */
    .map-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .map-container img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    /* Sign Up Section */
    .sign-up-section {
        border-top: 3px solid #c2bfbb;
        padding: 60px 0;
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 40px;
        align-items: center;
        margin-top: 60px;
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
        min-width: 120px;
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
        .content {
            padding: 30px 15px;
        }

        .memorial-section {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .form-container {
            padding: 25px;
        }

        .sign-up-section {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 25px;
        }
    }

    /* Mobile Styles - Show hamburger menu */
    @media (max-width: 768px) {
        header {
            flex-direction: row;
            justify-content: space-between;
            padding: 15px 20px;
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

        .content {
            padding: 20px 10px;
        }

        .memorial-section {
            gap: 30px;
        }

        .form-container {
            padding: 20px;
        }

        .form-group.name-group {
            grid-template-columns: 1fr;
        }

        .form-group {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .form-group input,
        .form-group select {
            padding: 10px;
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
            padding: 10px 15px;
        }

        .mobile-nav a {
            font-size: 20px;
            padding: 12px 25px;
        }

        .content {
            padding: 15px 8px;
        }

        .form-container {
            padding: 15px;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .results, .error {
            padding: 12px;
            font-size: 14px;
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
        .form-group select {
            min-height: 44px;
        }
    }

    /* Print Styles */
    @media print {
        header, footer, .sign-up-section, .mobile-nav-overlay {
            display: none;
        }
        
        body {
            background-color: white;
        }
        
        .form-container {
            box-shadow: none;
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

<div class="content">
    <section class="memorial-section">
        <div class="form-container">
            <h2>Locate your loved one here</h2>
            <form action="process.php" method="POST">
                <label class="form-label">Name*</label>
                <div class="form-group name-group">
                    <input type="text" name="first_name" placeholder="FIRST NAME" required>
                    <input type="text" name="last_name" placeholder="LAST NAME" required>
                    <input type="text" name="middle_initial" placeholder="M.I.">
                </div>
                
                <div class="form-group">
                    <select name="year_born">
                        <option value="">Year Born</option>
                        <?php
                        for ($i = date("Y"); $i >= 1900; $i--) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <select name="year_died">
                        <option value="">Year Died</option>
                        <?php
                        for ($i = date("Y"); $i >= 1900; $i--) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <input type="text" name="cemetery_location" placeholder="Cemetery Location">
                </div>
                
                <button type="submit">Locate Grave</button>
            </form>
            
            <?php if (isset($searchResult)) : ?>
                <div class="results"><?php echo $searchResult; ?></div>
            <?php elseif (isset($searchError)) : ?>
                <div class="error"><?php echo $searchError; ?></div>
            <?php endif; ?>
        </div>
        
        <div class="map-container">
            <img src="map2.png" alt="Cemetery Map" class="map-image">
        </div>
    </section>

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