<?php
include_once "../db_config.php";


// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login if not logged in
    header("Location: admin_login.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_admin_username = mysqli_real_escape_string($conn, $_POST['new_admin_username']);
    $new_admin_password = mysqli_real_escape_string($conn, $_POST['new_admin_password']);

    // Hash the password before storing it
    $hashed_password = password_hash($new_admin_password, PASSWORD_DEFAULT);

    // Insert new admin into the database
    $sql = "INSERT INTO admins (admin_username, admin_password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_admin_username, $hashed_password);

    if ($stmt->execute()) {
        $success_message = "Admin added successfully";
    } else {
        $error_message = "Error adding admin: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
</head>
<body>
    <h2>Add Admin</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="admin_name">Admin Name:</label><br>
        <input type="text" id="admin_name" name="admin_name"><br>
        <label for="admin_email">Admin Email:</label><br>
        <input type="email" id="admin_email" name="admin_email"><br>
        <label for="admin_password">Admin Password:</label><br>
        <input type="password" id="admin_password" name="admin_password"><br><br>
        <input type="submit" value="Add Admin">
    </form>
</body>
</html>