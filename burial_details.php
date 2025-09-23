<?php
// burial_details.php
session_start();

// Sample user data (in a real application, this would come from a database)
$user = [
    'name' => 'Maria Clara',
    'initials' => 'MC'
];

// Handle form submission
$deceased_data = [];
$plot_data = [];

if ($_POST['submit'] ?? false) {
    // Process deceased information
    $deceased_data = [
        'full_name' => $_POST['full_name'] ?? '',
        'date_of_birth' => $_POST['date_of_birth'] ?? '',
        'date_of_death' => $_POST['date_of_death'] ?? '',
        'cause_of_death' => $_POST['cause_of_death'] ?? '',
        'relationship' => $_POST['relationship'] ?? '',
        'contact_person' => $_POST['contact_person'] ?? ''
    ];
    
    // Process plot information
    $plot_data = [
        'plot_code' => $_POST['plot_code'] ?? '',
        'block' => $_POST['block'] ?? '',
        'lot_number' => $_POST['lot_number'] ?? '',
        'plot_status' => $_POST['plot_status'] ?? '',
        'burial_date' => $_POST['burial_date'] ?? ''
    ];
    
    // In a real application, you would save this data to a database
}

$current_date = date('l, j M Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burial Details - Rest Assured</title>
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

        /* Tab Navigation */
        .tab-navigation {
            display: flex;
            margin-bottom: 30px;
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 15px;
            padding: 5px;
            box-shadow: 0 2px 10px rgba(102, 72, 50, 0.1);
        }

        .tab-button {
            flex: 1;
            padding: 15px 25px;
            background: none;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            color: #664832;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background-color: rgba(139, 111, 77, 0.2);
            color: #3E2A1E;
            font-weight: 600;
        }

        .tab-button:hover {
            background-color: rgba(139, 111, 77, 0.1);
        }

        /* Form Container */
        .form-container {
            background-color: rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(139, 111, 77, 0.2);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #664832;
            margin-bottom: 8px;
        }

        .form-input {
            padding: 12px 20px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 10px;
            font-size: 14px;
            color: #664832;
            background-color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #8B6F4D;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(139, 111, 77, 0.1);
        }

        .form-input:disabled {
            background-color: rgba(139, 111, 77, 0.05);
            color: rgba(102, 72, 50, 0.6);
            cursor: not-allowed;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Action Buttons */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding-top: 30px;
            border-top: 1px solid rgba(139, 111, 77, 0.2);
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #664832, #3E2A1E);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.3);
        }

        .btn-secondary {
            background: rgba(139, 111, 77, 0.1);
            color: #664832;
            border: 2px solid rgba(139, 111, 77, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(139, 111, 77, 0.2);
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
        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }

            .form-grid {
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

            .form-container {
                padding: 30px 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .tab-navigation {
                flex-direction: column;
                gap: 5px;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
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

            .form-container {
                padding: 25px 20px;
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
                <h2 class="sidebar-title">Burial Details</h2>
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
                        <a href="customer_grave_locator.php" class="nav-link">
                            <span class="nav-icon">📍</span>
                            Grave Locator
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="burial_details.php" class="nav-link active">
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
            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-button" onclick="switchTab('deceased')" id="deceasedTab">
                    Deceased Information
                </button>
                <button class="tab-button active" onclick="switchTab('plot')" id="plotTab">
                    Plot Information
                </button>
            </div>

            <form method="POST" action="">
                <!-- Deceased Information Tab -->
                <div class="tab-content" id="deceasedContent">
                    <div class="form-container">
                        <div class="form-section">
                            <h3 class="section-title">Personal Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-input" 
                                           value="<?php echo htmlspecialchars($deceased_data['full_name'] ?? ''); ?>" 
                                           placeholder="Enter full name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-input" 
                                           value="<?php echo htmlspecialchars($deceased_data['date_of_birth'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date of Death</label>
                                    <input type="date" name="date_of_death" class="form-input" 
                                           value="<?php echo htmlspecialchars($deceased_data['date_of_death'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Cause of Death</label>
                                    <input type="text" name="cause_of_death" class="form-input" 
                                           value="<?php echo htmlspecialchars($deceased_data['cause_of_death'] ?? ''); ?>" 
                                           placeholder="Enter cause of death">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="section-title">Contact Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Relationship to Deceased</label>
                                    <select name="relationship" class="form-input">
                                        <option value="">Select relationship</option>
                                        <option value="spouse" <?php echo ($deceased_data['relationship'] ?? '') === 'spouse' ? 'selected' : ''; ?>>Spouse</option>
                                        <option value="child" <?php echo ($deceased_data['relationship'] ?? '') === 'child' ? 'selected' : ''; ?>>Child</option>
                                        <option value="parent" <?php echo ($deceased_data['relationship'] ?? '') === 'parent' ? 'selected' : ''; ?>>Parent</option>
                                        <option value="sibling" <?php echo ($deceased_data['relationship'] ?? '') === 'sibling' ? 'selected' : ''; ?>>Sibling</option>
                                        <option value="other" <?php echo ($deceased_data['relationship'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" name="contact_person" class="form-input" 
                                           value="<?php echo htmlspecialchars($deceased_data['contact_person'] ?? ''); ?>" 
                                           placeholder="Enter contact person name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plot Information Tab -->
                <div class="tab-content active" id="plotContent">
                    <div class="form-container">
                        <div class="form-section">
                            <h3 class="section-title">Plot Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Plot Code:</label>
                                    <input type="text" name="plot_code" class="form-input" 
                                           value="<?php echo htmlspecialchars($plot_data['plot_code'] ?? ''); ?>" 
                                           placeholder="Enter plot code">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Block:</label>
                                    <input type="text" name="block" class="form-input" 
                                           value="<?php echo htmlspecialchars($plot_data['block'] ?? ''); ?>" 
                                           placeholder="Enter block">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Lot Number:</label>
                                    <input type="text" name="lot_number" class="form-input" 
                                           value="<?php echo htmlspecialchars($plot_data['lot_number'] ?? ''); ?>" 
                                           placeholder="Enter lot number">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Plot Status:</label>
                                    <select name="plot_status" class="form-input">
                                        <option value="">Select status</option>
                                        <option value="available" <?php echo ($plot_data['plot_status'] ?? '') === 'available' ? 'selected' : ''; ?>>Available</option>
                                        <option value="occupied" <?php echo ($plot_data['plot_status'] ?? '') === 'occupied' ? 'selected' : ''; ?>>Occupied</option>
                                        <option value="reserved" <?php echo ($plot_data['plot_status'] ?? '') === 'reserved' ? 'selected' : ''; ?>>Reserved</option>
                                        <option value="maintenance" <?php echo ($plot_data['plot_status'] ?? '') === 'maintenance' ? 'selected' : ''; ?>>Under Maintenance</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Burial Date:</label>
                                    <input type="date" name="burial_date" class="form-input" 
                                           value="<?php echo htmlspecialchars($plot_data['burial_date'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary">Cancel</button>
                            <button type="submit" name="submit" class="btn btn-primary">Save Details</button>
                        </div>
                    </div>
                </div>
            </form>
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

    // Switch between tabs
    function switchTab(tabName) {
        document.querySelectorAll('.tab-button').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        document.getElementById(tabName + 'Tab').classList.add('active');
        document.getElementById(tabName + 'Content').classList.add('active');
    }

    // ✅ Fixed: Handle navigation links (highlight active link)
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split("/").pop();
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const linkPage = link.getAttribute('href');
            
            // Highlight active link based on URL
            if (linkPage === currentPage) {
                link.classList.add('active');
            }

            // Close sidebar on mobile when clicking a link
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