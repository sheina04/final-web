<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rest Assured</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
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
    }

    /* Header Styles */
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 20px;
        background-color: rgb(255, 242, 225);
        border-bottom: 2px solid #c2bfbb;
        flex-wrap: wrap;
    }

    header .logo img {
        height: 80px;
        max-width: 100px;
    }

    nav {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    nav a {
        text-decoration: none;
        color: #664832;
        font-size: 15px;
        padding: 5px 10px;
        transition: all 0.3s ease;
    }

    nav a:hover {
        text-decoration: underline;
        color: #3E2A1E;
        font-weight: bold;
    }

    /* Main Content */
    .content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Search Section */
    .search-section {
        text-align: center;
        margin-bottom: 40px;
    }

    .search-section h2 {
        font-size: clamp(40px, 6vw, 65px);
        margin-bottom: 30px;
        font-family: "Cormorant Garamond", serif;
        color: #664832;
    }

    .search-boxes {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .search-boxes input[type="text"] {
        padding: 12px 15px;
        border: 2px solid #6d4b3d;
        background-color: rgb(255, 242, 225);
        border-radius: 10px;
        flex: 1;
        min-width: 250px;
        font-family: "Montserrat", sans-serif;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-boxes input[type="text"]:focus {
        outline: none;
        border-color: #3E2A1E;
        background-color: #fef3e5;
        box-shadow: 0 0 8px rgba(102, 72, 50, 0.3);
    }

    .search-boxes input[type="text"]::placeholder {
        color: #9E8B7E;
    }

    .search-btn {
        background-color: #6d4b3d;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        font-family: "Montserrat", sans-serif;
        transition: background-color 0.3s ease;
        min-width: 100px;
    }

    .search-btn:hover {
        background-color: #8B5E3C;
    }

    /* Map Section */
    .map-section {
        display: flex;
        justify-content: center;
        margin: 40px 0;
    }

    #map {
        width: 100%;
        max-width: 900px;
        height: 400px;
        border: 2px solid #e0c3a6;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Sign Up Section */
    .sign-up-section {
        border-top: 3px solid #c2bfbb;
        padding: 60px 0;
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 40px;
        align-items: center;
        margin-top: 60px;
    }

    .sign-up-section h2 {
        font-size: clamp(36px, 5vw, 60px);
        font-family: "Cormorant Garamond", serif;
        color: #664832;
        line-height: 1.2;
    }

    .sign-up-section p {
        font-size: 18px;
        color: #3E2A1E;
        margin: 0;
    }

    .sign-up-button {
        padding: 15px 30px;
        background-color: rgb(255, 242, 225);
        color: #664832;
        border: 3px solid #8B5E3C;
        border-radius: 20px;
        font-family: "Montserrat", sans-serif;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        justify-self: center;
        min-width: 120px;
    }

    .sign-up-button:hover {
        background-color: #8B5E3C;
        color: white;
    }

    /* Footer */
    footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: rgb(255, 242, 225);
        border-top: 2px solid #c2bfbb;
        font-family: "Montserrat", sans-serif;
        flex-wrap: wrap;
        gap: 20px;
    }

    footer .logo img {
        height: 80px;
        max-width: 100%;
    }

    footer p {
        margin: 0;
        font-size: 14px;
    }

    footer a {
        color: #664832;
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }

    /* Tablet Styles */
    @media (max-width: 1024px) {
        .content {
            padding: 30px 15px;
        }

        .search-boxes {
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .search-boxes input[type="text"] {
            width: 100%;
            max-width: 400px;
            min-width: 250px;
        }

        .search-btn {
            width: 100%;
            max-width: 200px;
        }

        #map {
            height: 350px;
        }

        .sign-up-section {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 25px;
        }

        nav {
            justify-content: center;
            width: 100%;
        }

        header {
            flex-direction: column;
            gap: 20px;
        }
    }

    /* Mobile Styles */
    @media (max-width: 768px) {
        .content {
            padding: 20px 10px;
        }

        .search-section {
            margin-bottom: 30px;
        }

        .search-section h2 {
            margin-bottom: 20px;
        }

        .search-boxes {
            gap: 12px;
        }

        .search-boxes input[type="text"] {
            padding: 10px 12px;
            min-width: 200px;
        }

        .search-btn {
            padding: 10px 20px;
        }

        #map {
            height: 300px;
            border-radius: 8px;
        }

        .sign-up-section {
            padding: 40px 0;
        }

        .sign-up-section p {
            font-size: 16px;
        }

        footer {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        nav {
            flex-direction: column;
            gap: 10px;
        }

        nav a {
            text-align: center;
            padding: 8px 15px;
        }
    }

    /* Small Mobile Styles */
    @media (max-width: 480px) {
        .content {
            padding: 15px 8px;
        }

        .search-boxes input[type="text"] {
            min-width: 180px;
            padding: 8px 10px;
        }

        .search-btn {
            padding: 8px 15px;
            font-size: 13px;
        }

        #map {
            height: 250px;
        }

        .sign-up-button {
            width: 100%;
            max-width: 200px;
        }
    }

    /* Very Small Mobile */
    @media (max-width: 320px) {
        .search-boxes input[type="text"] {
            min-width: 150px;
        }

        #map {
            height: 200px;
        }
    }

    /* Leaflet Map Responsive Adjustments */
    .leaflet-container {
        font-family: "Montserrat", sans-serif;
    }

    .leaflet-popup-content-wrapper {
        background-color: rgb(255, 242, 225);
        color: #3E2A1E;
    }

    .leaflet-popup-tip {
        background-color: rgb(255, 242, 225);
    }

    /* Loading State */
    .loading {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #6d4b3d;
    }

    /* Error State */
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 15px;
        margin: 20px 0;
        text-align: center;
    }

    /* Success State */
    .success-message {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        padding: 15px;
        margin: 20px 0;
        text-align: center;
    }
