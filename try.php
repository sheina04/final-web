<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rest Assured</title>
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

        .welcome-section {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(102, 72, 50, 0.2);
        }

        .welcome-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .welcome-text {
            font-size: clamp(14px, 2vw, 16px);
            line-height: 1.6;
            opacity: 0.9;
        }

        .overview-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 18px;
            color: rgba(102, 72, 50, 0.7);
            margin-bottom: 25px;
            font-weight: 500;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            border-radius: 15px;
            padding: 30px;
            height: 180px;
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 72, 50, 0.3);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .card-description {
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.4;
        }

        .large-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .large-card {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            border-radius: 15px;
            padding: 40px;
            height: 220px;
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .large-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .large-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 72, 50, 0.3);
        }

        .large-card:hover::before {
            opacity: 1;
        }

        .large-card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .large-card-description {
            font-size: 16px;
            line-height: 1.5;
            opacity: 0.9;
        }

        .large-card-icon {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 48px;
            opacity: 0.8;
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
            padding: 5px;
        }

        /* Tablet and Mobile Responsive */
        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }

            .cards-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .large-cards-grid {
                grid-template-columns: 1fr;
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

            .welcome-section {
                padding: 30px 25px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .large-cards-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .card,
            .large-card {
                height: 150px;
                padding: 25px;
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

            .welcome-section {
                padding: 25px 20px;
            }

            .card,
            .large-card {
                height: 130px;
                padding: 20px;
            }

            .card-value {
                font-size: 24px;
            }

            .card-title {
                font-size: 18px;
            }

            .large-card-title {
                font-size: 20px;
            }

            .large-card-icon {
                font-size: 36px;
                right: 20px;
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

        /* Card specific styles */
        .action-button {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            margin-top: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(5px);
        }

        .badge {
            background: rgba(255, 255, 255, 0.9);
            color: #664832;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <header class="top-header">
        <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
        <a href="index.php" class="logo"></a>
        
        <div class="header-right">
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search graves, payments, or services...">
                <span class="search-icon">🔍</span>
            </div>
            
            <div class="user-profile" onclick="toggleDropdown()">
                <div class="user-avatar">MC</div>
                <span class="user-name">Maria Clara</span>
                <span class="dropdown-arrow">▼</span>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="profile.php" class="dropdown-item">Profile</a>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Dashboard</h2>
                <p class="sidebar-date">Thursday, 2 May 2025</p>
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
                        <a href="customer_grave_locator.php" class="nav-link">
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
                        <a href="transaction.php" class="nav-link active">
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
            <!-- Welcome Section -->
            <section class="welcome-section">
                <h1 class="welcome-title">Hi, Maria!</h1>
                <p class="welcome-text">
                    Welcome back to your Rest Assured dashboard. We're here to assist you with managing graves, payments, and memorial services. Your journey to peace of mind starts here!
                </p>
            </section>

            <!-- Overview Section -->
            <section class="overview-section">
                <h2 class="section-title">Dashboard Overview</h2>
                
                <div class="cards-grid">
                    <div class="card" onclick="navigateTo('new_grave_locator')">
                        <h3 class="card-title">Managed Graves</h3>
                        <div class="card-value">3</div>
                        <p class="card-description">Your memorial sites under our care</p>
                        <div class="action-button">View Details →</div>
                    </div>
                    <div class="card" onclick="navigateTo('new_transaction')">
                        <h3 class="card-title">Pending Payments</h3>
                        <div class="card-value">2</div>
                        <p class="card-description">Due within the next 30 days</p>
                        <div class="badge">PHP 5,200 Total</div>
                    </div>
                    <div class="card" onclick="navigateTo('notifications')">
                        <h3 class="card-title">Notifications</h3>
                        <div class="card-value">5</div>
                        <p class="card-description">Updates and reminders waiting</p>
                        <div class="badge">3 New</div>
                    </div>
                </div>

                <div class="large-cards-grid">
                    <div class="large-card" onclick="navigateTo('reports')">
                        <h3 class="large-card-title">Service Analytics</h3>
                        <p class="large-card-description">
                            Track maintenance schedules, visit frequencies, and service history for all your memorial sites.
                        </p>
                        <div class="large-card-icon">📈</div>
                        <div class="action-button">View Reports →</div>
                    </div>
                    <div class="large-card" onclick="navigateTo('help_support')">
                        <h3 class="large-card-title">Quick Support</h3>
                        <p class="large-card-description">
                            Need assistance? Our support team is available 24/7 to help you with any questions or concerns.
                        </p>
                        <div class="large-card-icon">🆘</div>
                        <div class="action-button">Get Help →</div>
                    </div>
                </div>
            </section>

            <!-- Quick Actions Section -->
            <section class="overview-section">
                <h2 class="section-title">Quick Actions</h2>
                <div class="cards-grid">
                    <div class="card" onclick="navigateTo('add_new_grave')">
                        <h3 class="card-title">Add New Grave</h3>
                        <p class="card-description">Register a new memorial site with our services</p>
                        <div class="action-button">Get Started →</div>
                    </div>
                    <div class="card" onclick="navigateTo('schedule_visit')">
                        <h3 class="card-title">Schedule Visit</h3>
                        <p class="card-description">Plan your next visit to the memorial park</p>
                        <div class="action-button">Schedule Now →</div>
                    </div>
                </div>
            </section>
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
        // Get current date
        function updateDate() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const dateString = now.toLocaleDateString('en-US', options);
            const dateElement = document.querySelector('.sidebar-date');
            if (dateElement) {
                dateElement.textContent = dateString;
            }
        }

        // Toggle user dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
            
            // Close other dropdowns if any
            event.stopPropagation();
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userProfile = document.querySelector('.user-profile');
            const dropdown = document.getElementById('userDropdown');
            
            if (!userProfile.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Toggle mobile sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            event.stopPropagation();
        }

        // Close mobile sidebar
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }

        // Navigation function for cards - Updated to actually navigate
        function navigateTo(section) {
            console.log('Navigating to:', section);
            window.location.href = section + '.php';
        }

        // Handle search functionality
        document.querySelector('.search-box').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    window.location.href = 'search.php?q=' + encodeURIComponent(searchTerm);
                }
            }
        });

        // Handle navigation links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Navigate to the href
                window.location.href = this.getAttribute('href');
                
                // Close mobile sidebar if open
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        // Initialize date on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            
            // Simulate loading data (replace with actual API calls)
            setTimeout(() => {
                // This would be replaced with actual data from PHP/API
                console.log('Loading dashboard data...');
            }, 1000);
        });

        // Update date every minute
        setInterval(updateDate, 60000);

        // Demo data - would be replaced with actual PHP data
        function loadDemoData() {
            // This simulates data that would come from PHP
            const demoData = {
                graves: 3,
                payments: 2,
                notifications: 5,
                totalAmount: 'PHP 5,200'
            };
            
            // Update card values
            document.querySelectorAll('.card-value')[0].textContent = demoData.graves;
            document.querySelectorAll('.card-value')[1].textContent = demoData.payments;
            document.querySelectorAll('.card-value')[2].textContent = demoData.notifications;
        }

        // Load demo data on page load
        window.addEventListener('load', loadDemoData);
    </script>

    <?php
    /*
    // Example of how PHP would integrate (uncomment when using with actual PHP)
    session_start();
    
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
    
    // Get user data
    $user_name = $_SESSION['user_name'] ?? 'User';
    $user_initials = strtoupper(substr($user_name, 0, 1) . substr(strstr($user_name, ' '), 1, 1));
    
    // Database queries for dashboard data
    // Replace with your actual database queries
    $graves_count = 3; // getDashboardData('graves');
    $payments_due = 2; // getDashboardData('payments');
    $notifications_count = 5; // getDashboardData('notifications');
    $total_amount = 'PHP 5,200'; // calculateTotalAmount();
    
    echo "<script>
        function loadRealData() {
            document.querySelectorAll('.card-value')[0].textContent = $graves_count;
            document.querySelectorAll('.card-value')[1].textContent = $payments_due;
            document.querySelectorAll('.card-value')[2].textContent = $notifications_count;
            document.querySelector('.badge').textContent = '$total_amount Total';
            document.querySelector('.user-avatar').textContent = '$user_initials';
            document.querySelector('.user-name').textContent = '$user_name';
            document.querySelector('.welcome-title').textContent = 'Hi, $user_name!';
        }
        window.addEventListener('load', loadRealData);
    </script>";
    */
    ?>
</body>
</html>

