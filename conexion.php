<?php
$conn = mysqli_connect("localhost", "root", "", "restaurant");

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>