$(document).ready(function () {
  try {
    updateNavbar();
  } catch (e) {
    console.log("Navbar initialization error:", e);
  }
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

// Validate session with the server
function validateSession() {
  return fetch("/nyayabot/api/auth/login.php", {
    method: "GET",
    credentials: "include",
  })
    .then((response) => {
      console.log("Validate session response status:", response.status);
      if (!response.ok) {
        throw new Error("Session validation failed");
      }
      return response.json();
    })
    .then((data) => {
      console.log("Validate session response data:", data);
      if (data.status === "success" && data.user) {
        currentUser = { email: data.user.email, user_id: data.user.user_id };
        localStorage.setItem("nyayabotUser", JSON.stringify(currentUser));
        return true;
      } else {
        throw new Error("Invalid session");
      }
    })
    .catch((error) => {
      console.error("Session validation error:", error);
      currentUser = null;
      localStorage.removeItem("nyayabotUser");
      sessionStorage.clear();
      return false;
    });
}

// Load user data and validate session
function loadUserData() {
  try {
    const userData = localStorage.getItem("nyayabotUser");
    if (userData) {
      currentUser = JSON.parse(userData);
      return validateSession().then((isValid) => {
        updateNavbar();
        return isValid;
      });
    } else {
      updateNavbar();
      return Promise.resolve(false);
    }
  } catch (e) {
    console.log("Error loading user data:", e);
    currentUser = null;
    localStorage.removeItem("nyayabotUser");
    updateNavbar();
    return Promise.resolve(false);
  }
}

// Update navbar buttons based on login state
function updateNavbar() {
  try {
    const loginBtn = document.getElementById("loginBtn");
    const signupBtn = document.getElementById("signupBtn");
    // const logoutBtn = document.getElementById("logoutBtn");
    const newLogout = document.getElementById("logout-btn");

    const loggedIn = !!currentUser;

    if (loginBtn) loginBtn.classList.toggle("hidden", loggedIn);
    if (signupBtn) signupBtn.classList.toggle("hidden", loggedIn);
    if (newLogout) newLogout.classList.toggle("hidden", !loggedIn);  
  } catch (e) {
    console.error("Navbar update error:", e);
    const loginBtn = document.getElementById("loginBtn");
    const signupBtn = document.getElementById("signupBtn");
    // const logoutBtn = document.getElementById("logoutBtn");
    const newLogout = document.getElementById("logout-btn");
    if (loginBtn) loginBtn.classList.remove("hidden");
    if (signupBtn) signupBtn.classList.remove("hidden");
    // if (logoutBtn) logoutBtn.classList.add("hidden");
    if (newLogout) newLogout.classList.add("hidden");
  }
}

// Modal functionality
function openLoginModal(formType = "login") {
  console.log("Opening modal for:", formType);
  const modal = document.getElementById("loginModal");
  if (!modal) {
    console.error("Login modal not found in DOM");
    return;
  }
  const formContainer = document.getElementById("formContainer");
  const modalTitle = document.getElementById("modalTitle");
  const toggleFormText = document.getElementById("toggleFormText");
  const t = translations[currentLanguage];

  modalTitle.innerHTML = `<span class="modal-title-icon">${
    formType === "login" ? "🔐" : "📝"
  }</span> ${formType === "login" ? t.loginTitle : t.signupTitle}`;

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

  toggleFormText.innerHTML =
    formType === "login"
      ? `${t.toggleSignupText} <a href="#" onclick="toggleForm('signup'); return false;">${t.signupBtnText}</a>`
      : `${t.toggleLoginText} <a href="#" onclick="toggleForm('login'); return false;">${t.loginBtnText}</a>`;

  modal.classList.add("show");
}

function toggleForm(formType) {
  console.log("Toggling to:", formType);
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
    console.log("Sending login request:", { email });
    fetch("/nyayabot/api/auth/login.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email: email, password: password }),
      credentials: "include",
    })
      .then((response) => {
        console.log("Login response status:", response.status);
        if (!response.ok) {
          return response.json().then((err) => {
            throw new Error(
              err.message || `HTTP error! Status: ${response.status}`
            );
          });
        }
        return response.json();
      })
      .then((data) => {
        console.log("Login response data:", data);
        if (data.status === "success" && data.data) {
          currentUser = { email: data.data.email, user_id: data.data.user_id };
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
        alert(error.message || "Error logging in. Please try again.");
      });
  } else {
    alert("Please enter both email and password");
  }
}

function modalSignup() {
  const email = document.getElementById("modalEmail").value;
  const password = document.getElementById("modalPassword").value;
  const confirmPassword = document.getElementById("modalConfirmPassword").value;
  const name = document.getElementById("modalFullName").value;
  const phone = document.getElementById("modalPhone").value;
  console.log("Sending signup request:", { email, name, phone });
  if (email && password && confirmPassword && name && phone) {
    if (password !== confirmPassword) {
      alert("Passwords do not match. Please try again.");
      return;
    }
    fetch("/nyayabot/api/auth/register.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email, password, name, phone }),
      credentials: "include",
    })
      .then((response) => {
        console.log("Signup response status:", response.status);
        if (!response.ok) {
          return response.text().then((text) => {
            console.error("Raw response:", text);
            try {
              return JSON.parse(text);
            } catch (e) {
              throw new Error(`Non-JSON response: ${text || "Empty response"}`);
            }
          });
        }
        return response.json();
      })
      .then((data) => {
        console.log("Signup response data:", data);
        if (data.status === "success" && data.data) {
          currentUser = {
            email: data.data.email,
            user_id: data.data.user_id,
            name,
          };
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
        alert(error.message || "Error registering. Please try again.");
      });
  } else {
    alert("Please fill all fields");
  }
}

function logout() {
  fetch("/nyayabot/api/auth/logout.php", {
    method: "POST",
    credentials: "include",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Logout failed");
      }
      return response.json();
    })
    .then((data) => {
      if (data.status === "success") {
        currentUser = null;
        localStorage.removeItem("nyayabotUser");
        sessionStorage.clear();
        updateNavbar();
        alert("Logged out successfully!");
      } else {
        alert(data.message || "Logout failed");
      }
    })
    .catch((error) => {
      console.error("Logout error:", error);
      alert("Logout failed: " + error.message);
    });
}