</style>
</head>
<body>
<header>
    <div class="logo">
        <a href="new_main.php">
            <img src="RA_logo.png" alt="Rest Assured Logo">    
        </a>
    </div>
    <nav id="nav-menu">
            <a href="main.php">HOME</a>
            <a href="memorial.php">MEMORIAL</a>
            <a href="cemeteries.php">CEMETERIES</a>
            <a href="about_us.php" class="active">ABOUT US</a>
            <a href="contact.php">CONTACT US</a>
            <a href="signIn.php">SIGN IN</a>
            <a href="signup.php">SIGN UP</a>
        </nav>
</header>

<div class="content">
    <div class="search-section">
        <h2>Search Cemetery</h2>
        <div class="search-boxes">
            <input type="text" name="cemetery_name" placeholder="Cemetery Name" aria-label="Cemetery Name">
            <input type="text" name="location" placeholder="Cemetery Location (City or Province)" aria-label="Cemetery Location">
            <button class="search-btn" aria-label="Search for cemeteries">Search</button>
        </div>
        <div id="search-messages"></div>
    </div>
    
    <div class="map-section">
        <div id="map" role="application" aria-label="Interactive map showing cemetery locations"></div>
    </div>

    <section class="sign-up-section">
        <h2>New<br>here?</h2>
        <p>Sign up to access all features and manage your records effortlessly.</p>
        <a href="signup.php" class="sign-up-button">Sign Up</a>
    </section>
</div>

<footer>
    <div class="logo">
        <img src="RA_logo.png" alt="Rest Assured Logo">
    </div>
    <p>
        <span>For assistance:</span> 
        <a href="mailto:r.assured@gmail.com">r.assured@gmail.com</a>
    </p>
    <p>09123456273</p>
    <p>&copy; 2024 Rest Assured. All Rights Reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Ensure the map and search function are initialized once the page loads
