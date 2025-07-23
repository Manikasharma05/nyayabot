<?php 
include('navbar.php');
$host = '127.0.0.1';
$db   = 'nyayabot_db';
$user = 'root';
$pass = 'root123';
$charset = 'utf8mb4';
$port = 3307;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT 1");
    if ($stmt) {
        error_log("Database connection successful");
    }
} catch(PDOException $e) {  
    die("Database error: " . $e->getMessage());
}

// Enhanced fee calculation logic
$fee = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $state = strtolower($_POST['state'] ?? '');
    $caseType = strtolower($_POST['caseType'] ?? '');
    
    $feeMatrix = [
        'maharashtra' => ['civil' => 850, 'criminal' => 500, 'family' => 1200],
        'delhi' => ['civil' => 950, 'criminal' => 600, 'family' => 1500],
        'karnataka' => ['civil' => 750, 'criminal' => 450, 'family' => 1100],
        'tamil nadu' => ['civil' => 700, 'criminal' => 400, 'family' => 1000],
        'west bengal' => ['civil' => 650, 'criminal' => 350, 'family' => 900],
        'default' => ['civil' => 800, 'criminal' => 500, 'family' => 1150]
    ];
    
    try {
        if (isset($feeMatrix[$state][$caseType])) {
            $fee = $feeMatrix[$state][$caseType];
        } 
        elseif (isset($feeMatrix[$state])) {
            $fee = $feeMatrix[$state]['civil'];
            $error = "Exact fee not available. Showing approximate civil case fee.";
        }
        else {
            $fee = $feeMatrix['default'][$caseType] ?? $feeMatrix['default']['civil'];
            $error = "State data unavailable. Showing national average.";
        }
    } catch (Exception $e) {
        $error = "Calculation error. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Legal Cost Estimator</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/costestimator.css">
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
    <div class="calculator">
        <h2>💰 Legal Cost Estimator</h2>
        <form method="POST">
            <label for="state">State:</label>
            <select id="state" name="state" required>
                <option value="">-- Select State --</option>
                <option value="maharashtra">Maharashtra</option>
                <option value="delhi">Delhi</option>
                <option value="karnataka">Karnataka</option>
                <option value="tamil nadu">Tamil Nadu</option>
                <option value="west bengal">West Bengal</option>
                <option value="uttar pradesh">Uttar Pradesh</option>
            </select>
            
            <label for="caseType">Case Type:</label>
            <select id="caseType" name="caseType" required>
                <option value="">-- Select Case Type --</option>
                <option value="civil">Civil Case</option>
                <option value="criminal">Criminal Case</option>
                <option value="family">Family Dispute</option>
            </select>
            
            <button type="submit">Calculate Estimated Fee</button>
        </form>
        
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="result">
                <?php if ($error): ?>
                    <p class="error">⚠️ <?= $error ?></p>
                <?php endif; ?>
                Estimated Fee: ₹<?= number_format($fee) ?>
                <p><small>Note: Fees vary by court level and case complexity. Consult a lawyer for exact amounts.</small></p>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-gray-800 text-white text-center p-4 mt-4">
        <p>&copy; 2025 NYAYABOT. All rights reserved.</p>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>