<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Management - Rest Assured Admin</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .compose-btn {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .compose-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.3);
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

        /* Notifications Section */
        .notifications-section {
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

        /* Notifications Table */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .notifications-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 800px;
        }

        .notifications-table th {
            background-color: rgba(139, 111, 77, 0.1);
            color: #664832;
            font-weight: 600;
            padding: 15px 12px;
            text-align: left;
            font-size: 14px;
            border-bottom: 2px solid rgba(102, 72, 50, 0.1);
        }

        .notifications-table td {
            padding: 15px 12px;
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
            color: #3E2A1E;
            font-size: 14px;
            vertical-align: middle;
        }

        .notifications-table tr:hover {
            background-color: rgba(139, 111, 77, 0.05);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-sent {
            background-color: rgba(34, 197, 94, 0.1);
            color: #059669;
        }

        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            color: #d97706;
        }

        .status-urgent {
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .status-overdue {
            background-color: rgba(239, 68, 68, 0.15);
            color: #b91c1c;
        }

        .days-left {
            font-weight: 600;
        }

        .days-critical {
            color: #dc2626;
        }

        .days-warning {
            color: #d97706;
        }

        .days-normal {
            color: #059669;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }

        .btn-edit:hover {
            background-color: rgba(59, 130, 246, 0.2);
        }

        .btn-delete {
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .btn-delete:hover {
            background-color: rgba(239, 68, 68, 0.2);
        }

        .btn-send {
            background-color: rgba(34, 197, 94, 0.1);
            color: #059669;
        }

        .btn-send:hover {
            background-color: rgba(34, 197, 94, 0.2);
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

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-number {
                font-size: 36px;
            }

            .notifications-section {
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

            .notifications-section {
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
                <input type="text" class="search-box" placeholder="Search notifications...">
                <span class="search-icon">🔍</span>
            </div>
            
            <button class="notification-btn">🔔</button>
            
            <div class="user-profile" id="userProfile">
                <div class="user-avatar">S</div>
                <span class="user-name">Staff</span>
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
                <h2 class="sidebar-title">Notification Management</h2>
                <p class="sidebar-date">Thursday, 7 May 2025</p>
            </div>
            
            <nav>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="staff_dahsboard.php" class="nav-link">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="staff_update_status.php" class="nav-link">
                            <span class="nav-icon">📍</span>
                            Update Status
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
                <div>
                    <h1 class="page-title">Notification Management</h1>
                    <p class="page-subtitle">Manage and send notifications to customers</p>
                </div>
                <button class="compose-btn">
                    ✉️ Compose
                </button>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">127</div>
                    <div class="stat-label">Total Notifications</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">85</div>
                    <div class="stat-label">Sent Today</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">42</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">23</div>
                    <div class="stat-label">Urgent</div>
                </div>
            </div>

            <!-- Notifications Section -->
            <section class="notifications-section">
                <div class="section-header">
                    <h2 class="section-title">Notifications</h2>
                    
                    <!-- Tab Navigation -->
                    <div class="tab-nav">
                        <button class="tab-btn active" data-tab="primary">Primary</button>
                        <button class="tab-btn" data-tab="renewal">Renewal</button>
                        <button class="tab-btn" data-tab="events">Events</button>
                    </div>
                </div>

                <!-- Primary Notifications Tab -->
                <div class="tab-content" id="primary">
                    <div class="table-container">
                        <table class="notifications-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Notification Type</th>
                                    <th>Recipient Name</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Sent Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td>Payment Confirmation</td>
                                    <td>Maria Clara Escobar</td>
                                    <td>09123456789</td>
                                    <td><span class="status-badge status-sent">Sent</span></td>
                                    <td>11/11/2025</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>002</td>
                                    <td>Welcome Message</td>
                                    <td>Juan Santos</td>
                                    <td>09198765432</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>-</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-send">📤</button>
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>003</td>
                                    <td>Contract Update</td>
                                    <td>Rosa Garcia</td>
                                    <td>09156789123</td>
                                    <td><span class="status-badge status-sent">Sent</span></td>
                                    <td>11/10/2025</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Renewal Notifications Tab -->
                <div class="tab-content" id="renewal" style="display: none;">
                    <div class="table-container">
                        <table class="notifications-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Grave Plot</th>
                                    <th>Renewal Expiration</th>
                                    <th>Days Left</th>
                                    <th>Status</th>
                                    <th>Sent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Maria Clara Escobar</td>
                                    <td>Plot A-15</td>
                                    <td>December 25, 2025</td>
                                    <td><span class="days-left days-warning">48 days</span></td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>Not Sent</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-send">📤</button>
                                            <button class="action-btn btn-edit">✏️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Roberto Dela Cruz</td>
                                    <td>Plot B-08</td>
                                    <td>November 30, 2025</td>
                                    <td><span class="days-left days-critical">23 days</span></td>
                                    <td><span class="status-badge status-urgent">Urgent</span></td>
                                    <td>11/05/2025</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-send">📤</button>
                                            <button class="action-btn btn-edit">✏️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Carmen Lopez</td>
                                    <td>Plot C-22</td>
                                    <td>October 15, 2025</td>
                                    <td><span class="days-left days-critical">Overdue</span></td>
                                    <td><span class="status-badge status-overdue">Overdue</span></td>
                                    <td>10/10/2025</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-send">📤</button>
                                            <button class="action-btn btn-edit">✏️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Antonio Reyes</td>
                                    <td>Plot D-05</td>
                                    <td>February 14, 2026</td>
                                    <td><span class="days-left days-normal">95 days</span></td>
                                    <td><span class="status-badge status-sent">Sent</span></td>
                                    <td>11/01/2025</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-edit">✏️</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Events Notifications Tab -->
                <div class="tab-content" id="events" style="display: none;">
                    <div class="table-container">
                        <table class="notifications-table">
                            <thead>
                                <tr>
                                    <th>Deceased Name</th>
                                    <th>Occasion</th>
                                    <th>Plot Number</th>
                                    <th>Family Contact</th>
                                    <th>Renewal Due</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Pedro Escobar</td>
                                    <td>Death Anniversary</td>
                                    <td>Plot A-15</td>
                                    <td>Maria Clara Escobar<br><small>09123456789</small></td>
                                    <td>Dec 25, 2025</td>
                                    <td><span class="status-badge status-sent">Sent</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Carmen Dela Cruz</td>
                                    <td>Birthday</td>
                                    <td>Plot B-08</td>
                                    <td>Roberto Dela Cruz<br><small>09198765432</small></td>
                                    <td>Nov 30, 2025</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-send">📤</button>
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Manuel Lopez</td>
                                    <td>All Souls Day</td>
                                    <td>Plot C-22</td>
                                    <td>Carmen Lopez<br><small>09156789123</small></td>
                                    <td>Oct 15, 2025</td>
                                    <td><span class="status-badge status-sent">Sent</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Esperanza Reyes</td>
                                    <td>Death Anniversary</td>
                                    <td>Plot D-05</td>
                                    <td>Antonio Reyes<br><small>09123789456</small></td>
                                    <td>Feb 14, 2026</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-send">📤</button>
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jose Santos</td>
                                    <td>All Saints Day</td>
                                    <td>Plot E-12</td>
                                    <td>Juan Santos<br><small>09198765432</small></td>
                                    <td>Jan 15, 2026</td>
                                    <td><span class="status-badge status-sent">Sent</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-edit">✏️</button>
                                            <button class="action-btn btn-delete">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
        tabContents.forEach(content => {
            content.style.display = 'none';
        });
        tabButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        const selectedTab = document.getElementById(tabId);
        if (selectedTab) {
            selectedTab.style.display = 'block';
        }
        const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
    }

    // Event Listeners
    mobileMenuToggle.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', closeSidebar);
    userProfile.addEventListener('click', toggleDropdown);

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

    // ✅ FIXED: Handle navigation links properly
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all links
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));

            // Add active class to clicked link
            this.classList.add('active');

            // Redirect to page
            const targetPage = this.getAttribute('href');
            if (targetPage) {
                window.location.href = targetPage;
            }

            // Close mobile sidebar
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

    document.addEventListener('DOMContentLoaded', function() {
        updateDate();
    });

    setInterval(updateDate, 60000);

        // Initialize date on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
        });

        // Update date every minute
        setInterval(updateDate, 60000);

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
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
                const increment = finalNumber / 50;
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

        // Search functionality
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const activeTable = document.querySelector('.tab-content:not([style*="display: none"]) .notifications-table tbody');
                
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

        // Action button handlers
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-send')) {
                const row = e.target.closest('tr');
                const name = row.cells[0].textContent;
                if (confirm(`Send notification to ${name}?`)) {
                    // Simulate sending
                    setTimeout(() => {
                        alert('Notification sent successfully!');
                        // Update UI to show sent status
                        const statusCell = row.querySelector('.status-badge');
                        if (statusCell) {
                            statusCell.textContent = 'Sent';
                            statusCell.className = 'status-badge status-sent';
                        }
                    }, 1000);
                }
            }
            
            if (e.target.classList.contains('btn-edit')) {
                const row = e.target.closest('tr');
                const name = row.cells[0].textContent;
                alert(`Edit notification for ${name} - Feature will be implemented`);
            }
            
            if (e.target.classList.contains('btn-delete')) {
                const row = e.target.closest('tr');
                const name = row.cells[0].textContent;
                if (confirm(`Delete notification for ${name}?`)) {
                    row.remove();
                    alert('Notification deleted successfully!');
                }
            }
        });

        // Compose button handler
        document.querySelector('.compose-btn').addEventListener('click', function() {
            alert('Compose new notification - Feature will be implemented');
        });

        // Add table row hover effects
        document.querySelectorAll('.notifications-table tbody tr').forEach(row => {
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

        // Auto-refresh notifications every 30 seconds (placeholder)
        setInterval(() => {
            console.log('Auto-refreshing notifications...');
            // This would fetch fresh data from the server
        }, 30000);

        // Mark urgent notifications
        function checkUrgentNotifications() {
            const renewalRows = document.querySelectorAll('#renewal tbody tr');
            renewalRows.forEach(row => {
                const daysLeftCell = row.querySelector('.days-left');
                if (daysLeftCell) {
                    const text = daysLeftCell.textContent.toLowerCase();
                    if (text.includes('overdue')) {
                        row.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
                        row.style.borderLeft = '4px solid #dc2626';
                    } else if (text.includes('critical') || parseInt(text) <= 30) {
                        row.style.backgroundColor = 'rgba(251, 191, 36, 0.05)';
                        row.style.borderLeft = '4px solid #d97706';
                    }
                }
            });
        }

        // Initialize urgent notification checking
        setTimeout(checkUrgentNotifications, 1000);
    </script>
</body>
</html>