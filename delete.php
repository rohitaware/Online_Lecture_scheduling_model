
<?php
// Include database connection
include 'config.php';

// Check if course ID is set and not empty
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize course ID to prevent SQL injection
    $course_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Define SQL query to delete the course with the specified ID
    $sql = "DELETE FROM course WHERE id = '$course_id'";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        // Course deleted successfully
        echo "Course deleted successfully.";
    } else {
        // Error occurred while deleting the course
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Course ID is not set or empty
    echo "Invalid course ID.";
}

// Close connection
$conn->close();
?>
