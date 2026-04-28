<?php
    include("db.php");
    include("send_mailer.php");

    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    if (isset($_POST["submit"])) {
        if ($_SERVER["REQUEST_METHOD"]  == "POST") {
            if (isset($_POST["task_name"])) {
                $task_name = htmlspecialchars($_POST["task_name"]);
                $_SESSION["task_name"] = $task_name;
                $user_id = $_SESSION['user_id'];
                $stmt = $conn->prepare("INSERT INTO TASKS (task_name, user_id) VALUES (?, ?)");
                $stmt->bind_param("si", $task_name, $user_id);
                $stmt->execute();
                $stmt->close();

                $to = $_SESSION['email'];
                $subject = "New Task Added";
                $body = "A new task has been added to your list: " . $task_name;
                sendEmail($to, $subject, $body);
            }
        }
    }

    //Edit Task
    $edit_task = null;
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("SELECT * FROM TASKS WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $edit_task = $result->fetch_assoc();
        }
    }

    if (isset($_POST['update'])) {
        $task_name = htmlspecialchars($_POST['task_name']);
        $id = $_POST['id'];
        $user_id = $_SESSION['user_id'];
        $_SESSION["task_name"] = $task_name;
        $stmt = $conn->prepare("UPDATE TASKS SET task_name = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $task_name, $id, $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?updated=1");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $open_task = $conn->prepare("SELECT * FROM TASKS WHERE IS_COMPLETED = 0 AND user_id = ?");
    $open_task->bind_param("i", $user_id);
    $open_task->execute();
    $open_task = $open_task->get_result();

    $tasks_inprogress = $conn->prepare("SELECT * FROM TASKS WHERE IS_COMPLETED = 2 AND user_id = ?");
    $tasks_inprogress->bind_param("i", $user_id);
    $tasks_inprogress->execute();
    $tasks_inprogress = $tasks_inprogress->get_result();

    $closed_task = $conn->prepare("SELECT * FROM TASKS WHERE IS_COMPLETED = 1 AND user_id = ?");
    $closed_task->bind_param("i", $user_id);
    $closed_task->execute();
    $closed_task = $closed_task->get_result();

    $deleted_task = $conn->prepare("SELECT * FROM TASKS WHERE IS_COMPLETED = 3 AND user_id = ?");
    $deleted_task->bind_param("i", $user_id);
    $deleted_task->execute();
    $deleted_task = $deleted_task->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>TO DO LIST APP</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">To-Do App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <?php
            if (isset($_POST["submit"])) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["task_name"])) {
                        echo "<div class='alert alert-success'>Task added successfully!</div>";
                    }
                }
            } else if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
                echo "<div class='alert alert-danger'>Task deleted successfully!</div>";
                header("Refresh: 2; url=index.php");
            } else if (isset($_GET['updated']) && $_GET['updated'] == 1) {
                echo "<div class='alert alert-warning'>Task updated successfully!</div>";
                header("Refresh: 2; url=index.php");
            }
        ?>
        <h1 class="text-center">To Do list with Othmane</h1>
        <form action="index.php" method="post" class="mb-4">
            <div class="input-group">
                <input type="text" name="task_name" class="form-control" 
                    value="<?php echo $edit_task ? $edit_task['task_name'] : ''; ?>"
                    placeholder="Enter a task..." 
                    required
                >
                <?php if ($edit_task): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_task['id']; ?>">
                    <button class="btn btn-warning" name="update">Update</button>
                <?php else: ?>
                    <button class="btn btn-primary" name="submit">ADD</button>
                <?php endif; ?>
            </div>
        </form>
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Open Tasks</h2>
                <ul class="list-group">
                    <?php if ($open_task->num_rows > 0) {
                        while ($row = $open_task->fetch_assoc()) {
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $row["task_name"];?>
                                <div>
                                    <form action="" method="post" style="display: inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="submit" value="&#9998;" name="edit" style="padding:5px;border-radius:5px;border:1px solid;padding-bottom:9px">
                                    </form>
                                    <a href="in_progress.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary" name="inprogress">In progress</a>
                                    <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-success" name="complet">Complete</a>
                                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </li>
                    <?php
                        }
                    } else { ?>
                        <li class="list-group-item">No Open Task Found.</li>
                    <?php 
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">Tasks In progress</h2>
                <ul class="list-group">
                    <?php if ($tasks_inprogress->num_rows > 0) {
                        while ($row = $tasks_inprogress->fetch_assoc()) {
                    ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $row["task_name"];?>
                                <div>
                                    <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-success" name="complet">Complete</a>
                                    <a href="delete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </li>
                    <?php
                        }
                    } else { ?>
                        <li class="list-group-item">No Tasks in progress Found.</li>
                    <?php 
                    }
                    ?>
                </ul>
            </div>
            <p class="text-center"><?php echo str_repeat("_", 100)?></p>
            <div class="col-md-6">
                <h2 class="text-center">Closed Tasks</h2>
                <ul class="list-group">
                <?php if ($closed_task->num_rows > 0) {
                        while ($row = $closed_task->fetch_assoc()) {
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $row["task_name"];?>
                        <div>
                            <a href="delete_task.php?id=<?php echo $row['id']; ?> " class="btn btn-danger">Delete</a>
                        </div>
                    </li>
                    <?php
                        }
                    } else {
                        echo "<li class='list-group-item'>No Closed Tasks Found!</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">Deleted Tasks</h2>
                <ul class="list-group">
                <?php if ($deleted_task->num_rows > 0) {
                        while ($row = $deleted_task->fetch_assoc()) {
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $row["task_name"];?>
                        <div>
                            <a href="complete_task.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Back up the Task</a>
                            <a href="delete4ever_task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete for ever</a>
                        </div>
                    </li>
                    <?php
                        }
                    } else {
                        echo "<li class='list-group-item'>No Deleted Tasks Found!</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>