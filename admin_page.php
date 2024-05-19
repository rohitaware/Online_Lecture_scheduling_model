<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');

   
}
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
</style>
 
</head>
<body>
<div class="sidebar">
<h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
    <hr>
    <a href="addcourse.php">Add Course</a>
    <a href="delete.php">Courses Detail</a>
    
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
    <header>
        <div class="container">
            <div class="content">
            <h1>Dashboard</h1>
            </div>
        </div>
    </header>
    
</body>






</html>
