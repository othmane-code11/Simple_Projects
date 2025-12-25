<?php
    include("db.php");
    if (isset($_POST["submit"])) {
        if ($_SERVER["REQUEST_METHOD"]  == "POST") {
            if (isset($_POST["task_name"])) {
                $task_name = $_POST["task_name"];
                $stmt = $conn->prepare("INSERT INTO TASKS (task_name) VALUES (?)");
                $stmt->bind_param("s", $task_name);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    $open_task = $conn->query("SELECT * FROM TASKS WHERE IS_COMPLETED = 0");
    $tasks_inprogress = $conn->query("SELECT * FROM TASKS WHERE IS_COMPLETED = 2");
    $closed_task = $conn->query("SELECT * FROM TASKS WHERE IS_COMPLETED = 1");
    $deleted_task = $conn->query("SELECT * FROM TASKS WHERE IS_COMPLETED = 3");
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
    <div class="container mt-5">
        <h1 class="text-center">To Do list with Othmane</h1>
        <form action="index.php" class="mb-4" method="post">
            <div class="input-group">
                <input type="text" name="task_name" id="" class="form-control" placeholder="Enter a new task ..." required>
                <button class="btn btn-primary" name="submit">ADD</button>
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
                            <a href="backup_task.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Back up the Task</a>
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