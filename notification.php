<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Rest Assured</title>
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

        .notifications-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            margin-bottom: 40px;
        }

        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
        }

        .notifications-title {
            font-size: 28px;
            color: #664832;
            font-weight: 600;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: transparent;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 25px;
            color: #664832;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background-color: rgba(139, 111, 77, 0.1);
            border-color: #8B6F4D;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
            transition: all 0.3s ease;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background-color: rgba(255, 242, 225, 0.3);
            margin: 0 -15px;
            padding: 20px 15px;
            border-radius: 10px;
        }

        .notification-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #8B6F4D;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-size: 16px;
            font-weight: 600;
            color: #3E2A1E;
            margin-bottom: 5px;
        }

        .notification-description {
            font-size: 14px;
            color: rgba(102, 72, 50, 0.8);
            line-height: 1.5;
        }

        .notification-time {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.6);
            font-style: italic;
            margin-top: 5px;
        }

        .notification-date {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.6);
            font-style: italic;
            flex-shrink: 0;
            align-self: flex-start;
        }

        /* Detailed Notification View */
        .detailed-notification {
            display: none;
        }

        .detailed-notification.active {
            display: block;
        }

        .notification-detail-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
        }

        .back-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #8B6F4D;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #664832;
            transform: scale(1.05);
        }

        .detail-title {
            font-size: 24px;
            color: #664832;
            font-weight: 600;
            margin: 0;
        }

        .sender-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .sender-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #8B6F4D;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .sender-details {
            flex: 1;
        }

        .sender-name {
            font-size: 16px;
            font-weight: 600;
            color: #3E2A1E;
            margin-bottom: 2px;
        }

        .sender-email {
            font-size: 14px;
            color: rgba(102, 72, 50, 0.7);
        }

        .recipient-info {
            font-size: 14px;
            color: rgba(102, 72, 50, 0.7);
            margin-bottom: 5px;
        }

        .notification-timestamp {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.6);
            text-align: right;
        }

        .message-content {
            line-height: 1.7;
            color: #3E2A1E;
            font-size: 15px;
        }

        .message-content p {
            margin-bottom: 15px;
        }

        .message-signature {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(102, 72, 50, 0.1);
            font-style: italic;
            color: rgba(102, 72, 50, 0.8);
        }

        /* Empty State Styles */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(102, 72, 50, 0.6);
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            color: rgba(102, 72, 50, 0.8);
            margin-bottom: 10px;
        }

        .empty-message {
            font-size: 14px;
            line-height: 1.6;
            max-width: 400px;
            margin: 0 auto;
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

            .notifications-section {
                padding: 25px 20px;
            }

            .notifications-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .notification-item {
                gap: 15px;
            }

            .notification-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
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

            .notifications-section {
                padding: 20px 15px;
            }

            .user-name {
                display: none;
            }

            .notification-item {
                flex-direction: column;
                gap: 10px;
            }

            .notification-date {
                align-self: flex-end;
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
                <h2 class="sidebar-title">Notification</h2>
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
                        <a href="notification.php" class="nav-link active">
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
            <!-- Notifications Section -->
            <section class="notifications-section">
                <!-- Notifications List View -->
                <div class="notifications-list-view" id="notificationsList">
                    <div class="notifications-header">
                        <h1 class="notifications-title">Your notifications</h1>
                        <button class="filter-btn">
                            <span>Filter</span>
                            <span>⚙️</span>
                        </button>
                    </div>

                    <!-- Notification Items -->
                    <div class="notifications-list" id="notificationsContainer">
                        <!-- Notifications will be dynamically loaded here -->
                    </div>
                </div>

                <!-- Detailed Notification View -->
                <div class="detailed-notification" id="notificationDetail">
                    <div class="notification-detail-header">
                        <button class="back-button" onclick="showNotificationsList()">←</button>
                        <h2 class="detail-title" id="detailTitle">Pending Renewal Notification</h2>
                    </div>

                    <div class="sender-info">
                        <div class="sender-avatar" id="senderAvatar">A</div>
                        <div class="sender-details">
                            <div class="sender-name" id="senderName">Admin</div>
                            <div class="sender-email" id="senderEmail">&lt;cemetery.admin@gmail.com&gt;</div>
                            <div class="recipient-info">to me</div>
                        </div>
                        <div class="notification-timestamp" id="notificationTimestamp">Apr 19, 2025, 9:15 AM</div>
                    </div>

                    <div class="message-content" id="messageContent">
                        <p>Hi Escobar,</p>
                        <p>This is a kind reminder that the grave plot for your loved one, Juanito Escobar, located at B12-L05, is due for renewal on April 25, 2025.</p>
                        <p>Kindly settle the renewal fee before the due date to ensure continued reservation.</p>
                        <p>Thank you for your attention.</p>
                        <div class="message-signature">
                            – Rest Assured Cemetery Admin
                        </div>
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

    // ✅ Fixed sidebar navigation links
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split("/").pop();
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const linkPage = link.getAttribute('href');

            // Highlight the active link
            if (linkPage === currentPage) {
                link.classList.add('active');
            }

            // Mobile: auto-close sidebar when link clicked
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });

        updateDate(); 
        loadNotifications(); // Load notifications from server/database
    });

    // Notifications related code (unchanged)
    function loadNotifications() {
        const container = document.getElementById('notificationsContainer');
        const notifications = []; // Replace with API response

        if (notifications.length === 0) {
            showEmptyState();
        } else {
            renderNotifications(notifications);
        }
    }

    function showEmptyState() {
        const container = document.getElementById('notificationsContainer');
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">🔔</div>
                <div class="empty-title">No notifications yet</div>
                <div class="empty-message">
                    You don't have any notifications at the moment. 
                    When you receive updates about renewals, payments, or other important information, 
                    they will appear here.
                </div>
            </div>
        `;
    }

    function renderNotifications(notifications) {
        const container = document.getElementById('notificationsContainer');
        container.innerHTML = '';
        
        notifications.forEach(notification => {
            const notificationElement = createNotificationElement(notification);
            container.appendChild(notificationElement);
        });
    }

    function createNotificationElement(notification) {
        const div = document.createElement('div');
        div.className = 'notification-item';
        div.onclick = () => showNotificationDetail(notification.type);
        
        div.innerHTML = `
            <div class="notification-icon">${notification.icon}</div>
            <div class="notification-content">
                <div class="notification-title">${notification.title}</div>
                <div class="notification-description">${notification.description}</div>
            </div>
            <div class="notification-date">${notification.date}</div>
        `;
        
        return div;
    }

    function addNotification(notification) {
        const container = document.getElementById('notificationsContainer');
        const emptyState = container.querySelector('.empty-state');
        if (emptyState) container.innerHTML = '';

        const notificationElement = createNotificationElement(notification);
        container.insertBefore(notificationElement, container.firstChild);
    }

    // Keep your sample notification test code here if needed...

    setInterval(updateDate, 60000);

    document.querySelector('.filter-btn').addEventListener('click', function() {
        console.log('Filter clicked');
    });

    function showNotificationDetail(type) {
        const listView = document.getElementById('notificationsList');
        const detailView = document.getElementById('notificationDetail');
        const detailTitle = document.getElementById('detailTitle');
        const senderName = document.getElementById('senderName');
        const senderEmail = document.getElementById('senderEmail');
        const senderAvatar = document.getElementById('senderAvatar');
        const timestamp = document.getElementById('notificationTimestamp');
        const messageContent = document.getElementById('messageContent');

        listView.style.display = 'none';
        detailView.classList.add('active');

        // Switch-case for notification details here...
    }

    function showNotificationsList() {
        const listView = document.getElementById('notificationsList');
        const detailView = document.getElementById('notificationDetail');

        listView.style.display = 'block';
        detailView.classList.remove('active');
    }
</script>

</body>
</html>