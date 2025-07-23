$(document).ready(function () {
  // Initialize navbar state (removed navbar.html loading since navbar.php is included statically)
  updateNavbar();
});

const translations = {
  en: {
    mainTitle: "NYAYABOT - Legal Awareness Platform",
    mainSubtitle: "Your guide to legal rights and procedures",
    firTitle: "Download FIR Template",
    firDescription:
      "Get a ready-to-use FIR template that you can fill with your details and submit to the police station.",
    downloadBtnText: "📄 Download FIR Template (PDF)",
    tipsTitle: "Quick Legal Tips",
    tipsList: [
      "Always keep copies of important documents",
      "File FIR immediately after crime",
      "Know your fundamental rights",
      "Seek legal help when needed",
    ],
    grievanceTitle: "Grievance Registry",
    grievanceDescription:
      "Select your issue type or describe your problem to get step-by-step guidance.",
    submitBtnText: "Get Guidance",
    loginTitle: "Login",
    signupTitle: "Sign Up",
    usernameLabel: "Email:",
    passwordLabel: "Password:",
    emailLabel: "Email:",
    fullNameLabel: "Full Name:",
    confirmPasswordLabel: "Confirm Password:",
    loginBtnText: "Login",
    signupBtnText: "Sign Up",
    toggleLoginText: "Already have an account?",
    toggleSignupText: "Don't have an account?",
    guideTitle: "Step-by-Step Guide",
  },
  hi: {
    mainTitle: "न्यायबॉट - कानूनी जागरूकता मंच",
    mainSubtitle: "आपके कानूनी अधिकारों और प्रक्रियाओं का मार्गदर्शक",
    firTitle: "एफआईआर टेम्प्लेट डाउनलोड करें",
    firDescription:
      "एक तैयार एफआईआर टेम्प्लेट प्राप्त करें जिसे आप अपने विवरण के साथ भर सकते हैं और पुलिस स्टेशन में जमा कर सकते हैं।",
    downloadBtnText: "📄 एफआईआर टेम्प्लेट डाउनलोड करें (PDF)",
    tipsTitle: "त्वरित कानूनी सुझाव",
    tipsList: [
      "हमेशा महत्वपूर्ण दस्तावेजों की प्रतियां रखें",
      "किसी भी अपराध के तुरंत बाद एफआईआर दर्ज करें",
      "अपने मौलिक अधिकारों को जानें",
      "जरूरत पड़ने पर कानूनी सहायता लें",
    ],
    grievanceTitle: "शिकायत रजिस्ट्री",
    grievanceDescription:
      "अपनी समस्या का प्रकार चुनें या अपनी समस्या का वर्णन करें और चरणबद्ध मार्गदर्शन प्राप्त करें।",
    submitBtnText: "मार्गदर्शन प्राप्त करें",
    loginTitle: "लॉगिन",
    signupTitle: "पंजीकरण",
    usernameLabel: "ईमेल:",
    passwordLabel: "पासवर्ड:",
    emailLabel: "ईमेल:",
    fullNameLabel: "पूरा नाम:",
    confirmPasswordLabel: "पासवर्ड की पुष्टि करें:",
    loginBtnText: "लॉगिन",
    signupBtnText: "पंजीकरण करें",
    toggleLoginText: "क्या आपके पास पहले से एक खाता है?",
    toggleSignupText: "क्या आपके पास खाता नहीं है?",
    guideTitle: "चरणबद्ध मार्गदर्शिका",
  },
};

// Current user data
let currentUser = null;
let currentLanguage = "en";

// Load user data from localStorage
function loadUserData() {
  const userData = localStorage.getItem("nyayabotUser");
  if (userData) {
    currentUser = JSON.parse(userData);
    updateNavbar();
  }
}

// Update navbar buttons based on login state
function updateNavbar() {
  const loginBtn = document.getElementById("loginBtn");
  const signupBtn = document.getElementById("signupBtn");
  const logoutBtn = document.getElementById("logoutBtn");

  if (currentUser) {
    loginBtn.classList.add("hidden");
    signupBtn.classList.add("hidden");
    logoutBtn.classList.remove("hidden");
  } else {
    loginBtn.classList.remove("hidden");
    signupBtn.classList.remove("hidden");
    logoutBtn.classList.add("hidden");
  }
}

