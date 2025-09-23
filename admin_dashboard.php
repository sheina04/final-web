<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rest Assured</title>
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

        .notification-icon {
            position: relative;
            color: #664832;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .notification-icon:hover {
            background-color: rgba(139, 111, 77, 0.1);
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

        /* Dashboard Sections */
        .payment-statistics {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            color: #664832;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.15);
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #8B6F4D, #664832);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #664832;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.7);
            font-weight: 500;
        }

        .stat-sublabel {
            font-size: 11px;
            color: rgba(102, 72, 50, 0.5);
            margin-top: 2px;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .main-section {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .side-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Activities Section */
        .activities-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
            min-height: 300px;
        }

        .activity-placeholder {
            height: 200px;
            background: rgba(139, 111, 77, 0.05);
            border: 2px dashed rgba(139, 111, 77, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(102, 72, 50, 0.5);
            font-size: 14px;
        }

        /* Graves Statistics */
        .graves-stats {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
        }

        .graves-stat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid rgba(139, 111, 77, 0.1);
        }

        .graves-stat-item:last-child {
            border-bottom: none;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #664832;
            width: 80px;
            text-align: center;
            background: rgba(139, 111, 77, 0.1);
            border-radius: 10px;
            padding: 10px;
        }

        .stat-description {
            flex: 1;
            margin-left: 20px;
        }

        .stat-main-text {
            font-size: 14px;
            color: #664832;
            font-weight: 600;
        }

        .stat-sub-text {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.6);
            margin-top: 2px;
        }

        /* Calendar Styles */
        .calendar-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
        }

        .calendar-widget {
            font-family: 'Montserrat', sans-serif;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-nav {
            background: none;
            border: none;
            color: #664832;
            font-size: 18px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .calendar-nav:hover {
            background-color: rgba(139, 111, 77, 0.1);
        }

        .calendar-month-year {
            font-size: 16px;
            font-weight: 600;
            color: #664832;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            margin-bottom: 10px;
        }

        .calendar-day-header {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: rgba(102, 72, 50, 0.7);
            padding: 8px 0;
            background-color: rgba(139, 111, 77, 0.1);
            border-radius: 4px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
        }

        .calendar-day:hover {
            background-color: rgba(139, 111, 77, 0.1);
        }

        .calendar-day.other-month {
            color: rgba(102, 72, 50, 0.3);
        }

        .calendar-day.today {
            background-color: #8B6F4D;
            color: white;
            font-weight: 600;
        }

        .calendar-day.selected {
            background-color: #664832;
            color: white;
            font-weight: 600;
        }

        .calendar-day.has-event::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background-color: #8B6F4D;
            border-radius: 50%;
        }

        .calendar-day.today.has-event::after {
            background-color: white;
        }

        .calendar-events {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(139, 111, 77, 0.1);
        }

        .calendar-events-title {
            font-size: 12px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 10px;
        }

        .calendar-event {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0;
            font-size: 11px;
            color: rgba(102, 72, 50, 0.8);
        }

        .calendar-event-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #8B6F4D;
        }

        /* Activity Log Card */
        .activity-log-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
        }

        /* Notifications */
        .notifications-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .notification-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
            min-height: 150px;
        }

        .notification-placeholder {
            height: 100px;
            background: rgba(139, 111, 77, 0.05);
            border: 2px dashed rgba(139, 111, 77, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(102, 72, 50, 0.5);
            font-size: 14px;
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
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
            
            <div class="notification-icon">🔔</div>
            
            <div class="user-profile" onclick="toggleDropdown()">
                <div class="user-avatar">A</div>
                <span class="user-name">Admin</span>
                <span class="dropdown-arrow">▼</span>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Settings</a>
                    <a href="#" class="dropdown-item">Logout</a>
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
                        <a href="admin_dashboard.php" class="nav-link active">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="burial_plot_management.php" class="nav-link">
                            <span class="nav-icon">⚰️</span>
                            Burial Plot Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_record.php" class="nav-link">
                            <span class="nav-icon">👥</span>
                            Manage Customer Records
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin_transaction_management.php" class="nav-link">
                            <span class="nav-icon">💳</span>
                            Transaction Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="notification_management.php" class="nav-link">
                            <span class="nav-icon">🔔</span>
                            Notification Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="report_analytics.php" class="nav-link">
                            <span class="nav-icon">📈</span>
                            Report & Analytics
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Payment Statistics -->
            <section class="payment-statistics">
                <h2 class="section-title">Payment Statistics</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">💰</div>
                        </div>
                        <div class="stat-value">₱50,000</div>
                        <div class="stat-label">collected</div>
                        <div class="stat-sublabel">Payments Collected This Month</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">⏳</div>
                        </div>
                        <div class="stat-value">₱10,000</div>
                        <div class="stat-label">pending from 3 clients</div>
                        <div class="stat-sublabel">Pending Payments</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">⚠️</div>
                        </div>
                        <div class="stat-value">2</div>
                        <div class="stat-label">payments overdue (₱9,000 total)</div>
                        <div class="stat-sublabel">Pending Payments</div>
                    </div>
                </div>
            </section>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Main Section -->
                <div class="main-section">
                    <!-- Activities -->
                    <section>
                        <h2 class="section-title">Activities</h2>
                        <div class="activities-card">
                            <div class="activity-placeholder">
                                Recent activities will be displayed here
                            </div>
                        </div>
                    </section>

                    <!-- Notifications -->
                    <section>
                        <h2 class="section-title">Notifications</h2>
                        <div class="notifications-grid">
                            <div class="notification-card">
                                <div class="notification-placeholder">
                                    System notifications
                                </div>
                            </div>
                            <div class="notification-card">
                                <div class="notification-placeholder">
                                    Payment reminders
                                </div>
                            </div>
                            <div class="notification-card">
                                <div class="notification-placeholder">
                                    Renewal alerts
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Side Section -->
                <div class="side-section">
                    <!-- Total Graves -->
                    <section>
                        <h2 class="section-title">Total number of graves</h2>
                        <div class="graves-stats">
                            <div class="graves-stat-item">
                                <div class="stat-number">245</div>
                                <div class="stat-description">
                                    <div class="stat-main-text">graves available out of 1,000 total.</div>
                                </div>
                            </div>
                            
                            <div class="graves-stat-item">
                                <div class="stat-number">730</div>
                                <div class="stat-description">
                                    <div class="stat-main-text">graves occupied.</div>
                                </div>
                            </div>
                            
                            <div class="graves-stat-item">
                                <div class="stat-number">25</div>
                                <div class="stat-description">
                                    <div class="stat-main-text">graves pending renewal.</div>
                                </div>
                            </div>
                            
                            <div class="graves-stat-item">
                                <div class="stat-number">15</div>
                                <div class="stat-description">
                                    <div class="stat-main-text">graves expiring</div>
                                    <div class="stat-sub-text">within the next 30 days.</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Calendar -->
                    <section>
                        <h2 class="section-title">Calendar</h2>
                        <div class="calendar-card">
                            <div class="calendar-widget" id="calendar">
                                <div class="calendar-header">
                                    <button class="calendar-nav" onclick="changeMonth(-1)">‹</button>
                                    <div class="calendar-month-year" id="monthYear"></div>
                                    <button class="calendar-nav" onclick="changeMonth(1)">›</button>
                                </div>
                                
                                <div class="calendar-grid" id="calendarGrid">
                                    <!-- Calendar days will be generated here -->
                                </div>
                                
                                <div class="calendar-events">
                                    <div class="calendar-events-title">Upcoming Events</div>
                                    <div class="calendar-event">
                                        <div class="calendar-event-dot"></div>
                                        Payment due reminder
                                    </div>
                                    <div class="calendar-event">
                                        <div class="calendar-event-dot"></div>
                                        Renewal notifications
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Activity Log -->
                    <section>
                        <h2 class="section-title">Activity Log</h2>
                        <div class="activity-log-card">
                            <div class="activity-placeholder">
                                Recent system activities
                            </div>
                        </div>
                    </section>
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
    // Calendar functionality (same as imong original)
    let currentDate = new Date();
    let selectedDate = null;
    const events = {
        '2025-08-29': ['Payment Due: Smith Family'],
        '2025-08-30': ['Renewal: Johnson Plot'],
        '2025-09-01': ['Maintenance Scheduled'],
        '2025-09-05': ['Payment Due: Brown Family'],
        '2025-09-10': ['Plot Inspection'],
        '2025-09-15': ['Renewal: Davis Plot']
    };

    function initCalendar() { updateCalendar(); }
    function updateCalendar() { /* same code as yours */ }
    function changeMonth(delta) { currentDate.setMonth(currentDate.getMonth() + delta); updateCalendar(); }
    function selectDate(dateString, element) { /* same code as yours */ }
    function updateDate() { /* same code as yours */ }

    // Toggle user dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('active');
    }
    document.addEventListener('click', function(event) {
        const userProfile = document.querySelector('.user-profile');
        const dropdown = document.getElementById('userDropdown');
        if (userProfile && !userProfile.contains(event.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Sidebar toggle
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('overlay').classList.toggle('active');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('overlay').classList.remove('active');
    }
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) closeSidebar();
    });

    // ✅ FIXED: Highlight active nav link based on URL
    document.addEventListener('DOMContentLoaded', function() {
        updateDate();
        initCalendar();

        const currentPage = window.location.pathname.split("/").pop();
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const linkPage = link.getAttribute('href');
            if (linkPage === currentPage) {
                link.classList.add('active');
            }
        });
    });

    // Update date every minute
    setInterval(updateDate, 60000);
    function updateDashboardData() { console.log('Updating dashboard data...'); }
    setInterval(updateDashboardData, 300000);
</script>

</body>
</html>