<?php
ini_set('display_errors', 1);  // Enable error display
error_reporting(E_ALL);

// Start the session at the top of the script
session_start();

// Check if user_name and password are set in the POST request
if (isset($_POST['user_name']) && isset($_POST['password'])) {
    $un = $_POST['user_name'];
    $pw = $_POST['password'];
} else {
    echo json_encode(["status" => "ERROR", "message" => "Username or password not provided!"]);
    exit();
}

$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path . "/attendanceapp/database/database.php";
require_once $path . "/attendanceapp/database/facultyDetails.php";

$action = $_REQUEST["action"];
if (!empty($action)) {
    if ($action == "verifyUser") {
        // Sanitize the inputs to prevent SQL injection
        $un = htmlspecialchars($un, ENT_QUOTES, 'UTF-8');
        $pw = htmlspecialchars($pw, ENT_QUOTES, 'UTF-8');

        // Check if user exists in the database
        $dbo = new Database();
        $fdo = new faculty_details();
        $rv = $fdo->verifyUser($dbo, $un, $pw);

        // Debugging: Log the result to check what's returned
        error_log(print_r($rv, true)); // Logs the result in the PHP error log

        // Ensure that verifyUser returns a valid response
        if ($rv && isset($rv['status'])) {
            if ($rv['status'] == "ALL OK") {
                $_SESSION['current_user'] = $rv['id']; // Start a session for the user
            }
            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($rv);
        } else {
            // Handle invalid or failed responses
            echo json_encode(["status" => "ERROR", "message" => "User verification failed!"]);
        }
    }
}
?>
