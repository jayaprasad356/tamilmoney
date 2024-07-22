<?php
include_once('includes/crud.php');
session_start();

// Check if the user is logged in
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (!$user_id) {
    die("User not logged in.");
}

$data = array(
    "user_id" => $user_id,
);

$apiUrl = API_URL . "plan_list.php";

$curl = curl_init($apiUrl);

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);

if ($response === false) {
    // Error in cURL request
    echo "Error: " . curl_error($curl);
    $plans = [];
} else {
    // Successful API response
    $responseData = json_decode($response, true);
    if ($responseData !== null && $responseData["success"]) {
        // Store all plan details
        $plans = $responseData["data"];
    } else {
        echo "Failed to fetch transaction details.";
        if ($responseData !== null) {
            echo "<script>window.location.href = 'login.php';</script>";
        }
        $plans = [];
    }
}

curl_close($curl);

if (isset($_POST['btnactivate'])) {
    $plan_id = isset($_POST['plan_id']) ? $_POST['plan_id'] : null;

    if (!$plan_id) {
        die("Plan ID not provided.");
    }

    $data = array(
        "plan_id" => $plan_id,
        "user_id" => $user_id,
    );
    $apiUrl = API_URL . "activate_plan.php";

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
            echo "<script>alert('$message');</script>";
        } else {
            // Failed to fetch transaction details
            if ($responseData !== null) {
                echo "<script>window.location.href = 'login.php';</script>";
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
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include_once('sidebar.php'); ?>
        <div class="col py-3">
            <div id="plansSection" class="plansSection-container">
                <div class="row">
                    <!-- Loop through all plans and display each one -->
                    <?php foreach ($plans as $plan): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 18rem;">
                                <!-- Use the dynamic image URL -->
                                <img class="card-img-top img-fluid" src="<?php echo htmlspecialchars($plan['image']); ?>" alt="Plan image" style="max-width: 100%; height: 100px; width: 100px;">

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($plan['products']); ?></h5>
                                    <p class="card-text">Price: <?php echo htmlspecialchars($plan['price']); ?></p>
                                    <p class="card-text">Daily Income: <?php echo htmlspecialchars($plan['daily_income']); ?></p>
                                    <p class="card-text">Invite Bonus: <?php echo htmlspecialchars($plan['invite_bonus']); ?></p>
                                    <p class="card-text">No of Videos: <?php echo htmlspecialchars($plan['num_times']); ?></p>
                                    <p class="card-text">Validity: Unlimited Days</p>
                                    <form action="plan.php" method="post" style="display: inline;">
                    <input type="hidden" name="plan_id" value="<?php echo htmlspecialchars($plan['id']); ?>">
                    <button type="submit" name="btnactivate" class="btn btn-success">Activate</button>
                </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
