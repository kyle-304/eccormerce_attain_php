<?php
include_once "db_config.php"; // Adjust the path based on your directory structure

session_start();

// Check if the user is already logged in, redirect to the user's dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: user/dashboard.php"); // Adjust the path based on your directory structure
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the entered password against the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Login successful, set session and redirect to index.php
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php"); // Adjust the path based on your directory structure
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <section class="">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

            <div class="w-full bg-white rounded-lg shadow-lg md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                        Sign in
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="post" action="">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                            <input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                            <input type="password" id="password" name="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " required="">
                        </div>

                        <div class="flex items-center justify-between">
                            <?php
                            if (isset($error_message)) {
                                echo '<p style="color: red;">' . $error_message . '</p>';
                            }
                            ?>

                        </div>
                        <button type="submit" value="Login" class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Sign in</button>
                        <p class="text-sm font-light text-gray-500 ">
                            Don't have an account yet? <a href="register.php" class="font-medium text-orange-600 hover:underline ">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>

</html>