// Modal functionality
function openLoginModal(formType = "login") {
  console.log("Opening modal for:", formType); // Debug log
  const modal = document.getElementById("loginModal");
  if (!modal) {
    console.error("Login modal not found in DOM");
    return;
  }
  const formContainer = document.getElementById("formContainer");
  const modalTitle = document.getElementById("modalTitle");
  const toggleFormText = document.getElementById("toggleFormText");
  const t = translations[currentLanguage];

  // Set modal title with icon and styling
  modalTitle.innerHTML = `<span class="modal-title-icon">${
    formType === "login" ? "🔐" : "📝"
  }</span> ${formType === "login" ? t.loginTitle : t.signupTitle}`;

  // Create form HTML based on type
  let formHTML = "";
  if (formType === "login") {
    formHTML = `
      <div class="form-group">
        <label for="modalUsername">${t.usernameLabel}</label>
        <input type="email" id="modalUsername" required />
      </div>
      <div class="form-group">
        <label for="modalPassword">${t.passwordLabel}</label>
        <input type="password" id="modalPassword" required />
      </div>`;
  } else {
    // signup
    formHTML = `
      <div class="form-group">
        <label for="modalEmail">${t.emailLabel}</label>
        <input type="email" id="modalEmail" required />
      </div>
      <div class="form-group">
        <label for="modalFullName">${t.fullNameLabel}</label>
        <input type="text" id="modalFullName" required />
      </div>
      <div class="form-group">
        <label for="modalPassword">${t.passwordLabel}</label>
        <input type="password" id="modalPassword" required />
      </div>
      <div class="form-group">
        <label for="modalConfirmPassword">${t.confirmPasswordLabel}</label>
        <input type="password" id="modalConfirmPassword" required />
      </div>
      <div class="form-group">
        <label for="modalPhone">Phone:</label>
        <input type="tel" id="modalPhone" required />
      </div>`;
  }

  formHTML += `
    <button class="login-btn" onclick="${
      formType === "login" ? "modalLogin()" : "modalSignup()"
    }">
      ${formType === "login" ? t.loginBtnText : t.signupBtnText}
    </button>`;

  formContainer.innerHTML = formHTML;

  // Set toggle text with event handlers
  toggleFormText.innerHTML =
    formType === "login"
      ? `${t.toggleSignupText} <a href="#" onclick="toggleForm('signup'); return false;">${t.signupBtnText}</a>`
      : `${t.toggleLoginText} <a href="#" onclick="toggleForm('login'); return false;">${t.loginBtnText}</a>`;

  // Show modal with animation
  modal.classList.add("show");
}

function toggleForm(formType) {
  console.log("Toggling to:", formType); // Debug log
  closeLoginModal();
  openLoginModal(formType);
}

function closeLoginModal() {
  const modal = document.getElementById("loginModal");
  if (modal) {
    modal.classList.remove("show");
  }
}

// Modal login function
function modalLogin() {
  const email = document.getElementById("modalUsername").value;
  const password = document.getElementById("modalPassword").value;

  if (email && password) {
    console.log("Sending login request:", { email, password });
    fetch("api/auth/login.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email: email, password: password }),
    })
      .then((response) => {
        console.log("Login response status:", response.status);
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text(); // Use text() to get raw response
      })
      .then((text) => {
        console.log("Raw response text:", text);
        let data;
        try {
          data = JSON.parse(text); // Attempt to parse as JSON
        } catch (e) {
          console.error("Failed to parse JSON:", e);
          throw new Error("Invalid server response: " + text);
        }
        console.log("Login response data:", data);
        if (data.message === "Login successful") {
          currentUser = { email: data.email, user_id: data.user_id };
          localStorage.setItem("nyayabotUser", JSON.stringify(currentUser));
          updateNavbar();
          closeLoginModal();
          alert("Login successful!");
        } else {
          alert(data.message || "Login failed");
        }
      })
      .catch((error) => {
        console.error("Login error:", error);
        alert("Error logging in. Please try again. Check console for details.");
      });
  } else {
    alert("Please enter both email and password");
  }
}

// Modal signup function
function modalSignup() {
  const email = document.getElementById("modalEmail").value;
  const password = document.getElementById("modalPassword").value;
  const confirmPassword = document.getElementById("modalConfirmPassword").value;
  const name = document.getElementById("modalFullName").value;
  const phone = document.getElementById("modalPhone").value;

  if (email && password && confirmPassword && name && phone) {
    if (password !== confirmPassword) {
      alert("Passwords do not match. Please try again.");
      return;
    }
    console.log("Sending signup request:", { email, password, name, phone });
    fetch("api/auth/register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: email,
        password: password,
        name: name,
        phone: phone,
      }),
    })
      .then((response) => {
        console.log("Signup response status:", response.status);
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        console.log("Signup response data:", data);
        if (data.message === "User registered successfully") {
          currentUser = { email: email, name: name };
          localStorage.setItem("nyayabotUser", JSON.stringify(currentUser));
          updateNavbar();
          closeLoginModal();
          alert("Account created successfully!");
        } else {
          alert(data.message || "Registration failed");
        }
      })
      .catch((error) => {
        console.error("Signup error:", error);
        alert(
          "Error registering. Please try again. Check console for details."
        );
      });
  } else {
    alert("Please fill all fields");
  }
}

