<?php
include './admin_php/config.php';
include './admin_php/functions.php';

session_start();
requireLogin();

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the video
    $delete_sql = "DELETE FROM videos WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Redirect after deletion
    header("Location: admin_page.php");
    exit();
}

if (isset($_POST['delete_landing_image'])) {
    $image_id = $_POST['image_id'];

    // Get image URL to delete from filesystem
    $result = mysqli_query($conn, "SELECT imageUrl FROM landing_page WHERE id = $image_id");
    $image = mysqli_fetch_assoc($result);

    if ($image) {
        // Delete the file from the filesystem
        if (unlink($image['imageUrl'])) {
            // Remove the image record from the database
            $deleteQuery = "DELETE FROM landing_page WHERE id = $image_id";
            if (mysqli_query($conn, $deleteQuery)) {
                echo "<p class='alert alert-success m-2'>Landing Image deleted successfully.</p>";
            } else {
                echo "<p class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>Failed to delete image file.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom styles */
        .container {
            margin-top: 50px;
        }
        
        a{
            text-decoration: none;
        }

        .container-fluid{
            max-width: 1400px;
        }

        .modal .modal-dialog {
            max-width: 800px;
        }

        .image-wrapper {
            position: relative;
        }

        .image-wrapper .fa-times {
            position: absolute;
            top: 0;
            right: 0;
            background: white;
            border-radius: 50%;
            padding: 2px;
        }

        label.error {
            font-size: 12px;
            color: #FF0000;
        }

        .nav-link.active {
            color: #007bff !important;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="container-fluid mt-3">
        <h2>Welcome, Admin!</h2>
        <div id="message"></div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <hr>
    </div>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="sidebar-sticky bg-light">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-secondary active" href="#projectsSection" data-toggle="tab">My Art Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#contactSection" data-toggle="tab">Contact
                                Forms</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-3 mt-0">
                <div class="tab-content">
                    <div class="tab-pane show active" id="projectsSection">
                        <!-- Add Project Button -->
                        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addProjectModal">Add New
                            Art</button>

                        <!-- Projects Cards -->
                        <div class="row" id="projectCards">
                            <?php
                            // Fetch all projects
                            $sql = "SELECT * FROM projects";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($project = $result->fetch_assoc()) {
                                    // Fetch images for the current project
                                    $projectId = $project['project_id'];
                                    $imgSql = "SELECT image_url FROM images WHERE project_id = $projectId LIMIT 1";
                                    $imgResult = $conn->query($imgSql);

                                    // Prepare images HTML
                                    $imagesHtml = '';
                                    while ($image = $imgResult->fetch_assoc()) {
                                        $imageUrl = $image['image_url'] ?? 'path/to/default/image.jpg';
                                        $imageSrc = strpos($imageUrl, '../') === 0 ? substr($imageUrl, 3) : $imageUrl;
                                        $imageSrc = $imageSrc ? $imageSrc : 'path/to/default/image.jpg';
                                        $imagesHtml .= "<img src='{$imageSrc}' class='card-img-top' alt='Project Image' style='width:100%;object-fit:contain;height:200px;margin: 5px;'>";
                                    }

                                    // If no images are found, use a default image
                                    if (empty($imagesHtml)) {
                                        $imagesHtml = "<img src='path/to/default/image.jpg' class='card-img-top' alt='Default Image' style='width:100%;object-fit:contain;height:200px;margin: auto;'>";
                                    }

                                    // Output the card HTML
                                    echo "
                                        <div class='col-md-6'>
                                            <div class='card mb-4'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>{$project['project_name']}</h5>
                                                    <p class='card-text'>{$project['description']}</p>
                                                    <p class='card-text'>
                                                        <small class='text-muted'>
                                                            Status: {$project['status']} | 
                                                            Date: {$project['date']} | 
                                                            Price: {$project['price']}
                                                        </small>
                                                    </p>
                                                    <!-- Display all images -->
                                                    <div class='d-flex flex-wrap mb-2'>
                                                        {$imagesHtml}
                                                    </div>
                                                    <button class='btn btn-info btn-sm editBtn' data-id='{$project['project_id']}'>Edit</button>
                                                    <button class='btn btn-danger btn-sm deleteBtn' data-id='{$project['project_id']}'>Delete</button>
                                                </div>
                                            </div>
                                        </div>";
                                }
                            } else {
                                echo "<p class='text-center'>No Projects Found</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contactSection">
                        <h4 class="mb-2">Contact Form Submissions</h4>
                        <div class="table-responsive" id="contact-table"></div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addProjectForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProjectModalLabel">Add New Art</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="project_name">Art Name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                                <!-- <option value="Completed">Completed</option> -->
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div> -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="images">Upload Images</label>
                            <input type="file" class="form-control-file" id="images" name="images[]">
                        </div>

                        <div id="preview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Art</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editProjectForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProjectModalLabel">Edit Art</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_project_id" name="project_id">
                        <!-- The same form structure as the Add Project Modal -->
                        <div class="form-group">
                            <label for="edit_project_name">Art Name</label>
                            <input type="text" class="form-control" id="edit_project_name" name="project_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="date" class="form-control" id="edit_date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Price</label>
                            <input type="number" class="form-control" id="edit_price" name="price" required>
                        </div>

                        <!-- Preview Existing Images -->
                        <div class="form-group">
                            <label for="edit_images">Existing Images</label>
                            <div id="editPreview" class="d-flex flex-wrap"></div>
                        </div>

                        <!-- File Input for New Images -->
                        <div class="form-group">
                            <label for="edit_images">Replace New Image (Optional)</label>
                            <input type="file" class="form-control-file" id="edit_images" name="images[]">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Art</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this project?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function confirmAction(message, action) {
            $('#confirmationText').text(message);
            $('#confirmBtn').off('click').click(function () {
                action();
                $('#confirmationModal').modal('hide');
            });
            $('#confirmationModal').modal('show');
        }

        function loadContact() {
            $("#contact-table").load('./admin_php/fetch_contact.php');
        }

        function deleteContact(id) {
            if (confirm('Are you sure you want to delete this contact?')) {
                $.post('./admin_php/delete_contact.php', {
                    id: id
                }, function (data) {
                    $("#message").html('<div class="alert alert-success">' + data + '</div>');
                    loadContact();
                }).fail(function () {
                    $("#message").html('<div class="alert alert-danger">An error occurred.</div>');
                });
            }
        }

        $(document).ready(function () {
            loadContact();
        })

        $(document).ready(function () {
            var fileArray = [];
            var existingImageArray = [];
            var removedImageArray = []; // To track the images that need to be removed

            // Show the edit modal and fetch project details including images
            $('.editBtn').on('click', function () {
                var projectId = $(this).data('id');

                // AJAX request to fetch project details and associated images
                $.ajax({
                    url: './admin_php/project_edit_handler.php', // The PHP file handling this request
                    type: 'GET',
                    data: {
                        project_id: projectId
                    },
                    dataType: 'json',
                    success: function (response) {
                        // Fill the form with the project details                        
                        $('#edit_project_id').val(response.project.project_id);
                        $('#edit_project_name').val(response.project.project_name);
                        $('#edit_description').val(response.project.description);
                        $('#edit_date').val(response.project.date);
                        $('#edit_status').val(response.project.status);
                        $('#edit_price').val(response.project.price);

                        // Reset arrays and previews
                        fileArray = [];
                        existingImageArray = response.images; // Set existing images
                        updateEditPreview(); // Show existing images
                        $('#editProjectModal').modal('show'); // Show the edit modal
                    }
                });
            });

            // Handle new file selection for edit modal
            $('#edit_images').on('change', function () {
                var newFiles = Array.from(this.files);
                fileArray = fileArray.concat(newFiles); // Add new files to fileArray
                updateEditPreview(); // Update the preview with new and existing images
            });

            // Function to update the preview area with both existing and new images
            function updateEditPreview() {
                $('#editPreview').empty(); // Clear previous previews

                // Show existing images
                existingImageArray.forEach(function (image) {
                    var imageSrc = image.image_url.startsWith('../') ? image.image_url.slice(3) : image
                        .image_url;

                    $('#editPreview').append(`
                        <div class="image-wrapper position-relative d-inline-block">
                            <img src="${imageSrc}" class="m-3" height="100">
                            <span class="position-absolute top-0 end-0 p-1" style="cursor:pointer;">
                                <i class="fas fa-times text-danger" data-existing-id="${image.image_id}"></i>
                            </span>
                        </div>
                    `);
                });

                // Show newly selected images
                fileArray.forEach(function (file, index) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#editPreview').append(`
                            <div class="image-wrapper position-relative d-inline-block">
                                <img src="${e.target.result}" class="m-3" height="100">
                                <span class="position-absolute top-0 end-0 p-1">
                                    <i class="fas fa-times text-danger" style="cursor: pointer;" data-new-index="${index}"></i>
                                </span>
                            </div>
                        `);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Handle removal of images in the preview area
            $('#editPreview').on('click', '.fa-times', function () {
                var existingId = $(this).data('existing-id'); // ID of existing image in the database
                var newIndex = $(this).data('new-index'); // Index of newly added images

                if (existingId !== undefined) {
                    // Add the existing image's ID to the removedImageArray
                    removedImageArray.push(existingId);

                    // Filter out the removed image from the existingImageArray
                    existingImageArray = existingImageArray.filter(image => image.image_id != existingId);
                } else if (newIndex !== undefined) {
                    // Remove the new image from the fileArray
                    fileArray.splice(newIndex, 1);
                    var dataTransfer = new DataTransfer();
                    fileArray.forEach(file => dataTransfer.items.add(file));
                    $('#edit_images')[0].files = dataTransfer.files;
                }

                // Refresh the preview with the remaining images
                updateEditPreview();
            });

            // Handle form submission for edit
            $('#editProjectForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'update');
                formData.append('removed_images', JSON.stringify(removedImageArray));

                if ($(this).valid()) {
                    $.ajax({
                        url: './admin_php/project_handlers.php', // Ensure this points to the correct PHP file
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            // Handle success
                            console.log('success');
                            alert(response);
                            location.reload();

                            // Reload or refresh the project cards/list
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error: " + status + " - " + error);
                        }
                    });
                }
            });

            $('#editProjectForm').validate({
                rules: {
                    project_name: {
                        required: true,
                        minlength: 2
                    },
                    description: {
                        required: true,
                        minlength: 10
                    },
                    date: {
                        required: true,
                        date: true
                    },
                    status: {
                        required: true
                    },
                    category: {
                        required: true
                    },
                    'images[]': {
                        extension: "jpg|jpeg|png|gif",
                        filesize: 500 * 1024 // 500 KB
                    }
                },
                messages: {
                    'images[]': {
                        extension: "Please upload an image file (jpg, jpeg, png, gif).",
                        filesize: "Each image must be less than 500 KB."
                    }
                }
            });

            $.validator.addMethod('filesize', function (value, element, maxSize) {
                if (element.files.length > 0) {
                    return element.files[0].size <= maxSize;
                }
                return true;
            }, 'File size must be less than {0} bytes.');

        });
    </script>

    <script>
        $(document).ready(function () {

            var fileArray = [];

            // Handle file selection
            $('input[type="file"]').on('change', function () {
                var newFiles = Array.from(this.files);
                fileArray = fileArray.concat(newFiles);
                updatePreview();
            });

            // Update the preview with fileArray
            function updatePreview() {
                $('#preview').empty(); // Clear previous previews

                fileArray.forEach((file, index) => {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').append(`
                    <div class="image-wrapper position-relative d-inline-block">
                        <img src="${e.target.result}" class="m-3" height="100">
                        <span class="position-absolute top-0 end-0 p-1">
                            <i class="fas fa-times text-danger" style="cursor: pointer;" data-index="${index}"></i>
                        </span>
                    </div>
                `);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Handle the removal of files
            $('#preview').on('click', '.fa-times', function () {
                var indexToRemove = $(this).data('index');
                fileArray.splice(indexToRemove, 1); // Remove file from fileArray
                updatePreview(); // Refresh the preview

                // Update the file input
                var dataTransfer = new DataTransfer();
                fileArray.forEach(file => dataTransfer.items.add(file));
                $('input[type="file"]')[0].files = dataTransfer.files;
            });

            // Add New Project
            $('#addProjectForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'add');

                if ($(this).valid()) {
                    $.ajax({
                        url: './admin_php/project_handlers.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            alert(response);
                            location.reload();
                        }
                    });
                }
            });

            $('#addProjectForm').validate({
                rules: {
                    project_name: {
                        required: true,
                        minlength: 2
                    },
                    description: {
                        required: true,
                        minlength: 10
                    },
                    date: {
                        required: true,
                        date: true
                    },
                    status: {
                        required: true
                    },
                    price: {
                        required: true
                    },
                    'images[]': {
                        extension: "jpg|jpeg|png|gif",
                        filesize: 500 * 1024 // 500 KB
                    }
                },
                messages: {
                    'images[]': {
                        extension: "Please upload an image file (jpg, jpeg, png, gif).",
                        filesize: "Each image must be less than 500 KB."
                    }
                }
            });

            // Delete Project Button Click
            $('.deleteBtn').on('click', function () {
                var projectId = $(this).data('id');
                $('#confirmDeleteBtn').data('id', projectId);
                $('#deleteConfirmationModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDeleteBtn').on('click', function () {
                var projectId = $(this).data('id');

                $.ajax({
                    url: './admin_php/project_handlers.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        project_id: projectId
                    },
                    success: function (response) {
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>

</html>