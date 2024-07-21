<?php
include_once('includes/crud.php');
session_start();
ob_start();

$loginapi = API_URL."login.php";


if (isset($_POST['btnLogin'])) {
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];

    if($mobile == "" || $password == ""){
        echo "<script>alert('Please fill all the fields')</script>";
    }else{
        $data = array(
            "mobile" => $mobile,
            "password" => $password
        );
        $curl = curl_init($loginapi);
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
                    $_SESSION['id'] = $userdetails[0]["id"];
                    header("Location: dashboard.php");
                } else {
                    echo "No transactions found.";
                }
            } else {
                if ($responseData !== null) {
                    // show error in dialog box
                    echo "<script>alert('Error message: " . $responseData["message"] . "')</script>";
                }
            }
        }
        curl_close($curl);
    
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        body {
        font-family: 'Poppins', Arial, sans-serif;
        background: #efefef;
    }
        .custom-container {
            width: 450px; 
            margin: 10px auto; /* Adjusted margin */
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: rgb(255, 255, 255);
        }
        .btn-custom {
            width: 100%;
            margin-top:25px;
            border-radius: 10px;
            border: 2px solid #fed346;
            
        }
        .btn-customs {
            width: 100%;
            border-radius: 15px;
           
        }
        @media (max-width: 576px) {
            .nowrap-mobile {
                white-space: nowrap;
                font-size: 10px;
            }
            .btn-customs {
            width: 100%;
            border-radius: 15px;
            margin-top:6px;
           
        }
     
        }

    </style>
</head>
<body>
<h2 class="text-center mt-5">Login</h2> <!-- Moved Register text outside the container -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="custom-container">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                    <label for="number" style= "font-weight:bold;">Mobile Number:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="border-right: none; background: transparent;"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" required style="border-left: none; ">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" style= "font-weight:bold;">Password:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="border-right: none; background: transparent;"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required style="border-left: none;">
                    </div>
                    <span id="passwordError" class="text-danger"></span>
                </div>
                
                <div class="form-group">
                <button type="submit" class="btn btn-primary btn-custom" name="btnLogin"  style="background-color:#fed346; color:white; font-weight:bold;">Login</button>
                </div>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="register.php">Create New Account</a></p>
                </div>
            </form>
        </div>
    </div>
    <script>
  window.addEventListener('DOMContentLoaded', function() {
    // Get the checkbox element
    var checkbox = document.getElementById('checkbox');
    // Set the "checked" attribute to true
    checkbox.checked = true;
  });
</script>

</body>
</html>