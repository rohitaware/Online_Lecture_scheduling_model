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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            <h1>Add Course</h1>
            </div>
        </div>
    </header>

    <div class="add-course-container">
        <div class="add-course">
            
            <form id="add-course-form" action="delete.php" method="post">
                <div class="form-group">
                    <label for="course_name">Course Name:</label>
                    <input type="text" id="course_name" name="course_name" required>
                </div>

                <div class="form-group">
                    <label for="course_level">Course Level:</label>
                    <select id="course_level" name="course_level" required>
                        <option value="" disabled selected>Select Level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="course_description">Description:</label>
                    <input type="text" id="course_description" name="course_description" required>
                </div>

                <div class="form-group">
                    <label for="course_image">Course Image:</label>
                    <input type="file" id="course_image" name="course_image" accept="image/*" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Add Course" class="btn">
                </div>
            </form>
        </div>
    </div>

   
<footer>
    <!-- Your footer content goes here -->
</footer>
</body>
</html>