// Language change functionality
function changeLanguage() {
  const select = document.getElementById("languageSelect");
  currentLanguage = select.value;
  updatePageText();
}

function updatePageText() {
  const t = translations[currentLanguage];

  const setTextContent = (id, content) => {
    const el = document.getElementById(id);
    if (el) el.textContent = content;
  };

  setTextContent("mainTitle", t.mainTitle);
  setTextContent("mainSubtitle", t.mainSubtitle);
  setTextContent("firTitle", t.firTitle);
  setTextContent("firDescription", t.firDescription);
  setTextContent("downloadBtnText", t.downloadBtnText);
  setTextContent("tipsTitle", t.tipsTitle);
  setTextContent("grievanceTitle", t.grievanceTitle);
  setTextContent("grievanceDescription", t.grievanceDescription);
  setTextContent("submitBtnText", t.submitBtnText);
  setTextContent("guideTitle", t.guideTitle);

  const tipsList = document.getElementById("tipsList");
  if (tipsList) {
    tipsList.innerHTML = "";
    t.tipsList.forEach((tip) => {
      const li = document.createElement("li");
      li.textContent = tip;
      tipsList.appendChild(li);
    });
  }

  if (document.getElementById("loginModal")?.classList.contains("show")) {
    const currentForm = document
      .getElementById("modalTitle")
      .textContent.includes(t.loginTitle)
      ? "login"
      : "signup";
    closeLoginModal();
    openLoginModal(currentForm);
  }
}

