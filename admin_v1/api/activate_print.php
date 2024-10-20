<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('Asia/Kolkata');

include_once('../includes/crud.php');

$db = new Database();
$db->connect();
include_once('../includes/custom-functions.php');
include_once('../includes/functions.php');
include_once('verify-token.php');
$fn = new functions;


$date = date('Y-m-d');

$response['success'] = false;
$response['message'] = "Disabled";
print_r(json_encode($response));
return false;
if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}

if (empty($_POST['print_plan_id'])) {
    $response['success'] = false;
    $response['message'] = "Print Plan Id is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$print_plan_id = $db->escapeString($_POST['print_plan_id']);



$sql = "SELECT * FROM users WHERE id = $user_id ";
$db->sql($sql);
$user = $db->getResult();

if (empty($user)) {
    $response['success'] = false;
    $response['message'] = "User not found";
    print_r(json_encode($response));
    return false;
}


$sql = "SELECT * FROM print_plans WHERE id = $print_plan_id ";
$db->sql($sql);
$plan = $db->getResult();

if (empty($plan)) {
    $response['success'] = false;
    $response['message'] = "Plan not found";
    print_r(json_encode($response));
    return false;
}

$name = $plan[0]['name'];
$invite_bonus = $plan[0]['invite_bonus'];
$price = $plan[0]['price'];
$daily_income = $plan[0]['daily_income'];
$print_cost = $plan[0]['print_cost'];
$num_times = $plan[0]['num_times'];

$balance = $user[0]['balance'];
$recharge = $user[0]['recharge'];
$valid = $user[0]['valid'];
$valid_team = $user[0]['valid_team'];
$total_assets = $user[0]['total_assets'];
$refer_code = $user[0]['refer_code'];
$referred_by = $user[0]['referred_by'];
$min_withdrawal = $user[0]['min_withdrawal'];

$datetime = date('Y-m-d H:i:s');


$sql = "SELECT COUNT(*) AS count FROM user_prints WHERE print_plan_id = $print_plan_id AND user_id = $user_id";
$db->sql($sql);
$res_check_plan = $db->getResult();
$user_num_times = $res_check_plan[0]['count'];

if ($user_num_times >= $num_times) {
    $response['success'] = false;
    $response['message'] = "Already Purchased";
    print_r(json_encode($response));
    return false;
}




if ($recharge >= $price) {


    if($valid == 0 && $price > 0){
        $sql = "UPDATE users SET valid_team = valid_team + 1  WHERE refer_code = '$referred_by'";
        $db->sql($sql);
        $sql = "UPDATE users SET valid = 1  WHERE id = $user_id";
        $db->sql($sql);
    }

    $sql = "UPDATE users SET recharge = recharge - $price, total_assets = total_assets + $price, print_cost = $print_cost WHERE id = $user_id";
    $db->sql($sql);



    if($refer_code){
        $sql = "SELECT * FROM users WHERE refer_code = '$referred_by'";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);

        if ($num == 1) {
            $r_id = $res[0]['id'];
            $r_refer_code = $res[0]['refer_code'];
            $sql = "UPDATE users SET balance = balance + $invite_bonus,today_income = today_income + $invite_bonus,total_income = total_income + $invite_bonus,team_income = team_income + $invite_bonus  WHERE refer_code = '$referred_by'";
            $db->sql($sql);

            $sql = "INSERT INTO transactions (user_id, amount, datetime, type, print_plan_id) VALUES ('$r_id', '$invite_bonus', '$datetime', 'invite_bonus', '$print_plan_id')";
            $db->sql($sql);
            
        }

    }

    $sql_insert_user_prints = "INSERT INTO user_prints (user_id,print_plan_id,joined_date,claim) VALUES ('$user_id','$print_plan_id','$date',1)";
    $db->sql($sql_insert_user_prints);

    $sql_insert_transaction = "INSERT INTO transactions (user_id, amount, datetime, type) VALUES ('$user_id', '$price', '$datetime', 'start_print')";
    $db->sql($sql_insert_transaction);

    $response['success'] = true;
    $response['message'] = "Purchased successfully";
 }else {
    $response['success'] = false;
    $response['message'] = "Insufficient balance ";
}

print_r(json_encode($response));
?>