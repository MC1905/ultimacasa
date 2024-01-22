<?php
session_start(); // Start the session

include_once("functions.php");

// Get user input and sanitize it
$email = filter_input(INPUT_GET, "Email", FILTER_SANITIZE_EMAIL);
$password = md5(filter_input(INPUT_GET, "Wachtwoord", FILTER_SANITIZE_STRING));

// Debugging: Output entered email and hashed password
var_dump("Entered Email: " . $email);
var_dump("Entered Password: " . $password);

$db = ConnectDB();

// Use prepared statement to avoid SQL injection
$sql = "SELECT relaties.ID AS RID, rollen.Waarde AS Rol, Landingspagina, Wachtwoord
        FROM relaties
        LEFT JOIN rollen ON relaties.FKrollenID = rollen.ID
        WHERE BINARY Email = :email";
$stmt = $db->prepare($sql);
if (!$stmt) {
    die('Error preparing statement: ' . print_r($db->errorInfo(), true));
}

$stmt->bindParam(":email", $email, PDO::PARAM_STR);
if (!$stmt->execute()) {
    die('Error executing statement: ' . print_r($stmt->errorInfo(), true));
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

// Debugging: Output retrieved password from the database
if ($result !== false) {
    var_dump("Database Password: " . $result['Wachtwoord']);

    $redirect_url = 'admin.php?NOAccount';
    if (md5($password) === $result['Wachtwoord']) {
        // Start a session and store user information
        $_SESSION['user_id'] = $result['RID'];
        $_SESSION['user_role'] = $result['Rol'];

        $redirect_url = 'index.php'; // Set the index page as the redirect URL after successful login
    }
} else {
    // Handle the case where the email is not found in the database
    $redirect_url = 'admin.php?EmailNotFound';
}

// Redirect to the specified page
header("index.php: " . $redirect_url);
exit();
?>
