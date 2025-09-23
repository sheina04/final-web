<?php
// grave_locator.php
session_start();

// Sample user data (in a real application, this would come from a database)
$user = [
    'name' => 'Maria Clara',
    'initials' => 'MC'
];

// Handle search if form is submitted
$search_result = null;
if ($_POST['search'] ?? false) {
    $search_term = $_POST['search_term'] ?? '';
    $search_type = $_POST['search_type'] ?? 'name';
    
    // In a real application, you would query a database here
    $search_result = "Searching for: " . htmlspecialchars($search_term) . " by " . htmlspecialchars($search_type);
}

$current_date = date('l, j M Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grave Locator - Rest Assured</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
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
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: rgb(255, 242, 225);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(102, 72, 50, 0.1);
        }

        .logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 600;
            color: #664832;
            text-decoration: none;
        }

        .logo::before {
            content: "RA";
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            position: relative;
        }

        .search-box {
            width: 400px;
            padding: 12px 45px 12px 20px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 25px;
            background-color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            color: #664832;
            transition: all 0.3s ease;
        }

        .search-box::placeholder {
            color: rgba(102, 72, 50, 0.6);
        }

        .search-box:focus {
            outline: none;
            border-color: #664832;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(102, 72, 50, 0.6);
            font-size: 16px;
        }

        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 25px;
            background-color: #8B6F4D;
            color: white;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background-color: #664832;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B6F4D, #664832);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
        }

        .dropdown-arrow {
            font-size: 12px;
            margin-left: 5px;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.2);
            padding: 10px 0;
            min-width: 150px;
            z-index: 1001;
            display: none;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-item {
            padding: 12px 20px;
            color: #664832;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(139, 111, 77, 0.1);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: rgba(255, 255, 255, 0.4);
            padding: 90px 0 30px 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .sidebar-header {
            padding: 0 30px 30px 30px;
        }

        .sidebar-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 5px;
        }

        .sidebar-date {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.7);
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 30px;
            color: #664832;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 30px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(139, 111, 77, 0.2);
            color: #3E2A1E;
            font-weight: 600;
        }

        .nav-link.active {
            background-color: rgba(139, 111, 77, 0.3);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 90px 30px 30px 30px;
            transition: margin-left 0.3s ease;
        }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 600;
            color: #664832;
            text-align: center;
            margin-bottom: 50px;
            letter-spacing: 1px;
        }

        .search-section {
            background-color: rgba(255, 255, 255, 0.6);
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.1);
        }

        .search-form {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: flex-end;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .form-label {
            font-size: 14px;
            color: #664832;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .search-field {
            padding: 12px 20px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 10px;
            font-size: 14px;
            width: 300px;
            outline: none;
            transition: border-color 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
            color: #664832;
        }

        .search-field:focus {
            border-color: #8B6F4D;
            background-color: white;
        }

        .select-field {
            padding: 12px 20px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 10px;
            font-size: 14px;
            width: 150px;
            background-color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            outline: none;
            color: #664832;
        }

        .search-btn {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 24px;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #664832, #3E2A1E);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.3);
        }

        /* Cemetery Grid */
        .cemetery-section {
            background-color: rgba(255, 255, 255, 0.6);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.1);
            text-align: center;
        }

        .cemetery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
            gap: 8px;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: inset 0 2px 10px rgba(102, 72, 50, 0.1);
        }

        .cemetery-plot {
            aspect-ratio: 1;
            background-color: #d4c4a8;
            border-radius: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            border: 2px solid transparent;
        }

        .cemetery-plot:hover {
            background-color: #c7b59a;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 72, 50, 0.2);
        }

        .cemetery-plot.occupied {
            background-color: #8B6F4D;
        }

        .cemetery-plot.occupied:hover {
            background-color: #664832;
        }

        .cemetery-plot.selected {
            background-color: #664832;
            border-color: #3E2A1E;
            box-shadow: 0 0 0 3px rgba(102, 72, 50, 0.3);
        }

        /* Footer */
        .footer {
            background-color: rgb(255, 242, 225);
            padding: 20px 30px;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }

        .footer-content {
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            gap: 30px;
            align-items: center;
        }

        .footer-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 600;
            color: #664832;
        }

        .footer-logo::before {
            content: "RA";
        }

        .footer-info {
            font-size: 14px;
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
            font-size: 12px;
            color: #8B6F4D;
            text-align: right;
        }

        /* Mobile Styles */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #664832;
            font-size: 20px;
            cursor: pointer;
        }

        /* Search Results */
        .search-results {
            background-color: rgba(139, 111, 77, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            border: 1px solid rgba(102, 72, 50, 0.2);
            color: #664832;
        }

        /* Tablet and Mobile Responsive */
        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }

            .cemetery-grid {
                grid-template-columns: repeat(10, 1fr);
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content,
            .footer {
                margin-left: 0;
            }

            .top-header {
                padding: 0 20px;
            }

            .search-container {
                display: none;
            }

            .header-right {
                gap: 15px;
            }

            .main-content {
                padding: 90px 20px 30px 20px;
            }

            .search-section,
            .cemetery-section {
                padding: 30px 25px;
            }

            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-field, .select-field {
                width: 100%;
            }

            .cemetery-grid {
                grid-template-columns: repeat(8, 1fr);
                padding: 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 15px;
            }

            .footer-copyright {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .top-header {
                padding: 0 15px;
            }

            .main-content {
                padding: 90px 15px 20px 15px;
            }

            .search-section,
            .cemetery-section {
                padding: 25px 20px;
            }

            .cemetery-grid {
                grid-template-columns: repeat(6, 1fr);
            }

            .user-name {
                display: none;
            }
        }

        /* Overlay for mobile menu */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <header class="top-header">
        <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
        <a href="#" class="logo"></a>
        
        <div class="header-right">
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search">
                <span class="search-icon">🔍</span>
            </div>
            
            <div class="user-profile" onclick="toggleDropdown()">
                <div class="user-avatar"><?php echo htmlspecialchars($user['initials']); ?></div>
                <span class="user-name"><?php echo htmlspecialchars($user['name']); ?></span>
                <span class="dropdown-arrow">▼</span>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Grave Locator</h2>
                <p class="sidebar-date"><?php echo $current_date; ?></p>
            </div>
            
            <nav>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="customer_dashboard.php" class="nav-link">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="customer_grave_locator.php" class="nav-link active">
                            <span class="nav-icon">📍</span>
                            Grave Locator
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="burial_details.php" class="nav-link">
                            <span class="nav-icon">⚰️</span>
                            Burial Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="transaction.php" class="nav-link">
                            <span class="nav-icon">💳</span>
                            Transaction
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="notification.php" class="nav-link">
                            <span class="nav-icon">🔔</span>
                            Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="help_support.php" class="nav-link">
                            <span class="nav-icon">❓</span>
                            Help & Support
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1 class="page-title">Locate your loved one</h1>
            
            <div class="search-section">
                <form method="POST" class="search-form">
                    <div class="form-group">
                        <label class="form-label">Search by name or code</label>
                        <input 
                            type="text" 
                            name="search_term" 
                            class="search-field" 
                            placeholder="Enter deceased name or code"
                            value="<?php echo htmlspecialchars($_POST['search_term'] ?? ''); ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Search Type</label>
                        <select name="search_type" class="select-field">
                            <option value="name" <?php echo ($_POST['search_type'] ?? '') === 'name' ? 'selected' : ''; ?>>Name</option>
                            <option value="code" <?php echo ($_POST['search_type'] ?? '') === 'code' ? 'selected' : ''; ?>>Code</option>
                            <option value="date" <?php echo ($_POST['search_type'] ?? '') === 'date' ? 'selected' : ''; ?>>Date</option>
                        </select>
                    </div>
                    
                    <button type="submit" name="search" class="search-btn">Search</button>
                </form>

                <?php if ($search_result): ?>
                    <div class="search-results">
                        <?php echo htmlspecialchars($search_result); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cemetery Grid -->
            <div class="cemetery-section">
                <div class="cemetery-grid" id="cemeteryGrid">
                    <!-- Generate cemetery plots -->
                    <?php for ($i = 0; $i < 80; $i++): ?>
                        <div class="cemetery-plot <?php echo rand(1, 4) === 1 ? 'occupied' : ''; ?>" 
                             data-plot="<?php echo $i + 1; ?>"
                             onclick="selectPlot(this)"></div>
                    <?php endfor; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
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

    <!-- Mobile Overlay -->
    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

  <script>
    // Toggle user dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const userProfile = document.querySelector('.user-profile');
        const dropdown = document.getElementById('userDropdown');
        
        if (userProfile && !userProfile.contains(event.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Toggle mobile sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Close mobile sidebar
    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    }

    // Cemetery plot selection
    function selectPlot(element) {
        // Remove previous selection
        document.querySelectorAll('.cemetery-plot.selected').forEach(plot => {
            plot.classList.remove('selected');
        });
        
        // Add selection to clicked plot
        element.classList.add('selected');
        
        // Show plot number (sample functionality)
        const plotNumber = element.dataset.plot;
        console.log('Selected plot:', plotNumber);
    }

    // ✅ Fixed navigation links
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split("/").pop();
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const linkPage = link.getAttribute('href');

            // Highlight current active link based on page
            if (linkPage === currentPage) {
                link.classList.add('active');
            }

            // Close sidebar when a link is clicked (mobile only)
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
</script>

</body>
</html>