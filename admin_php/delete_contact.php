<?php

include 'config.php';
include 'functions.php';

session_start();
requireLogin();

$id = $_POST['id'];

$sql = "DELETE FROM contact_form WHERE id = $id";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>