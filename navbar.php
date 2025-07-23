<?php
$current_page = basename($_SERVER['SCRIPT_NAME']);
$selected_lang = isset($_GET['lang']) ? $_GET['lang'] : 'en'; // Default to 'en' if not set
?>
<nav class="navbar">
  <div class="nav-container">
    <div class="logo">⚖️ NYAYABOT</div>
    <div class="nav-links">
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
      <a href="#" class="nav-item" id="loginBtn" onclick="openLoginModal('login'); return false;" data-tooltip="Log into your account">Login</a>
      <a href="#" class="nav-item" id="signupBtn" onclick="openLoginModal('signup'); return false;" data-tooltip="Create a new account">Sign Up</a>
      <a href="#" class="nav-item hidden" id="logoutBtn" onclick="logout(); return false;" data-tooltip="Log out of your account">Logout</a>
    </div>
  </div>
</nav>