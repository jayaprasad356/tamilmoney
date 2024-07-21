<?php
include_once('includes/crud.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_POST['btnUpdate'])) {
    // Gather and sanitize user input data
    $password = isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : "";
    $confirm_password = isset($_POST["confirm_password"]) ? htmlspecialchars($_POST["confirm_password"]) : "";

    // Basic validation for passwords
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit();
    }

    // Prepare data to be sent to the API
    $data = array(
        "user_id" => $user_id,
        "password" => $password,
    );

    $apiUrl = API_URL . "change_password.php"; 

    // Initialize cURL session
    $curl = curl_init($apiUrl);

    // Set cURL options
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    // Execute the cURL request
    $response = curl_exec($curl);

    if ($response === false) {
        // Error in cURL request
        echo "Error: " . curl_error($curl);
    } else {
        // Decode the JSON response from the API
        $responseData = json_decode($response, true);
        if ($responseData !== null && isset($responseData["success"])) {
            $message = $responseData["message"];
            echo "<script>alert('$message');</script>";
        } else {
            // Handle API response error
            if ($responseData !== null) {
                echo "Error message: " . $responseData["message"];
            } else {
                echo "Unexpected error.";
            }
        }
    }

    // Close cURL session
    curl_close($curl);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Sidebar Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Additional styles for the boxes */
        .info-box {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .info-box h4 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        .info-box p {
            font-size: 1.25rem;
            margin: 0;
        }
        .withdrawal-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .form-container {
            max-width: 500px;
            position: relative;
        }
        .form-container .eye-icon {
            position: absolute;
            top: 70%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .form-container .form-control {
            padding-right: 40px;
        }
        .setpassword-container {
            position: relative; 
            padding: 20px; 
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Ratingjobs</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li>
                        <a href="dashboard.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline text-white">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="plan.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Plans</span></a>
                    </li>
                    <li>
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">My Referrals</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#level1" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Level</span> 1</a>
                            </li>
                            <li>
                                <a href="level_2.php" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Level</span> 2</a>
                            </li>
                            <li>
                                <a href="level_3.php" class="nav-link px-0 text-white"> <span class="d-none d-sm-inline">Level</span> 3</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#withdrawals" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-cash"></i> <span class="ms-1 d-none d-sm-inline">Withdrawals</span> </a>
                    </li>
                    <li>
                        <a href="transactions.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-credit-card"></i> <span class="ms-1 d-none d-sm-inline">Transaction</span> </a>
                    </li>
                    <li>
                        <a href="bank_details.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-bank"></i> <span class="ms-1 d-none d-sm-inline">Bank Account</span> </a>
                    </li>
                    <li>
                        <a href="#setpassword" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-lock"></i> <span class="ms-1 d-none d-sm-inline">Set Password</span> </a>
                    </li>
                    <li>
                        <a href="invite_friends.php" class="nav-link px-0 align-middle text-white">
                        <i class="fs-4 bi-people-fill"></i> <span class="ms-1 d-none d-sm-inline">Invite Friends</span> </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle text-white">
                        <i class="fs-4 bi-headset"></i> <span class="ms-1 d-none d-sm-inline">Customer Support</span> </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">loser</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col py-3">
        <div id="setpassword" class="setpassword-container">
            <h2>Set Password</h2>
            
            <!-- Withdrawal Request Form -->
            <div class="form-container mt-4">
            <form action="set_password.php" method="post">
                    <div class="mb-3 position-relative">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="password" required>
                        <i class="bi bi-eye eye-icon" id="togglePassword"></i>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                        <i class="bi bi-eye eye-icon" id="toggleConfirmPassword"></i>
                    </div>
                    <button type="submit" name="btnUpdate" class="btn btn-primary">Set</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const newPassword = document.getElementById('newPassword');

        togglePassword.addEventListener('click', function () {
            const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newPassword.setAttribute('type', type);
            togglePassword.classList.toggle('bi-eye-slash');
        });

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('confirmPassword');

        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            toggleConfirmPassword.classList.toggle('bi-eye-slash');
        });
    });
</script>
</body>
</html>