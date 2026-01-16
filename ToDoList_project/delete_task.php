<?php
    include("db.php");
    $id = $_GET["id"];
    $stmt = $conn->prepare("UPDATE TASKS SET IS_COMPLETED = 3 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("location:index.php");
    exit();
?>