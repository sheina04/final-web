<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support - Rest Assured</title>
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

        .support-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .support-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .support-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 36px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 10px;
        }

        .support-subtitle {
            font-size: 16px;
            color: rgba(102, 72, 50, 0.7);
            margin-bottom: 30px;
        }

        .help-search-container {
            position: relative;
            margin-bottom: 50px;
        }

        .help-search-box {
            width: 100%;
            padding: 20px 60px 20px 25px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            color: #664832;
            transition: all 0.3s ease;
        }

        .help-search-box::placeholder {
            color: rgba(102, 72, 50, 0.6);
        }

        .help-search-box:focus {
            outline: none;
            border-color: #8B6F4D;
            background-color: white;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
        }

        .help-search-icon {
            position: absolute;
            right: 25px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(102, 72, 50, 0.6);
            font-size: 20px;
        }

        .faq-section {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.1);
            margin-bottom: 40px;
        }

        .faq-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 30px;
            text-align: center;
        }

        .faq-item {
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
            margin-bottom: 0;
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-question {
            width: 100%;
            background: none;
            border: none;
            padding: 25px 0;
            text-align: left;
            font-size: 16px;
            font-weight: 600;
            color: #664832;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            color: #8B6F4D;
        }

        .faq-icon {
            font-size: 18px;
            transition: transform 0.3s ease;
            color: #8B6F4D;
        }

        .faq-item.active .faq-icon {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding: 0 0 0 0;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
            padding: 0 0 25px 0;
        }

        .faq-answer-content {
            color: rgba(102, 72, 50, 0.8);
            line-height: 1.6;
            font-size: 15px;
        }

        .contact-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .contact-card {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(102, 72, 50, 0.2);
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 72, 50, 0.3);
        }

        .contact-icon {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .contact-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .contact-info {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .contact-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .contact-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
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

            .contact-section {
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

            .faq-section {
                padding: 25px;
            }

            .contact-card {
                padding: 30px;
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

            .support-title {
                font-size: 28px;
            }

            .faq-section {
                padding: 20px;
            }

            .contact-card {
                padding: 25px;
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
                        <a href="help_support.php" class="nav-link active">
                            <span class="nav-icon">❓</span>
                            Help & Support
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="support-container">
                <!-- Support Header -->
                <div class="support-header">
                    <h1 class="support-title">Help & Support</h1>
                    <p class="support-subtitle">What can we help you with?</p>
                    
                    <div class="help-search-container">
                        <input type="text" class="help-search-box" placeholder="Search for help topics, FAQs, or guides...">
                        <span class="help-search-icon">🔍</span>
                    </div>
                </div>

                <!-- FAQ Section -->
                <section class="faq-section">
                    <h2 class="faq-title">FAQs</h2>
                    <p style="text-align: center; color: rgba(102, 72, 50, 0.7); margin-bottom: 30px;">
                        We're here to assist you with any questions or issues you may have.
                    </p>
                    
                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>HOW CAN I RENEW GRAVE?</span>
                                <span class="faq-icon">+</span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    To renew a grave, you can navigate to the "Transaction" section from your dashboard. There you'll find all active graves and their renewal dates. Simply select the grave you want to renew and follow the payment process. You can pay through various methods including online banking, GCash, or visit our office for in-person payment.
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>HOW DO I FIND SPECIFIC GRAVE?</span>
                                <span class="faq-icon">+</span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    Use our "Grave Locator" feature from the main menu. You can search by the deceased person's name, grave number, or section. The system will provide you with the exact location, including block, lot, and section details. You can also view a map showing the precise location within the cemetery grounds.
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>WHAT SHOULD I DO IF I ENCOUNTER AN ISSUE WITH THE SYSTEM?</span>
                                <span class="faq-icon">+</span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    If you encounter any technical issues, please try refreshing your browser first. If the problem persists, contact our support team at r.assured@gmail.com or call 09193210292. Please provide details about the issue, including what you were trying to do and any error messages you received. Our technical team will assist you promptly.
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>HOW DO I UPDATE MY CONTACT INFORMATION?</span>
                                <span class="faq-icon">+</span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    You can update your contact information by going to your profile settings. Click on your name in the top right corner, select "Profile," and then update your email, phone number, or address as needed. Make sure to save your changes. Updated contact information ensures you receive important notifications about grave renewals.
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>WHAT PAYMENT METHODS ARE ACCEPTED?</span>
                                <span class="faq-icon">+</span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    We accept various payment methods including online banking, GCash, PayMaya, credit/debit cards, and cash payments at our office. For online payments, you'll receive an instant confirmation and receipt. Office payments are accepted during business hours from Monday to Friday, 8:00 AM to 5:00 PM.
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>HOW DO I RECEIVE RENEWAL NOTIFICATIONS?</span>
                                <span class="faq-icon">+</span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-content">
                                    Renewal notifications are sent via email and SMS (if you've provided a mobile number) 90 days, 60 days, 30 days, and 7 days before the expiration date. You can also check your "Notifications" section in the dashboard for all important updates. Make sure your contact information is up to date to receive these reminders.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Section -->
                <section class="contact-section">
                    <div class="contact-card">
                        <div class="contact-icon">📧</div>
                        <h3 class="contact-title">Email Support</h3>
                        <p class="contact-info">Get help via email. We typically respond within 24 hours.</p>
                        <a href="mailto:r.assured@gmail.com" class="contact-btn">Send Email</a>
                    </div>

                    <div class="contact-card">
                        <div class="contact-icon">📞</div>
                        <h3 class="contact-title">Phone Support</h3>
                        <p class="contact-info">Call us directly for immediate assistance during business hours.</p>
                        <a href="tel:09193210292" class="contact-btn">Call Now</a>
                    </div>

                    <div class="contact-card">
                        <div class="contact-icon">🏢</div>
                        <h3 class="contact-title">Office Visit</h3>
                        <p class="contact-info">Visit our office for in-person assistance and payments.</p>
                        <a href="#" class="contact-btn">Get Directions</a>
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

    // Toggle FAQ items
    function toggleFAQ(button) {
        const faqItem = button.parentElement;
        const isActive = faqItem.classList.contains('active');
        
        // Close all FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Open clicked item if it wasn't active
        if (!isActive) {
            faqItem.classList.add('active');
        }
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

            // Close sidebar when link is clicked (mobile only)
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });

        updateDate(); // initialize date
    });

    // Search functionality
    document.querySelector('.help-search-box').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question span').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer-content').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = searchTerm === '' ? 'block' : 'none';
            }
        });
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });

    // Update date every minute
    setInterval(updateDate, 60000);
</script>

</body>
</html>