function logout() {
  currentUser = null;
  localStorage.removeItem("nyayabotUser");
  updateNavbar();
  alert("Logged out successfully!");
}

// Language change functionality
function changeLanguage() {
  const select = document.getElementById("languageSelect");
  currentLanguage = select.value;
  updatePageText();
}

function updatePageText() {
  const t = translations[currentLanguage];

  document.getElementById("mainTitle").textContent = t.mainTitle;
  document.getElementById("mainSubtitle").textContent = t.mainSubtitle;
  document.getElementById("firTitle").textContent = t.firTitle;
  document.getElementById("firDescription").textContent = t.firDescription;
  document.getElementById("downloadBtnText").textContent = t.downloadBtnText;
  document.getElementById("tipsTitle").textContent = t.tipsTitle;
  document.getElementById("grievanceTitle").textContent = t.grievanceTitle;
  document.getElementById("grievanceDescription").textContent =
    t.grievanceDescription;
  document.getElementById("submitBtnText").textContent = t.submitBtnText;
  document.getElementById("guideTitle").textContent = t.guideTitle;

  const tipsList = document.getElementById("tipsList");
  tipsList.innerHTML = "";
  t.tipsList.forEach((tip) => {
    const li = document.createElement("li");
    li.textContent = tip;
    tipsList.appendChild(li);
  });

  if (document.getElementById("loginModal")?.classList.contains("show")) {
    const currentForm =
      document.getElementById("modalTitle").textContent === t.loginTitle
        ? "login"
        : "signup";
    closeLoginModal();
    openLoginModal(currentForm);
  }
}

// Download FIR Template as PDF
function downloadFIRTemplate() {
  try {
    if (
      typeof window.jspdf === "undefined" ||
      typeof html2canvas === "undefined"
    ) {
      throw new Error("Required libraries not loaded");
    }

    const { jsPDF } = window.jspdf;
    const element = document.getElementById("firTemplate");

    if (!element) {
      throw new Error("FIR template element not found");
    }

    const originalDisplay = element.style.display;
    element.style.display = "block";

    html2canvas(element, {
      scale: 2,
      logging: true,
      useCORS: true,
    })
      .then((canvas) => {
        element.style.display = originalDisplay;

        const imgData = canvas.toDataURL("image/png");
        const doc = new jsPDF({
          orientation: "portrait",
          unit: "mm",
        });

        const imgWidth = doc.internal.pageSize.getWidth();
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        doc.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
        doc.save("FIR_Template.pdf");
      })
      .catch((error) => {
        console.error("html2canvas error:", error);
        element.style.display = originalDisplay;
        alert("Failed to generate PDF. Please try again.");
      });
  } catch (error) {
    console.error("PDF generation error:", error);
    alert("Error: " + error.message);
  }
}

// Chatbot functionality
function toggleChatbot() {
  const chatbot = document.getElementById("chatbotContainer");
  chatbot.style.display = chatbot.style.display === "flex" ? "none" : "flex";
}

async function sendChatbotQuery() {
  const query = document.getElementById("chatbotQuery").value;
  if (!query.trim()) return;

  const messages = document.getElementById("chatbotMessages");

  messages.innerHTML += `<div class="user-message"><div class="message-content">${query}</div></div>`;
  document.getElementById("chatbotQuery").value = "";
  messages.innerHTML += `<div class="bot-message typing"><div class="message-content">NyayaBot is typing...</div></div>`;
  messages.scrollTop = messages.scrollHeight;

  try {
    const response = await fetch("/api/chatbot", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ query }),
    });

    const data = await response.json();
    document.querySelector(".typing").remove();
    messages.innerHTML += `<div class="bot-message"><div class="message-content">${data.response}</div></div>`;

    if (data.sections && data.sections.length > 0) {
      let sectionsHTML =
        '<div class="ipc-sections"><strong>Relevant IPC Sections:</strong><ul>';
      data.sections.forEach((section) => {
        sectionsHTML += `<li>${section.number}: ${section.description}</li>`;
      });
      sectionsHTML += "</ul></div>";
      messages.innerHTML += sectionsHTML;
    }

    messages.scrollTop = messages.scrollHeight;
  } catch (error) {
    console.error("Error:", error);
    document.querySelector(".typing").remove();
    messages.innerHTML += `<div class="bot-message error"><div class="message-content">Sorry, I encountered an error. Please try again.</div></div>`;
  }
}

