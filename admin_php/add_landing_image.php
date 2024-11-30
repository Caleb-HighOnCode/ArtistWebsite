<?php

include 'config.php';
include 'functions.php';

session_start();
requireLogin();

// Handle landing image upload
if (isset($_POST['add_landing'])) {
    // $title = $_POST['title'];
    // $description = $_POST['description'];
    $image = $_FILES['image'];

    if ($image['size'] <= 500 * 1024) {  // 500 KB limit
        $image_name = time() . '_' . $image['name'];  // Corrected this line
        $target_file = "../uploads/" . basename($image_name);
        

        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $imageUrl = $target_file;
            $storeTarget = "uploads/" . basename($image_name);

            // Insert image details into the database
            $query = "INSERT INTO landing_page (imageUrl, title, description) VALUES ('$storeTarget', '', '')";
            if (mysqli_query($conn, $query)) {
                echo "New Landing Image added successfully!";
            } else {
                echo "<p class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>File upload error.</p>";
        }
    } else {
        echo "<p class='alert alert-danger'>Image size must be less than 500 KB.</p>";
    }
    exit;
}
?>