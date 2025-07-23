<?php
$page_title = "Emergency Contacts";
include('navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css"> 
    <link rel="stylesheet" href="assets/css/emergency.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLoginModal()">×</span>
            <h2 id="modalTitle">Login</h2>
            <div id="formContainer"></div>
            <p id="toggleFormText">Don't have an account? <a href="#" onclick="toggleForm('signup')">Sign Up</a></p>
        </div>
    </div>
    <div class="emergency-container" style="margin-top: 10px;">
        <h1>🆘 Emergency Contacts</h1>
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search contacts...">
        </div>
        
        <div class="contacts-grid">
            <!-- Police -->
            <div class="contact-card" onclick="initiateCall('100')">
                <div class="contact-icon">🚨</div>
                <h3>Police</h3>
                <p class="contact-number">100</p>
                <p class="contact-desc">For immediate police assistance</p>
            </div>

            <!-- Women's Helpline -->
            <div class="contact-card" onclick="initiateCall('1091')">
                <div class="contact-icon">👩</div>
                <h3>Women's Helpline</h3>
                <p class="contact-number">1091</p>
                <p class="contact-desc">24/7 support for women in distress</p>
            </div>

            <!-- Child Helpline -->
            <div class="contact-card" onclick="initiateCall('1098')">
                <div class="contact-icon">🧒</div>
                <h3>Child Helpline</h3>
                <p class="contact-number">1098</p>
                <p class="contact-desc">Help for children in need of care</p>
            </div>

            <!-- Legal Aid -->
            <div class="contact-card" onclick="initiateCall('155345')">
                <div class="contact-icon">⚖️</div>
                <h3>Legal Aid</h3>
                <p class="contact-number">155345</p>
                <p class="contact-desc">Free legal support</p>
            </div>

            <!-- Ambulance -->
            <div class="contact-card" onclick="initiateCall('108')">
                <div class="contact-icon">🚑</div>
                <h3>Ambulance</h3>
                <p class="contact-number">108</p>
                <p class="contact-desc">Medical emergencies</p>
            </div>

            <!-- Disaster Management -->
            <div class="contact-card" onclick="initiateCall('1078')">
                <div class="contact-icon">🌪️</div>
                <h3>Disaster Management</h3>
                <p class="contact-number">1078</p>
                <p class="contact-desc">Natural disaster response</p>
            </div>
        </div>
    </div>

    <script src="assets/js/emergency.js"></script>
    <script src="assets/js/script.js"></script>
    <footer class="bg-gray-800 text-white text-center p-4 mt-4">
        <p>&copy; 2025 NYAYABOT. All rights reserved.</p>
    </footer>
</body>
</html>