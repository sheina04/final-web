<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Rest Assured</title>
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

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-section {
            background-color: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 10px;
        }

        .section-subtitle {
            font-size: 14px;
            color: rgba(102, 72, 50, 0.6);
            margin-bottom: 20px;
        }

        .profile-picture-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-picture {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B6F4D, #664832);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(102, 72, 50, 0.2);
        }

        .picture-info {
            flex: 1;
        }

        .picture-title {
            font-weight: 600;
            color: #664832;
            margin-bottom: 5px;
        }

        .picture-subtitle {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.6);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 8px;
        }

        .form-input {
            padding: 12px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 8px;
            font-size: 14px;
            color: #664832;
            background-color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #8B6F4D;
            background-color: white;
        }

        .form-input:read-only {
            background-color: rgba(139, 111, 77, 0.1);
            color: rgba(102, 72, 50, 0.8);
        }

        .form-select {
            padding: 12px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 8px;
            font-size: 14px;
            color: #664832;
            background-color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #8B6F4D;
            background-color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-secondary {
            background-color: rgba(139, 111, 77, 0.2);
            color: #664832;
        }

        .btn-secondary:hover {
            background-color: rgba(139, 111, 77, 0.3);
        }

        .btn-primary {
            background-color: #8B6F4D;
            color: white;
        }

        .btn-primary:hover {
            background-color: #664832;
        }

        .btn-edit {
            background-color: #8B6F4D;
            color: white;
            padding: 10px 25px;
            font-size: 13px;
        }

        .btn-edit:hover {
            background-color: #664832;
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

        /* Tablet and Mobile Responsive */
        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }

            .form-grid {
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

            .profile-section {
                padding: 25px;
                margin-bottom: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .profile-picture-section {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
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

            .profile-section {
                padding: 20px;
            }

            .user-name {
                display: none;
            }

            .profile-picture {
                width: 60px;
                height: 60px;
                font-size: 20px;
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
                <div class="user-avatar">MC</div>
                <span class="user-name">Maria Clara</span>
                <span class="dropdown-arrow">▼</span>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="customer_profile.php" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Help & Support</h2>
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
            <div class="profile-container">
                
                <!-- Basic Information Section -->
                <section class="profile-section">
                    <div class="section-header">
                        <div>
                            <h2 class="section-title">Basic Information</h2>
                            <p class="section-subtitle">Profile picture</p>
                        </div>
                    </div>
                    
                    <div class="profile-picture-section">
                        <div class="profile-picture">MC</div>
                        <div class="picture-info">
                            <div class="picture-title">A profile picture helps personalize your account</div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-input" value="Maria Clara Escobar" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <input type="text" class="form-input" value="Female" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Relationship to Deceased</label>
                            <select class="form-select" disabled>
                                <option>Daughter</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Home Address</label>
                            <input type="text" class="form-input" value="Brgy. Kalubihan, Cebu City" readonly>
                        </div>
                    </div>
                </section>

                <!-- Contact Information Section -->
                <section class="profile-section">
                    <div class="section-header">
                        <div>
                            <h2 class="section-title">Contact Information</h2>
                        </div>
                        <button class="btn btn-edit" onclick="toggleEdit()">Edit Information</button>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" value="maria.clara@gmail.com" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Phone number</label>
                            <input type="tel" class="form-input" value="09193210292" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Preferred Notification Method</label>
                            <select class="form-select" disabled>
                                <option>Email</option>
                                <option>SMS</option>
                                <option>Both</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">How do you want to receive notification?</label>
                            <input type="text" class="form-input" value="Email" readonly>
                        </div>
                    </div>

                    <div class="action-buttons" id="actionButtons" style="display: none;">
                        <button class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                        <button class="btn btn-primary" onclick="saveChanges()">Save</button>
                    </div>
                </section>

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
        let isEditing = false;

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
        }

        // Close mobile sidebar
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }

        // Toggle edit mode
        function toggleEdit() {
            isEditing = !isEditing;
            const inputs = document.querySelectorAll('.form-input, .form-select');
            const actionButtons = document.getElementById('actionButtons');
            const editButton = document.querySelector('.btn-edit');

            inputs.forEach(input => {
                if (input.closest('.profile-section').querySelector('.section-title').textContent === 'Contact Information') {
                    if (isEditing) {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    } else {
                        input.setAttribute('readonly', true);
                        input.setAttribute('disabled', true);
                    }
                }
            });

            if (isEditing) {
                actionButtons.style.display = 'flex';
                editButton.style.display = 'none';
            } else {
                actionButtons.style.display = 'none';
                editButton.style.display = 'inline-block';
            }
        }

        // Cancel edit
        function cancelEdit() {
            // Reset form values here if needed
            toggleEdit();
        }

        // Save changes
        function saveChanges() {
            // Add save logic here
            console.log('Saving changes...');
            toggleEdit();
            
            // Show success message (you can customize this)
            alert('Profile updated successfully!');
        }

        // Handle navigation links
        document.querySelectorAll('.nav-link').forEach(link => {
            // Only prevent default for the current active page
            if (link.classList.contains('active')) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Close mobile sidebar if open
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            } else {
                // Allow normal navigation for other links
                link.addEventListener('click', function(e) {
                    // Close mobile sidebar if open
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                    // Let the browser handle the navigation normally
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
    </script>
</body>
</html>