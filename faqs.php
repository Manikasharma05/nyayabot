<?php
$page_title = "FAQs - NYAYABOT";
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
    <link rel="stylesheet" href="assets/css/faqs.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh; justify-content: center;">
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLoginModal()">×</span>
            <h2 id="modalTitle">Login</h2>
            <div id="formContainer"></div>
            <p id="toggleFormText">Don't have an account? <a href="#" onclick="toggleForm('signup')">Sign Up</a></p>
        </div>
    </div>
    <div class="faqs-container">
        <h1>❓ Frequently Asked Questions</h1>
        <div class="faq-item">
            <h3>What is NYAYABOT, and how can it help me with legal matters?</h3>
            <p>NYAYABOT is a platform designed to assist with legal needs by providing tools like a Cost Estimator, downloadable legal templates, and emergency contacts. It offers general guidance, but for specific legal advice, consult a licensed attorney.</p>
        </div>
        <div class="faq-item">
            <h3>How accurate are the legal cost estimates provided by the Cost Estimator?</h3>
            <p>The estimates are based on average fees for various states and case types in India. They are approximate and may vary depending on court level, case complexity, and local regulations. For precise costs, consult a lawyer.</p>
        </div>
        <div class="faq-item">
            <h3>Are the legal templates provided customizable, and do they require a lawyer’s review?</h3>
            <p>Yes, the templates are customizable to suit your needs. However, we recommend having them reviewed by a legal professional to ensure they meet your specific requirements and comply with local laws.</p>
        </div>
        <div class="faq-item">
            <h3>How do I use the Emergency Contacts page to get help?</h3>
            <p>Visit the Emergency Contacts page, search for the relevant contact using the search box, and use the provided numbers for assistance. Ensure you verify the contact details before proceeding.</p>
        </div>
        <div class="faq-item">
            <h3>Is my personal information safe when using NYAYABOT?</h3>
            <p>Yes, we prioritize your privacy. Personal data is handled securely, but avoid sharing sensitive information unless necessary. For more details, refer to our privacy policy.</p>
        </div>
        <div class="faq-item">
            <h3>What should I do if I encounter an error on the website?</h3>
            <p>If you encounter an error, try refreshing the page or clearing your browser cache. If the issue persists, contact our support team via the contact information provided on the website.</p>
        </div>
        <div class="faq-item">
            <h3>Are the services on NYAYABOT free, or is there a subscription?</h3>
            <p>NYAYABOT offers free access with limited usage. For higher quotas, consider a subscription. Visit <a href="https://x.ai/grok" target="_blank">https://x.ai/grok</a> for more details on plans.</p>
        </div>
        <div class="faq-item">
            <h3>How can I contact support if I need assistance?</h3>
            <p>You can reach our support team by emailing support@nyayabot.com or using the contact form available on the website. We aim to respond within 24-48 hours.</p>
        </div>
    </div>
    <footer class="bg-gray-800 text-white text-center p-4 mt-4">
        <p>&copy; 2025 NYAYABOT. All rights reserved.</p>
    </footer>
    <script src="assets/js/script.js"></script>
    <script>
        document.querySelectorAll('.faq-item h3').forEach(item => {
            item.addEventListener('click', function() {
                this.parentElement.classList.toggle('active');
            });
        });
    </script>
</body>
</html>