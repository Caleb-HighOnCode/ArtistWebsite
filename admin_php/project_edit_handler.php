<?php
include 'config.php';
include 'functions.php';

session_start();
requireLogin();

// Fetch project details based on the project_id when the edit button is clicked
if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];

    // Fetch project details
    $project_sql = "SELECT * FROM projects WHERE project_id = $project_id";
    $project_result = $conn->query($project_sql);

    // Fetch associated images for the project
    $images_sql = "SELECT * FROM images WHERE project_id = $project_id";
    $images_result = $conn->query($images_sql);

    $project = $project_result->fetch_assoc();

    // Prepare the response
    $response = [
        'project' => $project,
        'images' => []
    ];

    while ($row = $images_result->fetch_assoc()) {
        $response['images'][] = $row;
    }

    // Send response as JSON (for AJAX consumption)
    echo json_encode($response);
    exit();
}
