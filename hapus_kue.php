<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$id = $_GET['id'];
$result = $conn->query("SELECT foto FROM kue WHERE id = $id");
$kue = $result->fetch_assoc();

unlink('uploads/' . $kue['foto']);
$conn->query("DELETE FROM kue WHERE id = $id");
header("Location: dashboard.php");
?>