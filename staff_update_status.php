<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Plot Status - Rest Assured</title>
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

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 5px;
        }

        .page-subtitle {
            font-size: 14px;
            color: rgba(102, 72, 50, 0.7);
        }

        /* Plot Management Container */
        .plot-management-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        /* Plot Table Section */
        .plot-table-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #664832;
        }

        .filter-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-input {
            padding: 10px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            color: #664832;
            width: 250px;
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: rgba(102, 72, 50, 0.5);
        }

        .search-input:focus {
            outline: none;
            border-color: #664832;
            background-color: white;
        }

        .status-filter {
            padding: 10px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 10px;
            background-color: white;
            font-size: 14px;
            color: #664832;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-filter:focus {
            outline: none;
            border-color: #664832;
        }

        /* Table Styles */
        .plot-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .plot-table th {
            background-color: rgba(139, 111, 77, 0.1);
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: #664832;
            font-size: 14px;
            border-bottom: 2px solid rgba(139, 111, 77, 0.2);
        }

        .plot-table td {
            padding: 15px 12px;
            border-bottom: 1px solid rgba(139, 111, 77, 0.1);
            font-size: 14px;
            color: #3E2A1E;
        }

        .plot-table tr:hover {
            background-color: rgba(139, 111, 77, 0.05);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-occupied {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-available {
            background-color: #e8f5e8;
            color: #2e7d32;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #f57c00;
        }

        .status-expired {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .update-btn {
            background-color: #8B6F4D;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .update-btn:hover {
            background-color: #664832;
            transform: translateY(-1px);
        }

        /* Update Form Section */
        .update-form-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.1);
            border: 1px solid rgba(139, 111, 77, 0.1);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #664832;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            color: #664832;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #664832;
            background-color: white;
        }

        .form-select {
            cursor: pointer;
        }

        .save-btn {
            width: 100%;
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.3);
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

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #664832;
            font-size: 20px;
            cursor: pointer;
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .plot-management-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .update-form-section {
                position: static;
            }
        }

        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }

            .filter-controls {
                flex-wrap: wrap;
                gap: 10px;
            }

            .search-input {
                width: 200px;
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

            .plot-table-section,
            .update-form-section {
                padding: 20px;
            }

            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input {
                width: 100%;
            }

            .plot-table {
                font-size: 12px;
            }

            .plot-table th,
            .plot-table td {
                padding: 10px 8px;
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

            .page-title {
                font-size: 24px;
            }

            .plot-table {
                overflow-x: auto;
                display: block;
                white-space: nowrap;
            }

            .plot-table thead,
            .plot-table tbody,
            .plot-table th,
            .plot-table td,
            .plot-table tr {
                display: block;
            }

            .plot-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .plot-table tr {
                border: 1px solid rgba(139, 111, 77, 0.2);
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 8px;
                background: white;
            }

            .plot-table td {
                border: none;
                position: relative;
                padding-left: 30%;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .plot-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 6px;
                width: 25%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: 600;
                color: #664832;
            }
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
                <h2 class="sidebar-title">Upload Plot Status</h2>
                <p class="sidebar-date">Thursday, 2 May 2025</p>
            </div>
            
            <nav>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="staff_dashboard.php" class="nav-link">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="staff_update_status.php" class="nav-link active">
                            <span class="nav-icon">⚱️</span>
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
                <h1 class="page-title">Update Plot Status</h1>
                <p class="page-subtitle">Manage and update burial plot information and status</p>
            </div>

            <!-- Plot Management Container -->
            <div class="plot-management-container">
                <!-- Plot Table Section -->
                <div class="plot-table-section">
                    <div class="section-header">
                        <h2 class="section-title">Plot Information</h2>
                        <div class="filter-controls">
                            <input type="text" class="search-input" placeholder="Search Plot ID or Deceased Name" id="searchInput">
                            <select class="status-filter" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="occupied">Occupied</option>
                                <option value="available">Available</option>
                                <option value="pending">Pending</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                    </div>

                    <table class="plot-table">
                        <thead>
                            <tr>
                                <th>Plot ID</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Assigned Deceased</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="plotTableBody">
                            <tr>
                                <td data-label="Plot ID">A001</td>
                                <td data-label="Location">Block A</td>
                                <td data-label="Status"><span class="status-badge status-occupied">Occupied</span></td>
                                <td data-label="Assigned Deceased">Juanito Escobar</td>
                                <td data-label="Action">
                                    <button class="update-btn" onclick="selectPlot('A001', 'Block A', 'Juanito Escobar', 'occupied')">Update</button>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Plot ID">B-205</td>
                                <td data-label="Location">Block B</td>
                                <td data-label="Status"><span class="status-badge status-available">Available</span></td>
                                <td data-label="Assigned Deceased">-</td>
                                <td data-label="Action">
                                    <button class="update-btn" onclick="selectPlot('B-205', 'Block B', '', 'available')">Update</button>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Plot ID">C-150</td>
                                <td data-label="Location">Block C</td>
                                <td data-label="Status"><span class="status-badge status-pending">Pending</span></td>
                                <td data-label="Assigned Deceased">Maria Santos</td>
                                <td data-label="Action">
                                    <button class="update-btn" onclick="selectPlot('C-150', 'Block C', 'Maria Santos', 'pending')">Update</button>
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Plot ID">D-089</td>
                                <td data-label="Location">Block D</td>
                                <td data-label="Status"><span class="status-badge status-expired">Expired</span></td>
                                <td data-label="Assigned Deceased">Pedro Cruz</td>
                                <td data-label="Action">
                                    <button class="update-btn" onclick="selectPlot('D-089', 'Block D', 'Pedro Cruz', 'expired')">Update</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Update Form Section -->
                <div class="update-form-section">
                    <h2 class="section-title">Update Plot Status</h2>
                    
                    <form id="updatePlotForm">
                        <div class="form-group">
                            <label class="form-label" for="plotId">Plot ID</label>
                            <input type="text" class="form-input" id="plotId" placeholder="Select a plot to update" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="location">Location</label>
                            <select class="form-select" id="location">
                                <option value="">Select Location</option>
                                <option value="Block A">Block A</option>
                                <option value="Block B">Block B</option>
                                <option value="Block C">Block C</option>
                                <option value="Block D">Block D</option>
                                <option value="Block E">Block E</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="assignedDeceased">Assigned Deceased</label>
                            <input type="text" class="form-input" id="assignedDeceased" placeholder="Enter deceased name">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="currentStatus">Current Status</label>
                            <select class="form-select" id="currentStatus">
                                <option value="">Select Status</option>
                                <option value="occupied">Occupied</option>
                                <option value="available">Available</option>
                                <option value="pending">Pending</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>

                        <button type="submit" class="save-btn">Save Changes</button>
                    </form>
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

        // Sidebar toggle for mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }

        // Close sidebar
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }

        // Close sidebar when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        // Select plot for updating
        function selectPlot(plotId, location, deceased, status) {
            document.getElementById('plotId').value = plotId;
            document.getElementById('location').value = location;
            document.getElementById('assignedDeceased').value = deceased;
            document.getElementById('currentStatus').value = status;
        }

        // Search functionality
        function filterTable() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const statusValue = document.getElementById('statusFilter').value.toLowerCase();
            const tbody = document.getElementById('plotTableBody');
            const rows = tbody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const plotId = row.cells[0].textContent.toLowerCase();
                const deceased = row.cells[3].textContent.toLowerCase();
                const statusCell = row.cells[2].querySelector('.status-badge');
                const status = statusCell ? statusCell.textContent.toLowerCase() : '';

                const matchesSearch = plotId.includes(searchValue) || deceased.includes(searchValue);
                const matchesStatus = statusValue === '' || status.includes(statusValue);

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        // Add search event listeners
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);

        // Form submission
        document.getElementById('updatePlotForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const plotId = document.getElementById('plotId').value;
            const location = document.getElementById('location').value;
            const assignedDeceased = document.getElementById('assignedDeceased').value;
            const currentStatus = document.getElementById('currentStatus').value;

            if (!plotId) {
                alert('Please select a plot to update');
                return;
            }

            if (!location || !currentStatus) {
                alert('Please fill in all required fields');
                return;
            }

            // Here you would normally send the data to your server
            console.log('Updating plot:', {
                plotId: plotId,
                location: location,
                assignedDeceased: assignedDeceased,
                currentStatus: currentStatus
            });

            // Update the table row
            updateTableRow(plotId, location, assignedDeceased, currentStatus);
            
            alert('Plot status updated successfully!');
            
            // Clear the form
            document.getElementById('updatePlotForm').reset();
        });

        // Update table row function
        function updateTableRow(plotId, location, deceased, status) {
            const tbody = document.getElementById('plotTableBody');
            const rows = tbody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                if (row.cells[0].textContent === plotId) {
                    row.cells[1].textContent = location;
                    row.cells[3].textContent = deceased || '-';
                    
                    // Update status badge
                    const statusBadge = row.cells[2].querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        statusBadge.className = `status-badge status-${status}`;
                    }
                    
                    // Update the onclick function for the update button
                    const updateBtn = row.cells[4].querySelector('.update-btn');
                    if (updateBtn) {
                        updateBtn.onclick = function() {
                            selectPlot(plotId, location, deceased, status);
                        };
                    }
                    break;
                }
            }
        }

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

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Set current date in sidebar
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const currentDate = now.toLocaleDateString('en-US', options);
            
            const sidebarDate = document.querySelector('.sidebar-date');
            if (sidebarDate) {
                sidebarDate.textContent = currentDate;
            }
        });

    </script>

</body>
</html>