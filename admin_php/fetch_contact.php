<?php
// Include your database configuration file here
include 'config.php';
include 'functions.php';

session_start();
requireLogin();
$query_contact = "SELECT * FROM contact_form ORDER BY created_at DESC";
$result_contact = mysqli_query($conn, $query_contact);
?>

<table class="table table-bordered">
    <thead>
        <tr class='thead-dark'>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Date/Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result_contact) > 0) {
            while ($row_contact = mysqli_fetch_assoc($result_contact)) {
                echo "<tr>";
                echo "<td>" . $row_contact['name'] . "</td>";
                echo "<td>" . $row_contact['email'] . "</td>";
                echo "<td>" . $row_contact['phone'] . "</td>";
                echo "<td>" . $row_contact['message'] . "</td>";
                echo "<td>" . $row_contact['created_at'] . "</td>";
                echo "<td><button class='btn btn-danger mr-2' onclick='deleteContact(" . $row_contact["id"] . ")'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No contact form submissions found</td></tr>";
        }
        ?>
    </tbody>
</table>