<?php
include_once('includes/crud.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null; // Ensure user_id is set

$data = array(
    "user_id" => $user_id,
);


// Fetch the user's current balance
$apiUrl = API_URL . "user_details.php"; // Ensure this endpoint provides the user's balance

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);

if ($response === false) {
    echo "Error: " . curl_error($curl);
    $balance = "N/A";
} else {
    $responseData = json_decode($response, true);
    if ($responseData !== null && $responseData["success"]) {
        $userdetails = $responseData["data"];
        if (!empty($userdetails)) {
            $balance = $userdetails[0]["balance"];
        } else {
            $balance = "No balance information available.";
        }
    } else {
        $balance = "Failed to fetch balance.";
        if ($responseData !== null) {
            echo " Error message: " . $responseData["message"];
        }
    }
}
curl_close($curl);

// Update session balance
$_SESSION['balance'] = $balance;

if (isset($_POST['btnWithdrawal'])) {
    $amount = $_POST['amount'];
    $data = array(
        "user_id" => $user_id,
        "amount" => $amount,
    );
    $apiUrl = API_URL . "withdrawals.php";

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);

    if ($response === false) {
        // Error in cURL request
        echo "Error: " . curl_error($curl);
    } else {
        // Successful API response
        $responseData = json_decode($response, true);
        if ($responseData !== null && isset($responseData["success"])) {
            $message = $responseData["message"];
            if (isset($responseData["balance"])) {
                $_SESSION['balance'] = $responseData['balance'];
                $balance = $_SESSION['balance'];
            }
            // Alert and redirect
            echo "<script>
                    alert('$message');
                    window.location.href = 'withdrawals.php';
                  </script>";
        } else {
            // Failed to fetch transaction details
            if ($responseData !== null) {
                echo "Error message: " . $responseData["message"];
            }
        }
    }
    
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
        .withdrawal-container {
            position: relative; 
            padding: 20px; 
        }
        .withdrawal-container h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }
        .withdrawal-button {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1rem;
        }
        .form-container {
            max-width: 400px; 
        }
        @media (max-width: 576px) {
            .withdrawal-container h2 {
                font-size: 0.9rem;
            }
            .withdrawal-button {
                font-size: 0.600rem;
                top: 19px;
                right: 8px;
            }
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
                        <a href="set_password.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-lock"></i> <span class="ms-1 d-none d-sm-inline">Set Password</span> </a>
                    </li>
                    <li>
                        <a href="invite_friends.php" class="nav-link px-0 align-middle text-white">
                        <i class="fs-4 bi-people-fill"></i> <span class="ms-1 d-none d-sm-inline">Invite Friends</span> </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-lock"></i> <span class="ms-1 d-none d-sm-inline">Customer Support</span> </a>
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
            <div class="withdrawal-container">
                <h2>Withdrawal Request</h2>
                <a href="withdrawals.php" class="btn btn-primary withdrawal-button">Back To Withdrawals</a>
                
                <!-- Withdrawal Request Form -->
                <div class="form-container mt-4">
                    <form action="withdrawal_request.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                        <div class="mb-3">
                            <label for="balance" class="form-label">Remaining Balance</label>
                            <input type="number" class="form-control" id="balance" name="balance" value="<?php echo htmlspecialchars($balance); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Enter Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <button type="submit" name="btnWithdrawal" class="btn btn-primary">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>