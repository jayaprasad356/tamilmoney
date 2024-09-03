
<?php
include_once('includes/connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
        $users = $responseData["data"];
        if (!empty($users)) {
            $name = $users[0]["name"];
        } else {
            echo "<script>alert('".$responseData["message"]."')</script>";
        }
    } else {

        if ($responseData !== null) {
            echo "<script>alert('".$responseData["message"]."')</script>";
    
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
    <title>Sidebar Toggle Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            width: 200px; /* Default expanded width */
            transition: width 0.3s ease;
            background-color: #3eb3a8; /* Custom background color */
        }
        .sidebar.collapsed {
            width: 60px; /* Collapsed width for mobile */
        }
        .sidebar .nav-link span {
            display: inline; /* Show text by default */
        }
        .sidebar.collapsed .nav-link span {
            display: none; /* Hide text when collapsed */
        }
        .nav-link {
            display: flex;
            align-items: center;
        }
        .nav-link i {
            margin-right: 10px;
        }
       
        /* Media query to hide text on mobile when collapsed */
        @media (max-width: 768px) {
            .sidebar {
                width: 60px; /* Start collapsed on mobile */
            }
            .sidebar.expanded {
                width: 200px; /* Expand width on mobile */
            }
            .sidebar .nav-link span {
                display: none; /* Hide text by default on mobile */
            }
            .sidebar.expanded .nav-link span {
                display: inline; /* Show text when expanded on mobile */
            }
            #menuToggle {
                position:relative;
                top: 5px;
                right:13px;
                z-index: 1050;
            }
            #brandTitle {
                display: none;
            }
            .sidebar.expanded #brandTitle {
                display: inline;
                position: fixed;
                left: 50px;
                top: 70px;
                z-index: 1050;
            }
            #dropdownUser1 {
                display: none; /* Hide desktop dropdown */
            }
            #brandDropdown {
                display: inline; /* Show mobile dropdown */
            }
        }
        .user-profile-img {
            display: inline;
        }
        .user-profile-name {
            display: none;
        }
        .sidebar.expanded .user-profile-name {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="sidebar text-white d-flex flex-column align-items-start px-3 pt-2 min-vh-100">
        <!-- Menu Toggle Button and Brand Title (visible only on mobile) -->
            <!-- Mobile Menu Toggle -->
            <div class="d-flex align-items-center mb-3 d-md-none">
                <button id="menuToggle" class="btn btn-dark text-white" type="button">
                    <i id="menuIcon" class="fs-4 bi-list"></i>
                </button>
                <span id="brandTitle" class="ms-2">Money Book</span>
            </div>

            <!-- Sidebar Brand -->
            <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="admin_v1/dist/img/money.jpeg" alt="Logo" style="max-width: 30px; height: auto; margin-right: 10px; border-radius:14px;">
                <span class="fs-5 d-none d-sm-inline">Money Book</span>
            </a>

        <!-- Sidebar Menu -->
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start">
            <li>
                <a href="dashboard.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1">Dashboard</span>
                </a>
            </li>
            <!-- <li>
                <a href="recharge.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-cash"></i> <span class="ms-1">Recharge</span>
                </a>
            </li> -->
            <li>
                <a href="ins_recharge.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-cash"></i> <span class="ms-1">Instant Recharge</span>
                </a>
            </li>
            <li>
                <a href="plan.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-table"></i> <span class="ms-1">Plans</span>
                </a>
            </li>
            <li>
                <a href="my_plans.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-file-earmark-text"></i> <span class="ms-1">My Plans</span>
                </a>
            </li>
            <li>
                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-grid"></i> <span class="ms-1">My Referrals</span>
                </a>
                <ul class="collapse nav flex-column ms-1" id="submenu2">
                    <li class="w-100">
                        <a href="level_1.php" class="nav-link px-0 text-white"> <span>Level</span> 1</a>
                    </li>
                    <li>
                        <a href="level_2.php" class="nav-link px-0 text-white"> <span>Level</span> 2</a>
                    </li>
                    <li>
                        <a href="level_3.php" class="nav-link px-0 text-white"> <span>Level</span> 3</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="withdrawals.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-cash-stack"></i> <span class="ms-1">Withdrawals</span>
                </a>
            </li>
            <li>
                <a href="transactions.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-credit-card"></i> <span class="ms-1">Transactions</span>
                </a>
            </li>
            <li>
                <a href="bank_details.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-bank"></i> <span class="ms-1">Bank Account</span>
                </a>
            </li>
            <li>
                <a href="set_password.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-lock"></i> <span class="ms-1">Set Password</span>
                </a>
            </li>
            <li>
                <a href="invite_friends.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-people-fill"></i> <span class="ms-1">Invite Friends</span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-headset"></i> <span class="ms-1">Customer Support</span>
                </a>
            </li>
            <!-- <li>
                <a href="company_details.php" class="nav-link px-0 align-middle text-white">
                    <i class="fs-4 bi-building"></i> <span class="ms-1">Company Details</span>
                </a>
            </li> -->
        </ul>

        <hr>
         <!-- User Profile Dropdown Menu for Desktop -->
         <div id="dropdownUser1" class="dropdown pb-4 d-none d-md-block">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User" width="30" height="30" class="rounded-circle">
                <span class="d-none d-sm-inline mx-1"><?php echo $name; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
            </ul>
        </div>

        <div id="brandDropdown" class="dropdown pb-4 d-md-none">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User" width="30" height="30" class="rounded-circle">
                <span class="user-profile-name ms-2"><?php echo $name; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS for Toggle Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menuToggle');
            const menuIcon = document.getElementById('menuIcon');
            const sidebar = document.querySelector('.sidebar');

            menuToggle.addEventListener('click', function () {
                if (window.innerWidth <= 768) { // Only execute on mobile
                    sidebar.classList.toggle('expanded');
                    sidebar.classList.toggle('collapsed');
                    if (sidebar.classList.contains('expanded')) {
                        menuIcon.classList.remove('bi-list');
                        menuIcon.classList.add('bi-x');
                    } else {
                        menuIcon.classList.remove('bi-x');
                        menuIcon.classList.add('bi-list');
                    }
                }
            });
        });
    </script>
    <script>window.$zoho=window.$zoho || {};$zoho.salesiq=$zoho.salesiq||{ready:function(){}}</script><script id="zsiqscript" src="https://salesiq.zohopublic.in/widget?wc=siq7f332814434ba123f5efbf2d82a7e47947952e33ecc6bf4b78f9f89edf3ad350" defer></script>
</body>
</html>
