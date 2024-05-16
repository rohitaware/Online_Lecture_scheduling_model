<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');

   
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $course_name = $_POST['course_name'];
    $course_level = $_POST['course_level'];
    $course_description = $_POST['course_description'];

    

    $sql = "INSERT INTO course (course_name, course_level, description) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sss" , $course_name, $course_level, $course_description);
        // Execute the statement
        if ($stmt->execute()) {
            echo "Course added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        // Close statement
        $stmt->close();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }



}


?>
<?php
@include 'config.php';





// Check if a course should be deleted
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // SQL to delete the selected course
    $delete_sql = "DELETE FROM course WHERE id = ?";
    
    if ($stmt = $conn->prepare($delete_sql)) {
        // Bind parameter
        $stmt->bind_param("i", $delete_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Course deleted successfully.";
        } else {
            echo "Error deleting course: " . $conn->error;
        }
        // Close statement
        $stmt->close();
    } else {
        echo "Error: " . $delete_sql . "<br>" . $conn->error;
    }
}

// Retrieve courses from the database
$sql = "SELECT id, course_name, course_level, description FROM course";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Include CSS files, scripts, or other meta tags as needed -->
    
     <link rel="stylesheet" href="css/style.css">
     <style>
    .course-list {
        margin-top: 20px;
        font-family: Arial, sans-serif;
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

<header>
    <!-- Your header content goes here -->
    <!-- For example, navigation links, logo, etc. -->
    <div class="container">
        <div class="content">
           
            <h1>welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
            
        </div>
        <a href="logout.php" class="btn logout-btn">LOGOUT</a>
    </div>
</header>

<div class="add-course-container">
    <div class="add-course">
        <h2>Add Course</h2>
        <!-- Course addition form -->
        <form id="add-course-form" action="admin_page.php" method="post">
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
                <input type="text" id="course_name" name="course_description" required>
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

<div class="course-list">
    <h2>Course List</h2>
    <table>
        <tr>
            <th>Course Name</th>
            <th>Level</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["course_name"]."</td>";
                echo "<td>".$row["course_level"]."</td>";
                echo "<td>".$row["description"]."</td>";
                echo "<td><a href='admin_page.php?delete_id=".$row["id"]."'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No courses found.</td></tr>";
        }
        ?>
    </table>
</div>

<footer>
    <!-- Your footer content goes here -->
</footer>

<!-- Include scripts at the end of the body for better performance -->



</body>






</html>
