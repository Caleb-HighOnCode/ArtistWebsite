<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config.php';

session_start();

// Check if the form has been submitted from this session
if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
    echo "You've already submitted the form.";
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $country = $_POST['country'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $message = $_POST['message'] ?? null;
    $whatsapp = isset($_POST['whatsapp']) ? 1 : 0;

    // Validate input data
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "Required fields are missing.";
        exit();
    }

    $fullPhone = "{$country} {$phone}";  // Combines country code and phone number

    // Prepare an SQL statement for safe insertion
    $insertQuery = $conn->prepare("INSERT INTO contact_form (name, email, phone, message, whatsapp) VALUES (?, ?, ?, ?, ?)");
    $insertQuery->bind_param("ssssi", $name, $email, $fullPhone, $message, $whatsapp);

    // Execute the prepared statement
    if ($insertQuery->execute()) {
        $_SESSION['form_submitted'] = true;
        $_SESSION['contact_form_id'] = $conn->insert_id;  // Save the inserted ID in the session
        echo "Form submitted successfully.";
    } else {
        echo "Error: " . $insertQuery->error;
    }

    // Close the statement and connection
    $insertQuery->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
