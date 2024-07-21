<?php
include_once('includes/crud.php');
session_start();

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null; // Ensure user_id is set

if (!$user_id) {
    die("User not logged in.");
}

$data = array(
    "user_id" => $user_id,
);

$apiUrl = API_URL . "transactions_list.php";

$curl = curl_init($apiUrl);

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);

if ($response === false) {
    // Error in cURL request
    echo "Error: " . curl_error($curl);
    $userdetails = [];
} else {
    // Successful API response
    $responseData = json_decode($response, true);
    if ($responseData !== null && $responseData["success"]) {
        // Store transaction details
        $userdetails = $responseData["data"];
    } else {
     
        $userdetails = [];
    }
}

curl_close($curl);
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
        .transaction-container {
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
                        <a href="withdrawals.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-cash"></i> <span class="ms-1 d-none d-sm-inline">Withdrawals</span> </a>
                    </li>
                    <li>
                        <a href="#transactions" class="nav-link px-0 align-middle text-white">
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
            <div class="transaction-container" id="transactions">
                <h2>Transactions List</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Type</th>
                            <th scope="col">Amount</th>
                            <th scope="col">DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through all withdrawals and display each one -->
                        <?php foreach ($userdetails as $index => $transaction): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td><?php echo htmlspecialchars($transaction['type']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['datetime']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($userdetails)): ?>
                            <tr>
                                <td colspan="4">No transactions found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
