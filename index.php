
<?php
$page_title = "NYAYABOT - Legal Awareness Platform";
include('navbar.php'); // Include navbar.php at the top
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
</head>
<body>
  

  <div class="main-content">
    <div class="header">
      <h1 id="mainTitle">NYAYABOT - Legal Awareness Platform</h1>
      <p id="mainSubtitle">Your guide to legal rights and procedures</p>
    </div>

    <div class="content-grid">
      <div class="content-card">
        <h2 id="firTitle">Download FIR Template</h2>
        <p id="firDescription">
          Get a ready-to-use FIR template that you can fill with your details and submit to the police station.
        </p>
        <button id="downloadBtnText" class="download-btn" onclick="downloadFIRTemplate()">📄 Download FIR Template (PDF)</button>
      </div>

      <div class="content-card">
        <h2 id="tipsTitle">Quick Legal Tips</h2>
        <ul id="tipsList">
          <li>Always keep copies of important documents</li>
          <li>File FIR immediately after any crime</li>
          <li>Know your fundamental rights</li>
          <li>Seek legal help when needed</li>
        </ul>
      </div>
    </div>

    <div class="grievance-section">
      <h2 id="grievanceTitle">Grievance Registry</h2>
      <p id="grievanceDescription">
        Select your issue type or describe your problem to get step-by-step guidance.
      </p>
      <select id="grievanceType" class="grievance-select">
        <option value="">Select your grievance type</option>
        <option value="theft">Theft/Burglary</option>
        <option value="fraud">Fraud/Cheating</option>
        <option value="assault">Physical Assault</option>
        <option value="harassment">Harassment</option>
        <option value="cyber">Cyber Crime</option>
        <option value="domestic">Domestic Violence</option>
        <option value="property">Property Dispute</option>
        <option value="other">Other (Please specify)</option>
      </select>
      <textarea id="grievanceDetails" class="grievance-input" placeholder="Describe your issue"></textarea>
      <button id="submitBtnText" class="submit-btn" onclick="getGuidance()">Get Guidance</button>
    </div>

    <div class="guide-section" id="guideSection">
      <h3 id="guideTitle">Step-by-Step Guide</h3>
      <ul id="guideSteps" class="guide-steps"></ul>
    </div>

    <button class="chatbot-toggle" onclick="toggleChatbot()">💬<br>Legal Help</button>
    <div id="chatbotContainer" class="chatbot-container">
      <div class="chatbot-header">
        <h3>NyayaBot Assistant</h3>
        <button class="close-chatbot" onclick="toggleChatbot()">×</button>
      </div>
      <div id="chatbotMessages" class="chatbot-messages"></div>
      <div class="chatbot-input">
        <input type="text" id="chatbotQuery" placeholder="Ask a legal question...">
        <button onclick="sendChatbotQuery()">Send</button>
      </div>
    </div>

    <div id="loginModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">×</span>
        <h2 id="modalTitle">Login</h2>
        <div id="formContainer"></div>
        <p id="toggleFormText">Don't have an account? <a href="#" onclick="toggleForm('signup')">Sign Up</a></p>
      </div>
    </div>

    <div id="firTemplate" style="display: none;">
      <h2>FIRST INFORMATION REPORT (FIR)</h2>
      <p><strong>Police Station:</strong> _______________________</p>
      <p><strong>Date:</strong> _______________________</p>
      <p><strong>Time:</strong> _______________________</p>
      <h3>Complaint Details:</h3>
      <p><strong>Name:</strong> _______________________</p>
      <p><strong>Father's/Husband's Name:</strong> _______________________</p>
      <p><strong>Address:</strong> _______________________</p>
      <p><strong>Phone Number:</strong> _______________________</p>
      <p><strong>Email:</strong> _______________________</p>
      <h3>Incident Details:</h3>
      <p><strong>Date of Incident:</strong> _______________________</p>
      <p><strong>Time of Incident:</strong> _______________________</p>
      <p><strong>Place of Incident:</strong> _______________________</p>
      <p><strong>Description of Incident:</strong></p>
      <p>_________________________________________________</p>
      <p>_________________________________________________</p>
      <p>_________________________________________________</p>
      <p><strong>Property/Amount Involved:</strong></p>
      <p>_________________________________________________</p>
      <h3>Suspect Details (if known):</h3>
      <p><strong>Name:</strong> _______________________</p>
      <p><strong>Address:</strong> _______________________</p>
      <p><strong>Description:</strong> _______________________</p>
      <h3>Witnesses:</h3>
      <p>1. <strong>Name:</strong> _____________ <strong>Address:</strong> _____________</p>
      <p>2. <strong>Name:</strong> _____________ <strong>Address:</strong> _____________</p>
      <p>I hereby declare that the above information is true to the best of my knowledge.</p>
      <p><strong>Signature:</strong> _______________________</p>
      <p><strong>Date:</strong> _______________________</p>
    </div>
  </div>

  <script src="assets/js/script.js"></script>
   <footer class="bg-gray-800 text-white text-center p-4 mt-4">
  <p>&copy; 2025 NYAYABOT. All rights reserved.</p>
</footer>
</body>
</html>
