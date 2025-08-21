<?php
session_start();
$current_page = basename($_SERVER['SCRIPT_NAME']);
$selected_lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
$is_logged_in = isset($_SESSION['user_id']); // PHP session check
?>
<nav class="navbar">
  <div class="nav-container">
    <div class="logo">⚖️ NYAYABOT</div>
    <div class="nav-links">
      <!-- Your existing navigation links remain the same -->
      <a href="index.php" class="nav-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" data-tooltip="Go to homepage">
        <i class="fa-solid fa-house" style="color: white;"></i> Home
      </a>
      <a href="costestimator.php" class="nav-item <?php echo $current_page == 'costestimator.php' ? 'active' : ''; ?>" data-tooltip="Estimate legal fees">
        <i class="fa-solid fa-calculator"></i> Cost Estimator 
      </a>
      <a href="court-locator.php" class="nav-item <?php echo $current_page == 'court-locator.php' ? 'active' : ''; ?>" data-tooltip="Find nearby courts">
        <i class="fa-solid fa-location-dot"></i> Courts 
      </a>
      <a href="emergency.php" class="nav-item <?php echo $current_page == 'emergency.php' ? 'active' : ''; ?>" data-tooltip="Helpline numbers">
        <i class="fa-solid fa-phone"></i> Emergency 
      </a>
      <a href="templates.php" class="nav-item <?php echo $current_page == 'templates.php' ? 'active' : ''; ?>" data-tooltip="Legal document templates">
        <i class="fa-solid fa-file"></i> Templates 
      </a>
      <a href="faqs.php" class="nav-item <?php echo $current_page == 'faqs.php' ? 'active' : ''; ?>" data-tooltip="Common questions">
        <i class="fa-solid fa-circle-question"></i> FAQs 
      </a>
      
      <select class="language-select" id="languageSelect" onchange="changeLanguage()">
        <option value="en" <?php echo $selected_lang == 'en' ? 'selected' : ''; ?>>English</option>
        <option value="hi" <?php echo $selected_lang == 'hi' ? 'selected' : ''; ?>>हिंदी</option>
      </select>
      
      <!-- Authentication buttons - Initial visibility set by PHP -->
      <a href="#" class="nav-item <?php echo $is_logged_in ? 'hidden' : ''; ?>" id="loginBtn" onclick="openLoginModal('login'); return false;" data-tooltip="Log into your account">Login</a>
      <a href="#" class="nav-item <?php echo $is_logged_in ? 'hidden' : ''; ?>" id="signupBtn" onclick="openLoginModal('signup'); return false;" data-tooltip="Create a new account">Sign Up</a>
      <button id="logout-btn" class="logout-button <?php echo $is_logged_in ? '' : 'hidden'; ?>" onclick="logout(); return false;" data-tooltip="Log out of your account">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
      
      <!-- Add this script to sync PHP session with JavaScript -->
      <script>
        // Initialize currentUser from PHP session if available
        window.currentUser = <?php echo $is_logged_in ? json_encode(['user_id' => $_SESSION['user_id']]) : 'null'; ?>;
        
        // If we have a PHP session but no localStorage, sync them
        if (window.currentUser && !localStorage.getItem('nyayabotUser')) {
          localStorage.setItem('nyayabotUser', JSON.stringify(window.currentUser));
        }
      </script>
    </div>
  </div>
</nav>