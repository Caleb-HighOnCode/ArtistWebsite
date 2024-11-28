<?php
include 'config.php';
include 'functions.php';

session_start();
requireLogin();

// Check which action is requested
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Fetch Project Data
    if ($action == 'fetch') {
        $project_id = $_POST['project_id'];
        $sql = "SELECT * FROM projects WHERE project_id = $project_id";
        $landing_page_images = $conn->query($sql);

        if ($landing_page_images->num_rows > 0) {
            $project = $landing_page_images->fetch_assoc();
            echo json_encode(['status' => 'success', 'data' => $project]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    // Update Project Data
    if ($action == 'update') {
        $project_id = $_POST['project_id'];
        $project_name = $_POST['project_name'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $price = $_POST['price'];
    
        // Update the project details using prepared statements
        $stmt = $conn->prepare("UPDATE projects SET project_name = ?, description = ?, date = ?, status = ?, price = ?, WHERE project_id = ?");
        $stmt->bind_param("ssssi", $project_name, $description, $date, $status, $price, $project_id);
    
        if ($stmt->execute()) {
            // Handle removed images
            if (!empty($_POST['removed_images'])) {
                $removedImages = json_decode($_POST['removed_images']);
                foreach ($removedImages as $image_id) {
                    // Check if the image exists before attempting to delete
                    $check_stmt = $conn->prepare("SELECT image_url FROM images WHERE image_id = ?");
                    $check_stmt->bind_param("i", $image_id);
                    $check_stmt->execute();
                    $result = $check_stmt->get_result();
    
                    if ($result->num_rows > 0) {
                        $image_row = $result->fetch_assoc();
                        $image_path = $image_row['image_url'];
    
                        // Delete image file from server
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }
    
                        // Delete image from the database
                        $del_stmt = $conn->prepare("DELETE FROM images WHERE image_id = ?");
                        $del_stmt->bind_param("i", $image_id);
                        if (!$del_stmt->execute()) {
                            error_log("Error deleting image: " . $del_stmt->error);
                        }
                    }
                    $check_stmt->close();
                }
            }
    
            // Handle new image uploads
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $image_name = time() . '_' . $_FILES['images']['name'][$key];
                    $target_file = "../uploads/" . basename($image_name);
    
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $img_stmt = $conn->prepare("INSERT INTO images (project_id, image_url) VALUES (?, ?)");
                        $img_stmt->bind_param("is", $project_id, $target_file);
                        if (!$img_stmt->execute()) {
                            error_log("Error inserting image: " . $img_stmt->error);
                        }
                    }
                }
            }
    
            echo "Project updated successfully!";
        } else {
            echo "Error updating project: " . $stmt->error;
        }
    
        $stmt->close();
        exit;
    }    

    // Delete Project
    if ($action == 'delete') {
        $project_id = $_POST['project_id'];

        // Delete images from server
        $img_sql = "SELECT image_url FROM images WHERE project_id = $project_id";
        $img_result = $conn->query($img_sql);
        if ($img_result->num_rows > 0) {
            while ($img_row = $img_result->fetch_assoc()) {
                if (file_exists($img_row['image_url'])) {
                    unlink($img_row['image_url']);
                }
            }
        }

        // Delete project and images from database
        $del_project_sql = "DELETE FROM projects WHERE project_id = $project_id";

        if ($conn->query($del_project_sql) === TRUE) {
            echo "Project deleted successfully!";
        } else {
            echo "Error deleting project: " . $conn->error;
        }
        exit;
    }

    // Add New Project
    if ($action == 'add') {
        $project_name = $_POST['project_name'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $price = $_POST['price'];

        $sql = "INSERT INTO projects (project_name, description, date, status, price) 
                VALUES ('$project_name', '$description', '$date', '$status', '$price')";

        if ($conn->query($sql) === TRUE) {
            $project_id = $conn->insert_id;

            // Handle image uploads
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $image_name = time() . '_' . $_FILES['images']['name'][$key];
                    $target_file = "../uploads/" . basename($image_name);

                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $img_sql = "INSERT INTO images (project_id, image_url) VALUES ('$project_id', '$target_file')";
                        $conn->query($img_sql);
                    }
                }
            }
            echo "New project added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        exit;
    }
}

// If there's no action, or the action is invalid, return an error
echo "Invalid action!";