function getGuidance() {
  const grievanceType = document.getElementById("grievanceType").value;
  const details = document.getElementById("grievanceDetails").value;

  if (!grievanceType) {
    alert("Please select a grievance type");
    return;
  }

  if (!details.trim()) {
    alert("Please provide details about your issue");
    return;
  }

  if (currentUser) {
    const grievanceData = {
      type: grievanceType,
      details: details,
      timestamp: new Date().toISOString(),
    };

    let userGrievances = JSON.parse(
      localStorage.getItem("userGrievances") || "[]"
    );
    userGrievances.push(grievanceData);
    localStorage.setItem("userGrievances", JSON.stringify(userGrievances));
  }

  showGuidance(grievanceType);
}

function showGuidance(grievanceType) {
  const guideSection = document.getElementById("guideSection");
  const guideSteps = document.getElementById("guideSteps");

  const guides = {
    theft: [
      "Immediately file an FIR at the nearest police station",
      "Prepare a detailed list of stolen items with approximate values",
      "Gather any evidence like CCTV footage or witness statements",
      "Get a copy of the FIR for your records",
      "Follow up with the investigating officer regularly",
      "Contact your insurance company if applicable",
    ],
    fraud: [
      "Collect all documents related to the fraud",
      "File an FIR at the police station",
      "Report to the bank/financial institution if money is involved",
      "File a complaint with the cyber crime cell if it's online fraud",
      "Consult a lawyer for legal advice",
      "Keep records of all communications",
    ],
    assault: [
      "Seek immediate medical attention",
      "Get a medical certificate from a government hospital",
      "File an FIR immediately",
      "Take photographs of injuries",
      "Collect witness statements",
      "Consult a lawyer for further legal action",
    ],
    harassment: [
      "Document all instances of harassment",
      "Save evidence like messages, emails, or recordings",
      "File an FIR under relevant sections",
      "Approach the women's helpline if applicable",
      "Consider filing for a restraining order",
      "Seek support from family and friends",
    ],
    cyber: [
      "Do not delete any evidence",
      "Take screenshots of the cybercrime",
      "File a complaint at cybercrime.gov.in",
      "Report to your local cyber crime cell",
      "Change all your passwords",
      "Monitor your bank accounts and credit reports",
    ],
    domestic: [
      "Contact the National Domestic Violence Helpline: 181",
      "Document all incidents with dates and details",
      "Seek medical attention for injuries",
      "File an FIR or complaint",
      "Apply for a protection order under the Domestic Violence Act",
      "Reach out to local support groups and NGOs",
    ],
    property: [
      "Gather all property-related documents",
      "Consult a property lawyer",
      "Try mediation before going to court",
      "File a civil suit if necessary",
      "Get a title verification done",
      "Consider approaching the local authorities",
    ],
    other: [
      "Document your issue in detail",
      "Research the relevant laws",
      "Consult with a lawyer",
      "File appropriate complaints with relevant authorities",
      "Gather evidence and witness statements",
      "Follow up regularly on your case",
    ],
  };

  const steps = guides[grievanceType] || guides.other;

  guideSteps.innerHTML = "";
  steps.forEach((step) => {
    const li = document.createElement("li");
    li.textContent = step;
    guideSteps.appendChild(li); // Fixed: Changed from tipsList to guideSteps
  });

  guideSection.style.display = "block";
  guideSection.scrollIntoView({ behavior: "smooth" });
}

// Initialize the page
document.addEventListener("DOMContentLoaded", function () {
  loadUserData();
  updatePageText();
});

function initiateCall(number) {
  // Check if on mobile device
  if (
    /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    // For mobile devices - initiate phone call
    window.location.href = "tel:" + number;
  } else {
    // For desktop - show alert with option to copy
    if (confirm(`Call ${name}? (On mobile this would dial directly)`)) {
      // Copy to clipboard
      navigator.clipboard
        .writeText(number)
        .then(() => alert(`Number ${number} copied to clipboard`))
        .catch((err) => console.error("Could not copy text: ", err));
    }
  }
}

// Search functionality
document.getElementById("searchInput").addEventListener("input", function (e) {
  const searchTerm = e.target.value.toLowerCase();
  const cards = document.querySelectorAll(".contact-card");

  cards.forEach((card) => {
    const text = card.textContent.toLowerCase();
    card.style.display = text.includes(searchTerm) ? "block" : "none";
  });
});
const searchInput = document.getElementById("searchInput");
if (searchInput) {
  searchInput.addEventListener("input", function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll(".contact-card");
    cards.forEach((card) => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(searchTerm) ? "block" : "none";
    });
  });
} else {
  console.warn("searchInput element not found; search functionality disabled.");
}