// Initialize the page
document.addEventListener("DOMContentLoaded", function () {
  loadUserData().then(() => {
    updatePageText();
    // No need to add event listener since onclick is handled in HTML
  });
});

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

  // Normalize the issue type to lowercase
  const normalizedType = grievanceType.toLowerCase().trim();

  // Show loading state
  guideSteps.innerHTML = '<li class="loading">Loading guidance...</li>';
  guideSection.style.display = "block";
  guideSection.scrollIntoView({ behavior: "smooth" });

  // Fetch guidance from the API using normalized type
  fetch(
    `/nyayabot/api/guidance.php?issue_type=${encodeURIComponent(
      normalizedType
    )}`
  )
    .then((response) => {
      if (!response.ok) {
        return response.text().then((text) => {
          throw new Error(
            `HTTP error! Status: ${response.status}, Response: ${text.substring(
              0,
              100
            )}...`
          );
        });
      }
      return response.json();
    })
    .then((data) => {
      if (data.error || !data.steps || data.steps.length === 0) {
        throw new Error(data.error || "No guidance available");
      }
      const steps = data.steps.map((step) => step.step_description);

      guideSteps.innerHTML = "";
      steps.forEach((step) => {
        const li = document.createElement("li");
        li.textContent = step;
        guideSteps.appendChild(li);
      });
    })
    .catch((error) => {
      console.error("Error fetching guidance:", error);
      // Fallback to static data if API fails
      const fallbackGuides = {
        theft: [
          "Ensure your immediate safety and seek medical attention if you or anyone else is injured during the incident.",
          "Immediately file an FIR at the nearest police station by calling 100 or 112, or visit in person.",
          "Prepare a detailed list of stolen items with approximate values and provide details for the FIR.",
          "Gather any evidence like CCTV footage, witness statements, or photographs, and preserve the crime scene if possible.",
          "Follow up with the investigating officer regularly and contact your insurance company if applicable.",
          "Consider consulting a lawyer for further legal recourse or compensation.",
        ],
        fraud: [
          "Collect all documents related to the fraud, including communications, transaction records, and witness details.",
          "If money is involved, immediately inform your bank or financial institution to freeze accounts or reverse transactions.",
          "File an FIR at the police station under relevant sections like IPC 420 for cheating.",
          "If it’s online fraud, file a complaint with the National Cyber Crime Reporting Portal at cybercrime.gov.in.",
          "Consult a lawyer for legal advice on recovery of losses and keep records of all communications.",
        ],
        assault: [
          "Seek immediate medical attention and obtain a medico-legal certificate from a government hospital.",
          "File an FIR immediately by reporting to the nearest police station or calling 100/112.",
          "Take photographs of injuries and preserve evidence such as clothing or witness statements.",
          "If applicable, undergo a medical examination as per legal requirements for assault cases.",
          "Consult a lawyer for further legal action and seek support from victim assistance services.",
        ],
        harassment: [
          "Document all instances of harassment with dates, times, descriptions, and save evidence like messages or recordings.",
          "If it’s workplace harassment, report to the Internal Complaints Committee (ICC) as per the POSH Act.",
          "File an FIR under relevant laws like IPC 354 for criminal force to outrage modesty.",
          "Seek help from helplines such as 1091 for women or other support services.",
          "Consider filing for a restraining order and consult a lawyer for legal remedies.",
          "Seek support from family and friends for emotional backing.",
        ],
        cyber: [
          "Do not delete any evidence; take screenshots of the cybercrime and act quickly.",
          "File a complaint at cybercrime.gov.in and report to your local cyber crime cell.",
          "Call the national helpline 1930 for immediate assistance.",
          "Provide all details including evidence like URLs and transaction IDs.",
          "Change all your passwords and monitor your bank accounts and credit reports.",
          "Visit a local cyber cell if needed and follow up on the complaint status.",
        ],
        domestic: [
          "Ensure your immediate safety: Leave the situation if possible and seek shelter with trusted friends, family, or a shelter home.",
          "Contact the National Domestic Violence Helpline: 181 or 1091 for immediate help.",
          "Document all incidents with dates, details, and seek medical attention for injuries.",
          "File an FIR or complaint under the Protection of Women from Domestic Violence Act (PWDVA).",
          "Apply for a protection order at the nearest police station or magistrate.",
          "Reach out to local support groups and NGOs for counseling and legal aid.",
        ],
        property: [
          "Gather all property-related documents, including title deeds, sale agreements, and inheritance proofs.",
          "Consult a property lawyer to understand your rights and options.",
          "Try mediation before going to court and send a legal notice to the other party.",
          "File a civil suit if necessary and get a title verification done.",
          "Consider approaching local authorities or alternative dispute resolution if unresolved.",
        ],
        other: [
          "Document your issue in detail, including all relevant details and evidence.",
          "Research the relevant laws or identify the appropriate authority (e.g., police, consumer court).",
          "Consult with a lawyer or legal aid service for personalized guidance.",
          "File appropriate complaints with relevant authorities and gather witness statements.",
          "Follow up regularly on your case for progress updates.",
        ],
      };

      // Use normalizedType for fallback lookup
      const fallbackSteps =
        fallbackGuides[normalizedType] || fallbackGuides.other;

      guideSteps.innerHTML = "";
      fallbackSteps.forEach((step) => {
        const li = document.createElement("li");
        li.textContent = step;
        guideSteps.appendChild(li);
      });

      guideSteps.insertAdjacentHTML(
        "afterend",
        '<p class="error-note">Note: Guidance loaded from fallback data due to an error. Details: ' +
          error.message +
          "</p>"
      );
    });
}


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
