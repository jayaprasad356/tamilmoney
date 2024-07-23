
<?php
include_once('includes/connection.php');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null; // Ensure user_id is set

if (!$user_id) {
    header("Location: index.php");
    exit();
}

$data = array(
    "user_id" => $user_id,
);

$apiUrl = API_URL."user_details.php";


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
    if ($responseData !== null && $responseData["success"]) {
        // Display transaction details
        $userdetails = $responseData["data"];
        if (!empty($userdetails)) {
            $total_income = $userdetails[0]["total_income"];
            $total_recharge = $userdetails[0]["total_recharge"];
            $total_assets = $userdetails[0]["total_assets"];
            $total_withdrawal = $userdetails[0]["total_withdrawal"];
            $today_income = $userdetails[0]["today_income"];
            $team_income = $userdetails[0]["team_income"];
        } else {
            echo "No transactions found.";
        }
    } else {
        echo "Failed to fetch transaction details.";
        if ($responseData !== null) {
            echo " Error message: " . $responseData["message"];
        }
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
        .dashboard-container {
            position: relative; 
            padding: 20px; 
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include_once('sidebar.php'); ?>

        <div class="col py-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #BF360C; color: white;">
                            <h4>Total Income</h4>  <p>₹<?php echo $total_income; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #F9A825; color: white;">
                            <h4>Total Recharge</h4>  <p>₹<?php echo $total_recharge; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #1B5E20; color: white;">
                            <h4>Total Assets</h4>  <p>₹<?php echo $total_assets; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #01579B; color: white;">
                            <h4>Total Withdrawals</h4>  <p>₹<?php echo $total_withdrawal; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #004D40; color: white;">
                            <h4>Todays's Income</h4>  <p>₹<?php echo $today_income; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #AFB42B; color: white;">
                            <h4>Team Income</h4>  <p>₹<?php echo $team_income; ?></p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
