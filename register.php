<?php
include_once "db_config.php";

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']); // Added line for phone number
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_username_result = $conn->query($check_username_sql);

    // var_dump($check_username_result);exit;
    if ($check_username_result->num_rows > 0) {
        $error_message = "Username already taken. Please choose a different one.";
    } else {
        $insert_user_sql = "INSERT INTO users (username, password, phone_number) VALUES ('$username', '$hashed_password', '$phone_number')";
        if ($conn->query($insert_user_sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<script src="https://cdn.tailwindcss.com"></script>

<body>
    <section class="">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

            <div class="w-full bg-white rounded-lg shadow-lg md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                        Register
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
                        <div>
                            <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 ">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" placeholder="0799 999 999" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " required="">
                        </div>
                        <div class="flex items-center justify-between">
                            <?php
                            if (isset($error_message)) {
                                echo '<p style="color: red;">' . $error_message . '</p>';
                            }
                            ?>

                        </div>
                        <button type="submit" value="Register" class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Sign up</button>
                        <p class="text-sm font-light text-gray-500 ">
                            Already have an account yet? <a href="login.php" class="font-medium text-orange-600 hover:underline ">Sign in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>

</html>