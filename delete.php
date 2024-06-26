<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_level = $_POST['course_level'];
    $course_description = $_POST['course_description'];

    $sql = "INSERT INTO course (course_name, course_level, description) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $course_name, $course_level, $course_description);
        if ($stmt->execute()) {
            // echo "Course added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT id, course_name, course_level, description FROM course";
$result = $conn->query($sql);

if (isset($_GET['delete_id'])) {
    // Get the delete_id from the URL
    $delete_id = $_GET['delete_id'];

    // Create a DELETE SQL query
    $sql = "DELETE FROM course WHERE id = ?";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the delete_id parameter to the SQL statement
        $stmt->bind_param("i", $delete_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Success message (optional)
           
            // echo "Record deleted successfully";
        } else {
            // Error message
            echo "Error deleting record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error message
        echo "Error preparing statement: " . $conn->error;
    }

    // Redirect to the same page to avoid resubmitting the form on refresh (optional)
    header("Location: delete.php");
    exit();
}

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            margin: 10px 0;
            padding: 10px;
            display: block;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }

        .course-list {
            margin-top: 20px;
        }

        .course-list h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f2f2f2;
        }

        th {
            background-color: #f8f8f8;
            color: #666;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        td a {
            color: #ff5555;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        td a:hover {
            color: #ff0000;
        }

        td:last-child {
            text-align: center;
        }

        .no-courses {
            font-style: italic;
            color: #777;
        }
        </style>
</head>
<body>
<div class="sidebar">
<h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
    
    <a href="addcourse.php">Add Course</a>
    <a href="delete.php">Courses Detail</a>
   
    <a href="logout.php">Logout</a>
</div>
<div class="main-content">
    <header>
        <div class="container">
            <div class="content">
            <h1>Course List</h1>
            </div>
        </div>
    </header>
<div class="course-list">
       
        <table >
            <tr>
                <th>Course Name</th>
                <th>Level</th>
                <th>Description</th>
                
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["course_name"] . "</td>";
                    echo "<td>" . $row["course_level"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td><a href=delete.php?delete_id=" . $row["id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No courses found.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
    
</body>
</html>