$(document).ready(function() {
    let map;
    let markersGroup = L.layerGroup();
    
    // Initialize the map
    function initializeMap() {
        // Check if map already exists
        if (map) {
            map.remove();
        }
        
        map = L.map('map').setView([10.3157, 123.8854], 13); // Cebu, Philippines coordinates

        // Add a tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add markers group to map
        markersGroup.addTo(map);

        // Initial marker (this will be replaced when searching)
        L.marker([10.3157, 123.8854]).addTo(markersGroup)
            .bindPopup('<b>Cebu, Philippines</b><br>Default location')
            .openPopup();

        // Handle map resize on window resize
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    }

    // Initialize map on page load
    initializeMap();

    // Reinitialize map on window resize for responsive behavior
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (map) {
                map.invalidateSize();
            }
        }, 250);
    });

    // Function to show messages
    function showMessage(message, type = 'info') {
        const messageDiv = $('#search-messages');
        messageDiv.removeClass('error-message success-message loading');
        
        if (type === 'error') {
            messageDiv.addClass('error-message');
        } else if (type === 'success') {
            messageDiv.addClass('success-message');
        } else if (type === 'loading') {
            messageDiv.addClass('loading');
        }
        
        messageDiv.html(message).show();
        
        // Auto-hide after 5 seconds for success/error messages
        if (type !== 'loading') {
            setTimeout(function() {
                messageDiv.fadeOut();
            }, 5000);
        }
    }

    // Function to handle the search
    function searchCemeteries() {
        const cemeteryName = $('input[name="cemetery_name"]').val().trim();
        const location = $('input[name="location"]').val().trim();

        // Validate input
        if (!cemeteryName && !location) {
            showMessage('Please enter a cemetery name or location to search.', 'error');
            return;
        }

        // Show loading message
        showMessage('Searching for cemeteries...', 'loading');

        // Make an AJAX request to search_cemeteries.php
        $.get('search_cemeteries.php', { 
            cemetery_name: cemeteryName, 
            location: location 
        })
        .done(function(data) {
            try {
                const cemeteries = JSON.parse(data);

                // Clear the existing markers
                markersGroup.clearLayers();

                // If cemeteries are found, add them to the map
                if (cemeteries && cemeteries.length > 0) {
                    let bounds = L.latLngBounds();
                    
                    cemeteries.forEach(function(cemetery) {
                        const lat = parseFloat(cemetery.latitude);
                        const lng = parseFloat(cemetery.longitude);

                        if (!isNaN(lat) && !isNaN(lng)) {
                            // Add marker to the map for each cemetery
                            const marker = L.marker([lat, lng]).addTo(markersGroup)
                                .bindPopup(`<b>${cemetery.name}</b><br>${cemetery.location}`);
                            
                            bounds.extend([lat, lng]);
                        }
                    });

                    // Fit map to show all markers
                    if (bounds.isValid()) {
                        map.fitBounds(bounds, { padding: [20, 20] });
                    }

                    showMessage(`Found ${cemeteries.length} cemetery(ies).`, 'success');
                } else {
                    showMessage('No cemeteries found matching your search criteria.', 'error');
                    // Reset to default view
                    map.setView([10.3157, 123.8854], 13);
                    L.marker([10.3157, 123.8854]).addTo(markersGroup)
                        .bindPopup('<b>Cebu, Philippines</b><br>No results found - showing default location');
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                showMessage('Error processing search results. Please try again.', 'error');
            }
        })
        .fail(function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            showMessage('Error connecting to server. Please check your connection and try again.', 'error');
        });
    }

    // Bind click event to search button
    $('.search-btn').on('click', function() {
        searchCemeteries();
    });

    // Bind enter key to search inputs
    $('.search-boxes input[type="text"]').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            searchCemeteries();
        }
    });

    // Clear messages when user starts typing
    $('.search-boxes input[type="text"]').on('input', function() {
        $('#search-messages').fadeOut();
    });
});
</script>
</body>
</html>