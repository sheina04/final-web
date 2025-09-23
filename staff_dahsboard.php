<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Rest Assured</title>
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
            pointer-events: none;
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: #664832;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .notification-btn:hover {
            background-color: rgba(102, 72, 50, 0.1);
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
            z-index: 1001;
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
            z-index: 1002;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
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
            cursor: pointer;
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

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 16px;
            color: rgba(102, 72, 50, 0.7);
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 72, 50, 0.15);
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 10px;
        }

        /* Activities Section */
        .activities-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 20px;
        }

        .activities-container {
            background: rgba(139, 111, 77, 0.05);
            border-radius: 10px;
            padding: 20px;
            border: 2px dashed rgba(102, 72, 50, 0.2);
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(102, 72, 50, 0.6);
            font-style: italic;
        }

        .graves-stats {
            display: grid;
            gap: 15px;
        }

        .stat-item {
            background: rgba(139, 111, 77, 0.1);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #664832;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Notifications Section */
        .notifications-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .notifications-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .notification-card {
            background: rgba(139, 111, 77, 0.05);
            border-radius: 10px;
            padding: 20px;
            border: 2px dashed rgba(102, 72, 50, 0.2);
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(102, 72, 50, 0.6);
            font-style: italic;
            text-align: center;
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
            z-index: 1001;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .activities-section {
                grid-template-columns: 1fr;
            }
            
            .notifications-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }
            
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
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

            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .activities-section,
            .notifications-section {
                padding: 20px;
            }

            .notifications-grid {
                grid-template-columns: 1fr;
                gap: 15px;
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

            .dashboard-card,
            .activities-section,
            .notifications-section {
                padding: 15px;
            }

            .user-name {
                display: none;
            }

            .page-title {
                font-size: 28px;
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
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <header class="top-header">
        <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
        <a href="staff_dashboard.php" class="logo"></a>
        
        <div class="header-right">
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search">
                <span class="search-icon">🔍</span>
            </div>
            
            <button class="notification-btn">🔔</button>
            
            <div class="user-profile" id="userProfile">
                <div class="user-avatar">S</div>
                <span class="user-name">Staff</span>
                <span class="dropdown-arrow">▼</span>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="staff_profile.php" class="dropdown-item">Profile</a>
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
                        <a href="staff_dashboard.php" class="nav-link active">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="staff_update_status.php" class="nav-link">
                            <span class="nav-icon">📍</span>
                            Update Plot Status
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="staff_notification_management.php" class="nav-link">
                            <span class="nav-icon">🔔</span>
                            Notification Management
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Thursday, 2 May 2025</p>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3 class="card-title">Payment Statistics</h3>
                    <div style="background: rgba(139, 111, 77, 0.05); border-radius: 10px; padding: 20px; border: 2px dashed rgba(102, 72, 50, 0.2); min-height: 120px; display: flex; align-items: center; justify-content: center; color: rgba(102, 72, 50, 0.6); font-style: italic;">
                        Payment data will appear here
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <h3 class="card-title">Recent Transactions</h3>
                    <div style="background: rgba(139, 111, 77, 0.05); border-radius: 10px; padding: 20px; border: 2px dashed rgba(102, 72, 50, 0.2); min-height: 120px; display: flex; align-items: center; justify-content: center; color: rgba(102, 72, 50, 0.6); font-style: italic;">
                        Transaction data will appear here
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <h3 class="card-title">Pending Requests</h3>
                    <div style="background: rgba(139, 111, 77, 0.05); border-radius: 10px; padding: 20px; border: 2px dashed rgba(102, 72, 50, 0.2); min-height: 120px; display: flex; align-items: center; justify-content: center; color: rgba(102, 72, 50, 0.6); font-style: italic;">
                        Pending requests will appear here
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <h3 class="card-title">Quick Actions</h3>
                    <div style="background: rgba(139, 111, 77, 0.05); border-radius: 10px; padding: 20px; border: 2px dashed rgba(102, 72, 50, 0.2); min-height: 120px; display: flex; align-items: center; justify-content: center; color: rgba(102, 72, 50, 0.6); font-style: italic;">
                        Quick action buttons will appear here
                    </div>
                </div>
            </div>

            <!-- Activities Section -->
            <section class="activities-section">
                <div>
                    <h2 class="section-title">Activities</h2>
                    <div class="activities-container">
                        Activity timeline will appear here
                    </div>
                </div>
                
                <div>
                    <h3 class="section-title">Total number of graves</h3>
                    <div class="graves-stats">
                        <div class="stat-item">
                            <div class="stat-number">250</div>
                            <div class="stat-label">Total Plots</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-number">180</div>
                            <div class="stat-label">Occupied</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-number">70</div>
                            <div class="stat-label">Available</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-number">15</div>
                            <div class="stat-label">Maintenance</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Notifications Section -->
            <section class="notifications-section">
                <h2 class="section-title">Notifications</h2>
                <div class="notifications-grid">
                    <div class="notification-card">
                        System notifications will appear here
                    </div>
                    
                    <div class="notification-card">
                        Payment reminders will appear here
                    </div>
                    
                    <div class="notification-card">
                        Important alerts will appear here
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
    <div class="overlay" id="overlay"></div>

    <script>
        // DOM Elements
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const userProfile = document.getElementById('userProfile');
        const userDropdown = document.getElementById('userDropdown');

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
            document.querySelectorAll('.sidebar-date, .page-subtitle').forEach(element => {
                element.textContent = dateString;
            });
        }

        // Toggle user dropdown
        function toggleDropdown() {
            userDropdown.classList.toggle('active');
        }

        // Toggle mobile sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : 'auto';
        }

        // Close mobile sidebar
        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Event Listeners
        mobileMenuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', closeSidebar);
        userProfile.addEventListener('click', toggleDropdown);

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!userProfile.contains(event.target)) {
                userDropdown.classList.remove('active');
            }
        });

         // Handle navigation links
      document.addEventListener('DOMContentLoaded', function () {
    const currentPage = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href');

        // Highlight link if it matches current page
        if (linkPage === currentPage) {
            link.classList.add('active');
        }

        // Close sidebar after clicking (for mobile)
        link.addEventListener('click', function () {
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

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Close dropdown and sidebar with Escape key
            if (e.key === 'Escape') {
                if (userDropdown.classList.contains('active')) {
                    userDropdown.classList.remove('active');
                }
                if (sidebar.classList.contains('active') && window.innerWidth <= 768) {
                    closeSidebar();
                }
            }
        });

        // Initialize date on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
        });

        // Update date every minute
        setInterval(updateDate, 60000);

        // Add hover effects to dashboard cards
        document.querySelectorAll('.dashboard-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add smooth scrolling for better UX
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add loading animation simulation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.3s ease';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>