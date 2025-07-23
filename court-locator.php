<?php
$page_title = "Court Locations";
include('navbar.php');

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "root123";
$dbname = "nyayabot_db";
$port = 3307;

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Get filter parameters from URL or form
$court_type = isset($_GET['courtType']) ? $_GET['courtType'] : '';
$city = isset($_GET['locationSearch']) ? $_GET['locationSearch'] : '';

// Build SQL query
$sql = "SELECT * FROM courts";
$conditions = [];
$params = [];
if ($court_type) {
    $conditions[] = "court_type = :court_type";
    $params[':court_type'] = $court_type;
}
if ($city) {
    $conditions[] = "city LIKE :city";
    $params[':city'] = "%$city%";
}
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY city, court_name";
$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$courts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Default map (first court or fallback to Bombay High Court)
$default_map = !empty($courts) ? $courts[0]['iframe_src'] : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.0091782015334!2d72.82775377390043!3d18.930987882243908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7d14d7d8bb7f9%3A0x2ef2ec6fb96c1186!2sHIGH%20COURT%20OF%20BOMBAY!5e0!3m2!1sen!2sin!4v1752751954715!5m2!1sen!2sin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/court-locator.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLoginModal()">×</span>
            <h2 id="modalTitle">Login</h2>
            <div id="formContainer"></div>
            <p id="toggleFormText">Don't have an account? <a href="#" onclick="toggleForm('signup')">Sign Up</a></p>
        </div>
    </div>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">📍 Court Locations</h1>
        
        <div class="map-filter mb-6 flex flex-col sm:flex- sm:space-x-4">
            <select id="courtType" class="p-2 border rounded-md mb-2 sm:mb-0">
                <option value="" <?php echo $court_type == '' ? 'selected' : ''; ?>>All Courts</option>
                <option value="district" <?php echo $court_type == 'district' ? 'selected' : ''; ?>>District Courts</option>
                <option value="high" <?php echo $court_type == 'high' ? 'selected' : ''; ?>>High Courts</option>
                <option value="supreme" <?php echo $court_type == 'supreme' ? 'selected' : ''; ?>>Supreme Court</option>
            </select>
            <input type="text" id="locationSearch" placeholder="Search city (e.g., Mumbai, Delhi)" value="<?php echo htmlspecialchars($city); ?>" class="p-2 border rounded-md w-full sm:w-64">
            <button onclick="filterCourts()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mt-2 sm:mt-0">Search</button>
        </div>

        <div class="google-map mb-6">
            <iframe id="courtMap" class="w-full h-96 border-0 rounded-md shadow" src="<?php echo htmlspecialchars($default_map); ?>" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <div class="court-list bg-white p-4 rounded-md shadow">
            <h3 class="text-xl font-bold mb-3 text-gray-800">Frequently visited courts:</h3>
            <?php if (empty($courts)): ?>
                <p class="text-gray-600">No courts found. Try adjusting your search.</p>
            <?php else: ?>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <?php foreach ($courts as $court): ?>
                        <li class="cursor-pointer text-blue-600 hover:underline" onclick="showOnMap('<?php echo htmlspecialchars($court['iframe_src']); ?>', '<?php echo htmlspecialchars($court['court_name']); ?>')">
                            <?php echo htmlspecialchars($court['court_name'] . ' (' . $court['city'] . ')'); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/court-locator.js"></script>
    <script src="assets/js/script.js"></script>
    <footer class="bg-gray-800 text-white text-center p-4 mt-4">
        <p>&copy; 2025 NYAYABOT. All rights reserved.</p>
    </footer>
</body>
</html>
<?php $conn = null; ?>