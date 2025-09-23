<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report & Analytics - Rest Assured Admin</title>
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

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 48px;
            font-weight: 700;
            color: #8B6F4D;
            margin-bottom: 10px;
            font-family: 'Montserrat', sans-serif;
        }

        .stat-label {
            font-size: 14px;
            color: rgba(102, 72, 50, 0.7);
            font-weight: 500;
        }

        /* Reports Section */
        .reports-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .section-header {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 15px;
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            gap: 0;
            margin-bottom: 25px;
            border-bottom: 2px solid rgba(102, 72, 50, 0.1);
        }

        .tab-btn {
            padding: 12px 25px;
            background: none;
            border: none;
            color: rgba(102, 72, 50, 0.6);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            position: relative;
        }

        .tab-btn.active {
            color: #8B6F4D;
            border-bottom-color: #8B6F4D;
            font-weight: 600;
        }

        .tab-btn:hover {
            color: #8B6F4D;
        }

        /* Transaction Reports Table */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 600px;
        }

        .reports-table th {
            background-color: rgba(139, 111, 77, 0.1);
            color: #664832;
            font-weight: 600;
            padding: 15px 12px;
            text-align: left;
            font-size: 14px;
            border-bottom: 2px solid rgba(102, 72, 50, 0.1);
        }

        .reports-table td {
            padding: 15px 12px;
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
            color: #3E2A1E;
            font-size: 14px;
        }

        .reports-table tr:hover {
            background-color: rgba(139, 111, 77, 0.05);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-paid {
            background-color: rgba(34, 197, 94, 0.1);
            color: #059669;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 20px;
            text-align: center;
        }

        .chart-placeholder {
            height: 300px;
            background: linear-gradient(135deg, rgba(139, 111, 77, 0.1), rgba(102, 72, 50, 0.05));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(102, 72, 50, 0.5);
            font-style: italic;
            font-size: 16px;
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
        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }

            .charts-grid {
                grid-template-columns: 1fr;
                gap: 20px;
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
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-number {
                font-size: 36px;
            }

            .reports-section {
                padding: 20px;
            }

            .chart-card {
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

            .tab-nav {
                flex-wrap: wrap;
            }

            .tab-btn {
                flex: 1;
                min-width: 120px;
            }
        }

        @media (max-width: 480px) {
            .top-header {
                padding: 0 15px;
            }

            .main-content {
                padding: 90px 15px 20px 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .reports-section {
                padding: 15px;
            }

            .chart-card {
                padding: 15px;
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
        <a href="admin_dashboard.php" class="logo"></a>
        
        <div class="header-right">
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search">
                <span class="search-icon">🔍</span>
            </div>
            
            <button class="notification-btn">🔔</button>
            
            <div class="user-profile" id="userProfile">
                <div class="user-avatar">A</div>
                <span class="user-name">Admin</span>
                <span class="dropdown-arrow">▼</span>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="admin_profile.php" class="dropdown-item">Profile</a>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Report & Analytics</h2>
                <p class="sidebar-date">Thursday, 7 May 2025</p>
            </div>
            
            <nav>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="admin_dashboard.php" class="nav-link">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="burial_plot_management.php" class="nav-link">
                            <span class="nav-icon">📍</span>
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
                        <a href="report_analytics.php" class="nav-link active">
                            <span class="nav-icon">📈</span>
                            Report & Analytics
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Report & Analytics</h1>
                <p class="page-subtitle">Comprehensive reports and data analytics</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">453</div>
                    <div class="stat-label">Total Customers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">385</div>
                    <div class="stat-label">Occupied Plots</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">115</div>
                    <div class="stat-label">Available Plots</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">62</div>
                    <div class="stat-label">Pending Renewals</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">41</div>
                    <div class="stat-label">Expired Contracts</div>
                </div>
            </div>

            <!-- Reports Section -->
            <section class="reports-section">
                <div class="section-header">
                    <h2 class="section-title">Reports</h2>
                    
                    <!-- Tab Navigation -->
                    <div class="tab-nav">
                        <button class="tab-btn active" data-tab="transaction-reports">Transaction Reports</button>
                        <button class="tab-btn" data-tab="plot-status">Plot Status Reports</button>
                        <button class="tab-btn" data-tab="notification-logs">Notification Logs</button>
                        <button class="tab-btn" data-tab="customer-activity">Customer Activity</button>
                    </div>
                </div>

                <!-- Transaction Reports Tab -->
                <div class="tab-content" id="transaction-reports">
                    <div class="table-container">
                        <table class="reports-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Plot Info</th>
                                    <th>Payment method</th>
                                    <th>Amount</th>
                                    <th>Date Paid</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Juan Dela Cruz</td>
                                    <td>Plot A3</td>
                                    <td>Cash</td>
                                    <td>2000</td>
                                    <td>May 14, 2025</td>
                                    <td><span class="status-badge status-paid">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>Maria Santos</td>
                                    <td>Plot B12</td>
                                    <td>GCash</td>
                                    <td>1500</td>
                                    <td>May 13, 2025</td>
                                    <td><span class="status-badge status-paid">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>Roberto Garcia</td>
                                    <td>Plot C8</td>
                                    <td>Bank Transfer</td>
                                    <td>2500</td>
                                    <td>May 12, 2025</td>
                                    <td><span class="status-badge status-paid">Paid</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Other Tab Contents (hidden initially) -->
                <div class="tab-content" id="plot-status" style="display: none;">
                    <div class="table-container">
                        <table class="reports-table">
                            <thead>
                                <tr>
                                    <th>Plot Number</th>
                                    <th>Status</th>
                                    <th>Customer</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Plot A1</td>
                                    <td><span class="status-badge status-paid">Occupied</span></td>
                                    <td>Maria Escobar</td>
                                    <td>May 10, 2025</td>
                                </tr>
                                <tr>
                                    <td>Plot A2</td>
                                    <td><span class="status-badge" style="background-color: rgba(34, 197, 94, 0.1); color: #059669;">Available</span></td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-content" id="notification-logs" style="display: none;">
                    <div class="table-container">
                        <table class="reports-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>May 14, 2025</td>
                                    <td>Juan Dela Cruz</td>
                                    <td>Payment Reminder</td>
                                    <td><span class="status-badge status-paid">Sent</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-content" id="customer-activity" style="display: none;">
                    <div class="table-container">
                        <table class="reports-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Activity</th>
                                    <th>Date</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Maria Santos</td>
                                    <td>Payment Made</td>
                                    <td>May 13, 2025</td>
                                    <td>Plot B12 - ₱1,500</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Charts Section -->
            <div class="charts-grid">
                <div class="chart-card">
                    <h3 class="chart-title">Monthly Payment Collections</h3>
                    <div class="chart-placeholder">graph</div>
                </div>
                <div class="chart-card">
                    <h3 class="chart-title">Plot Status Distribution</h3>
                    <div class="chart-placeholder">graph</div>
                </div>
                <div class="chart-card">
                    <h3 class="chart-title">Renewal Payment Collections</h3>
                    <div class="chart-placeholder">graph</div>
                </div>
                <div class="chart-card">
                    <h3 class="chart-title">Notification Sent</h3>
                    <div class="chart-placeholder">graph</div>
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
    <div class="overlay" id="overlay"></div>

    <script>
        // DOM Elements
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const userProfile = document.getElementById('userProfile');
        const userDropdown = document.getElementById('userDropdown');
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

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

        // Tab functionality
        function switchTab(tabId) {
            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
            });
            
            // Remove active class from all tab buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab content
            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.style.display = 'block';
            }
            
            // Add active class to clicked tab button
            const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }
        }

        // Event Listeners
        mobileMenuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', closeSidebar);
        userProfile.addEventListener('click', toggleDropdown);

        // Tab button event listeners
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                switchTab(tabId);
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!userProfile.contains(event.target)) {
                userDropdown.classList.remove('active');
            }
        });

        // Handle navigation links
        // Handle navigation links
        document.querySelectorAll('.nav-link').forEach(link => {
            // Only prevent default for the current active page
            if (link.classList.contains('active')) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            } else {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            }
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
        });

        // Update date every minute
        setInterval(updateDate, 60000);

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Close dropdown with Escape key
            if (e.key === 'Escape') {
                if (userDropdown.classList.contains('active')) {
                    userDropdown.classList.remove('active');
                }
                if (sidebar.classList.contains('active') && window.innerWidth <= 768) {
                    closeSidebar();
                }
            }
        });

        // Animate stat numbers on page load
        function animateStatNumbers() {
            const statNumbers = document.querySelectorAll('.stat-number');
            
            statNumbers.forEach(stat => {
                const finalNumber = parseInt(stat.textContent);
                let currentNumber = 0;
                const increment = finalNumber / 50; // Divide by 50 for smooth animation
                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= finalNumber) {
                        currentNumber = finalNumber;
                        clearInterval(timer);
                    }
                    stat.textContent = Math.floor(currentNumber);
                }, 20);
            });
        }

        // Initialize animations when page loads
        window.addEventListener('load', function() {
            setTimeout(animateStatNumbers, 500);
        });

        // Add hover effects to stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-5px) scale(1)';
            });
        });

        // Search functionality (basic filter for table)
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const activeTable = document.querySelector('.tab-content:not([style*="display: none"]) .reports-table tbody');
                
                if (activeTable) {
                    const rows = activeTable.querySelectorAll('tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            });
        }

        // Add loading states for chart placeholders
        function addLoadingEffect() {
            const chartPlaceholders = document.querySelectorAll('.chart-placeholder');
            chartPlaceholders.forEach(placeholder => {
                placeholder.style.background = 'linear-gradient(-45deg, rgba(139, 111, 77, 0.1), rgba(102, 72, 50, 0.05), rgba(139, 111, 77, 0.1), rgba(102, 72, 50, 0.05))';
                placeholder.style.backgroundSize = '400% 400%';
                placeholder.style.animation = 'shimmer 2s ease-in-out infinite';
            });
        }

        // Add shimmer animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shimmer {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
        `;
        document.head.appendChild(style);

        // Initialize loading effects
        addLoadingEffect();

        // Simulate chart loading
        setTimeout(() => {
            const chartPlaceholders = document.querySelectorAll('.chart-placeholder');
            chartPlaceholders.forEach(placeholder => {
                placeholder.style.animation = 'none';
                placeholder.innerHTML = '<div style="color: #8B6F4D; font-weight: 600;">Chart will be implemented here</div>';
            });
        }, 3000);

        // Add table row hover effects
        document.querySelectorAll('.reports-table tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(139, 111, 77, 0.08)';
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'all 0.3s ease';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = 'translateX(0)';
            });
        });

        // Print functionality (can be extended)
        function printReport() {
            window.print();
        }

        // Export functionality (placeholder)
        function exportToCSV() {
            const activeTable = document.querySelector('.tab-content:not([style*="display: none"]) .reports-table');
            if (activeTable) {
                // This would implement CSV export functionality
                console.log('Export to CSV functionality would be implemented here');
                alert('Export functionality will be implemented in the full version.');
            }
        }

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+P for print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printReport();
            }
            
            // Ctrl+E for export
            if (e.ctrlKey && e.key === 'e') {
                e.preventDefault();
                exportToCSV();
            }
        });

        // Auto-refresh data every 5 minutes (placeholder)
        setInterval(() => {
            console.log('Auto-refreshing data...');
            // This would fetch fresh data from the server
        }, 300000); // 5 minutes
    </script>
</body>
</html>