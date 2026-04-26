<?php
    include("db.php");
    include("send_mailer.php");
    session_start();
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $stmt = $conn->prepare("DELETE FROM TASKS WHERE id = (?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $to = $_SESSION['email'];
        $subject = "Task Deleted";
        $task_name = $_SESSION["task_name"];
        $body = "Task $task_name has been deleted from your list.";
        sendEmail($to, $subject, $body);
    }
    header("location:index.php");