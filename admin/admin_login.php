<?php
include_once "../db_config.php"; // Adjust the path based on your directory structure

session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $admin_password = mysqli_real_escape_string($conn, $_POST['admin_password']);

    $sql = "SELECT * FROM admins WHERE admin_username = '$admin_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['admin_password'];

        if (password_verify($admin_password, $hashed_password)) {
            $_SESSION['admin_id'] = $row['admin_id'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid admin username or password";
        }
    } else {
        $error_message = "Invalid admin username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="flex min-h-full items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-sm space-y-10">
            <div>
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Admin Login</h2>
            </div>


            <form class="space-y-6" action="" method="POST">
                <div>
                    <div class="pointer-events-none absolute inset-0 z-10 rounded-md ring-1 ring-inset ring-gray-300"></div>
                    <div>
                        <label for="admin_username" class="sr-only">Email address</label>
                        <input id="admin_username" name="admin_username" type="text" autocomplete="text" required class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-100 placeholder:text-gray-400  sm:text-sm sm:leading-6" placeholder="Admin name">
                    </div>
                    <div>
                        <label for="admin_password" class="sr-only">Password</label>
                        <input id="admin_password" name="admin_password" type="password" required class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-100 placeholder:text-gray-400 focus:z-10  sm:text-sm sm:leading-6" placeholder="Password">
                    </div>
                </div>

                <!-- <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-900">Remember me</label>
                    </div>

                    <div class="text-sm leading-6">
                        <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                    </div>
                </div> -->

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                </div>
            </form>

            <?php
            if (isset($error_message)) {
                echo '<p style="color: red;">' . $error_message . '</p>';
            }
            ?>

            <!-- <p class="text-center text-sm leading-6 text-gray-500">
                Not a member?
                <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Start a 14-day free trial</a>
            </p> -->
        </div>
    </div>

</body>

</html>