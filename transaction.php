<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction - Rest Assured</title>
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

        /* Transaction Section */
        .transaction-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #664832;
        }

        .make-payment-btn {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            z-index: 1;
            position: relative;
        }

        .make-payment-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.3);
        }

        .make-payment-btn:active {
            transform: translateY(0);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid rgba(102, 72, 50, 0.1);
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .payment-table th {
            background-color: rgba(139, 111, 77, 0.1);
            color: #664832;
            font-weight: 600;
            padding: 15px;
            text-align: left;
            font-size: 14px;
            border-bottom: 2px solid rgba(102, 72, 50, 0.1);
        }

        .payment-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
            color: #3E2A1E;
            font-size: 14px;
        }

        .payment-table tr:hover {
            background-color: rgba(139, 111, 77, 0.05);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background-color: rgba(34, 197, 94, 0.1);
            color: #059669;
        }

        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            color: #d97706;
        }

        .status-failed {
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .modal-header {
            margin-bottom: 25px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #664832;
            font-weight: 500;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 8px;
            font-size: 14px;
            color: #664832;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #8B6F4D;
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 8px;
            font-size: 14px;
            color: #664832;
            background-color: white;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #8B6F4D;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 8px;
            font-size: 14px;
            color: #664832;
            resize: vertical;
            min-height: 80px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #8B6F4D;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgba(139, 111, 77, 0.1);
            color: #664832;
            border: 2px dashed rgba(102, 72, 50, 0.3);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            background-color: rgba(139, 111, 77, 0.2);
        }

        .file-info {
            color: rgba(102, 72, 50, 0.6);
            margin-top: 5px;
            font-size: 12px;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
        }

        .btn-cancel {
            background-color: rgba(102, 72, 50, 0.1);
            color: #664832;
        }

        .btn-cancel:hover {
            background-color: rgba(102, 72, 50, 0.2);
        }

        .btn-submit {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
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

            .table-container {
                overflow-x: scroll;
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

            .transaction-section {
                padding: 20px;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .modal-content {
                width: 95%;
                padding: 20px;
            }

            .modal-buttons {
                flex-direction: column;
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

            .transaction-section {
                padding: 15px;
            }

            .user-name {
                display: none;
            }

            .payment-table th,
            .payment-table td {
                padding: 10px 8px;
                font-size: 12px;
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

        /* Success message */
        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(34, 197, 94, 0.3);
            z-index: 3000;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .success-message.show {
            transform: translateX(0);
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <header class="top-header">
        <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
        <a href="new_customer_dashboard.php" class="logo"></a>
        
        <div class="header-right">
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search">
                <span class="search-icon">🔍</span>
            </div>
            
            <div class="user-profile" id="userProfile">
                <div class="user-avatar">MC</div>
                <span class="user-name">Maria Clara</span>
                <span class="dropdown-arrow">▼</span>
                
                <div class="dropdown-menu" id="userDropdown">
                    <a href="customer_profile.php" class="dropdown-item">Profile</a>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">Transaction</h2>
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
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Payment History</h1>
                <p class="page-subtitle">View and manage your payment transactions</p>
            </div>

            <!-- Transaction Section -->
            <section class="transaction-section">
                <div class="section-header">
                    <h2 class="section-title">Payment History</h2>
                    <button class="make-payment-btn" id="makePaymentBtn">
                        <span>➕</span>
                        Make Payment
                    </button>
                </div>

                <div class="table-container">
                    <table class="payment-table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Amount Paid</th>
                                <th>Payment Method</th>
                                <th>Transaction Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTableBody">
                            <tr>
                                <td>TNX-0001</td>
                                <td>April 19, 2025</td>
                                <td>₱2,000.00</td>
                                <td>GCash</td>
                                <td>Renewal</td>
                                <td><span class="status-badge status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td>TNX-0002</td>
                                <td>March 15, 2025</td>
                                <td>₱1,500.00</td>
                                <td>Bank Transfer</td>
                                <td>Maintenance</td>
                                <td><span class="status-badge status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td>TNX-0003</td>
                                <td>February 28, 2025</td>
                                <td>₱500.00</td>
                                <td>Cash</td>
                                <td>Service Fee</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
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

    <!-- Payment Modal -->
    <div class="modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Make Payment</h2>
            </div>
            
            <form id="paymentForm">
                <div class="form-group">
                    <label class="form-label">Plot Code:</label>
                    <input type="text" class="form-input" id="plotCode" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Amount to Pay:</label>
                    <input type="number" class="form-input" id="amount" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Choose Payment Method:</label>
                    <select class="form-select" id="paymentMethod" required>
                        <option value="">Select</option>
                        <option value="gcash">GCash</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="cash">Cash</option>
                        <option value="card">Credit/Debit Card</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Upload Proof of Payment:</label>
                    <div class="file-upload">
                        <input type="file" class="file-upload-input" id="proofFile" accept="image/*,.pdf">
                        <label for="proofFile" class="file-upload-label">
                            Choose File
                        </label>
                    </div>
                    <div class="file-info" id="fileInfo">No file chosen</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Remarks (optional):</label>
                    <textarea class="form-textarea" id="remarks" placeholder="Add any additional notes..."></textarea>
                </div>
                
                <div class="modal-buttons">
                    <button type="button" class="btn btn-cancel" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Success Message -->
    <div class="success-message" id="successMessage">
        Payment submitted successfully! Please wait for confirmation.
    </div>

    <script>
        // DOM Elements
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const userProfile = document.getElementById('userProfile');
        const userDropdown = document.getElementById('userDropdown');
        const makePaymentBtn = document.getElementById('makePaymentBtn');
        const paymentModal = document.getElementById('paymentModal');
        const paymentForm = document.getElementById('paymentForm');
        const cancelBtn = document.getElementById('cancelBtn');
        const proofFile = document.getElementById('proofFile');
        const fileInfo = document.getElementById('fileInfo');
        const successMessage = document.getElementById('successMessage');

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

        // Open payment modal
        function openPaymentModal() {
            paymentModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close payment modal
        function closePaymentModal() {
            paymentModal.classList.remove('active');
            document.body.style.overflow = 'auto';
            
            // Reset form
            paymentForm.reset();
            updateFileLabel();
        }

        // Update file label
        function updateFileLabel() {
            if (proofFile.files.length > 0) {
                fileInfo.textContent = proofFile.files[0].name;
                fileInfo.style.color = '#664832';
            } else {
                fileInfo.textContent = 'No file chosen';
                fileInfo.style.color = 'rgba(102, 72, 50, 0.6)';
            }
        }

        // Show success message
        function showSuccessMessage() {
            successMessage.classList.add('show');
            setTimeout(() => {
                successMessage.classList.remove('show');
            }, 3000);
        }

        // Event Listeners
        mobileMenuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', closeSidebar);
        userProfile.addEventListener('click', toggleDropdown);
        makePaymentBtn.addEventListener('click', openPaymentModal);
        cancelBtn.addEventListener('click', closePaymentModal);
        proofFile.addEventListener('change', updateFileLabel);

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!userProfile.contains(event.target)) {
                userDropdown.classList.remove('active');
            }
        });

        // Close modal when clicking outside
        paymentModal.addEventListener('click', function(e) {
            if (e.target === paymentModal) {
                closePaymentModal();
            }
        });

        // Handle form submission
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                plotCode: document.getElementById('plotCode').value,
                amount: document.getElementById('amount').value,
                paymentMethod: document.getElementById('paymentMethod').value,
                proofFile: proofFile.files[0],
                remarks: document.getElementById('remarks').value
            };
            
            // Simulate form submission
            console.log('Payment submitted:', formData);
            
            // Show success message
            showSuccessMessage();
            
            // Close modal
            closePaymentModal();
            
            // Add new transaction to table (simulation)
            addNewTransaction(formData);
        });

        // Add new transaction to table
        function addNewTransaction(data) {
            const tableBody = document.getElementById('transactionTableBody');
            const newRow = document.createElement('tr');
            const transactionId = 'TNX-' + String(tableBody.children.length + 1).padStart(4, '0');
            const currentDate = new Date().toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            newRow.innerHTML = `
                <td>${transactionId}</td>
                <td>${currentDate}</td>
                <td>₱${parseFloat(data.amount).toFixed(2)}</td>
                <td>${data.paymentMethod.charAt(0).toUpperCase() + data.paymentMethod.slice(1)}</td>
                <td>Payment</td>
                <td><span class="status-badge status-pending">Pending</span></td>
            `;
            
            // Add to top of table
            tableBody.insertBefore(newRow, tableBody.firstChild);
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

        // Prevent form submission on Enter key in input fields (except textarea)
        document.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Close modal with Escape key
            if (e.key === 'Escape') {
                if (paymentModal.classList.contains('active')) {
                    closePaymentModal();
                }
                if (userDropdown.classList.contains('active')) {
                    userDropdown.classList.remove('active');
                }
                if (sidebar.classList.contains('active') && window.innerWidth <= 768) {
                    closeSidebar();
                }
            }
        });
    </script>
</body>
</html>