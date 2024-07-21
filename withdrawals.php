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

$apiUrl = API_URL . "withdrawals_list.php";

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
        @media (max-width: 576px) {
            .withdrawal-container h2 {
                font-size: 1.5rem;
            }
            .withdrawal-button {
                font-size: 0.650rem;
                top: 21px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
    <?php include_once('sidebar.php'); ?>
        <div class="col py-3">
            <div class="withdrawal-container" id="withdrawals">
                <h2>Withdrawal List</h2>
                <a href="withdrawal_request.php" class="btn btn-primary withdrawal-button">Request Withdrawal</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Status</th>
                            <th scope="col">Amount</th>
                            <th scope="col">DateTime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through all withdrawals and display each one -->
                        <?php foreach ($userdetails as $index => $withdrawal): ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1; ?></th>
                                <td>
                                    <?php 
                                    if ($withdrawal['status'] === '1') {
                                        echo '<span class="text-success">Paid</span>';
                                    } elseif ($withdrawal['status'] === '0') {
                                        echo '<span class="text-primary">Not Paid</span>';
                                    } elseif ($withdrawal['status'] === '-1') {
                                         echo '<span class="text-danger">Cancelled</span>';
                                    } 
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($withdrawal['amount']); ?></td>
                                <td><?php echo htmlspecialchars($withdrawal['datetime']); ?></td>
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
