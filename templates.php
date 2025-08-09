
<?php
$page_title = "Legal Templates - NYAYABOT";
include('navbar.php');

$templates = [
    ['name' => 'First Information Report (FIR)', 'file' => 'assets/templates/FIR_Template.pdf', 'description' => 'File a police complaint with detailed incident information.', 'tooltip' => 'Ensure all details are accurate before submission.'],
    ['name' => 'Rental Agreement', 'file' => 'assets/templates/rent_agreement.pdf', 'description' => 'For residential landlord-tenant contracts.', 'tooltip' => 'Customize rent and deposit fields as needed.'],
    ['name' => 'Last Will and Testament', 'file' => 'assets/templates/will.pdf', 'description' => 'For estate planning and asset distribution.', 'tooltip' => 'Requires two witnesses and notarization.'],
    ['name' => 'Legal Notice (Cheque Bounce)', 'file' => 'assets/templates/legal_notice.pdf', 'description' => 'Notice for dishonored cheques under Section 138.', 'tooltip' => 'Specify cheque details and payment deadline.']
];
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
    <link rel="stylesheet" href="assets/css/templates.css">
</head>
<body>
    <div class="main-content">
        <div class="header">
            <h1>📄 Legal Templates</h1>
            <p>Select and download legal documents tailored to your needs</p>
        </div>
        <div class="content-grid">
            <div class="content-card">
                <h2>Select Template</h2>
                <p>Choose a template to download a fillable PDF document.</p>
                <select id="templateSelect" class="grievance-select">
                    <option value="">Select a template</option>
                    <?php foreach ($templates as $index => $template): ?>
                        <option value="<?= $index ?>"><?= htmlspecialchars($template['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="templateDetails" class="template-form" style="display: none; margin-top: 1.5rem;">
                    <input type="text" id="templateNameInput" placeholder="Your Name" class="auto-fill" data-field="party_name">
                    <a id="downloadPdfBtn" href="#" class="download-btn" download style="display: none;">Download PDF</a>
                    <a id="downloadWordBtn" href="#" class="download-btn disabled" onclick="alert('Word download not yet implemented.');" style="display: none;">Download as Word</a>
                    <span id="templateTooltip" class="tooltip">?<span class="tooltiptext"></span></span>
                </div>
            </div>
        </div>
        <div class="disclaimer">
            <p><strong>Note:</strong> These templates are for general reference only. Consult a lawyer for your specific situation.</p>
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

    <script src="assets/js/script.js"></script>
    <script>
        // Template selection and download logic
        $(document).ready(function() {
            const templates = <?php echo json_encode($templates); ?>;
            $('#templateSelect').on('change', function() {
                const index = $(this).val();
                const $details = $('#templateDetails');
                if (index) {
                    const template = templates[index];
                    $('#templateNameInput').val(''); // Reset input
                    $('#downloadPdfBtn').attr('href', template.file).show();
                    $('#downloadWordBtn').show();
                    $('#templateTooltip .tooltiptext').text(template.tooltip);
                    $details.show();
                } else {
                    $details.hide();
                    $('#downloadPdfBtn').hide();
                    $('#downloadWordBtn').hide();
                }
            });

            // Auto-fill name across inputs (if multiple forms added later)
            $('.auto-fill[data-field="party_name"]').on('input', function() {
                let name = $(this).val();
                $('.auto-fill[data-field="party_name"]').val(name);
            });
        });

    
    </script>
      <footer class="bg-gray-800 text-white text-center p-4 mt-4">
  <p>&copy; 2025 NYAYABOT. All rights reserved.</p>
    </footer>
</body>
</html>
