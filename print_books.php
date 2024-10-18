<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
// Set timezone to Asia/Kolkata
date_default_timezone_set('Asia/Kolkata');

// Get current date and time
$datetime = date('Y-m-d H:i:s');

$user_id = $_SESSION['id']; // Get user_id from session
$servername = "localhost";
$username = "u743445510_money_book";
$password = "Moneybook@2024";  
$dbname = "u743445510_money_book"; 


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize print count if not set
if (!isset($_SESSION['print_count'])) {
    $_SESSION['print_count'] = 0;
}

$printCount = min($_SESSION['print_count'], 50); // Cap at 50

// Handle updating the print count via AJAX
if (isset($_POST['update_print_count'])) {
    $newCount = intval($_POST['new_count']);
    $_SESSION['print_count'] = min($newCount, 50); // Update the session value, capped at 50
    echo json_encode(['status' => 'success', 'message' => 'Count updated']);
    exit();
}

// Fetch all records from the books table
$sql = "SELECT customer_name, book_name, author_name, book_id FROM books";
$result = $conn->query($sql);

$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    echo "No records found.";
    exit();
}

// Clear old random values
unset($_SESSION['random_customer_name'], $_SESSION['random_book_name'], $_SESSION['random_author_name'], $_SESSION['random_book_id']);

// Select a new random record for display
$randomIndex = array_rand($books);
$randomBook = $books[$randomIndex];

$randomCustomerName = trim($randomBook['customer_name']);
$randomBookName = trim($randomBook['book_name']);
$randomAuthorName = trim($randomBook['author_name']);
$randomBookId = trim($randomBook['book_id']);

// Store the random book information in the session
$_SESSION['random_customer_name'] = $randomCustomerName;
$_SESSION['random_book_name'] = $randomBookName;
$_SESSION['random_author_name'] = $randomAuthorName;
$_SESSION['random_book_id'] = $randomBookId;


 if (isset($_POST['printss'])) {
    if (empty($errors)) {
        $print_cost = $_SESSION['print_cost'];

    if ($print_cost > 0) {
        $conn->autocommit(FALSE);

        try {
        // Calculate the total cost to be added (50 times the print cost)
               $total_cost = 50 * $print_cost;
                // Update user balance
                $sql = "UPDATE users SET balance = balance + $total_cost WHERE id = $user_id";
                if (!$conn->query($sql)) {
                    throw new Exception('Failed to update balance');
                }
        
                $sql = "INSERT INTO transactions (user_id, type, amount, datetime) VALUES ($user_id, 'print_books', $total_cost, '$datetime')";
                if (!$conn->query($sql)) {
                    throw new Exception('Failed to insert transaction');
                }
        
                // Increment and update session count
                $newCount = $_SESSION['print_count'] + 1;
                $_SESSION['print_count'] = $newCount;
        
                // Reset count after reaching max
                if ($_SESSION['print_count'] >= 50) {
                    $_SESSION['print_count'] = 0; // Reset count to 0 after reaching 10
                }
                $conn->commit();
                echo json_encode(['status' => 'success', 'message' => 'Your book printed successfully!']);
            } catch (Exception $e) {
                $conn->rollback(); // Rollback transaction if any query fails
                echo json_encode(['status' => 'failed', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'failed', 'message' => 'Please activate print jobs.']);
        }
    } else {
        echo json_encode(['status' => 'failed', 'errors' => $errors]);
    }

    // Close connection and stop further processing
    $conn->close();
    exit();
}

// Initialize user details
include_once('includes/connection.php');
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

$apiUrl = API_URL . "user_details.php";
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

            $balance = $userdetails[0]["balance"];
            $print_cost = $userdetails[0]["print_cost"];
            $_SESSION['print_cost'] = $print_cost;
        } else {
            echo "<script>alert('" . $responseData["message"] . "')</script>";
        }
    } else {
        if ($responseData !== null) {
            echo "<script>alert('" . $responseData["message"] . "')</script>";
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
    <title>Web</title>
    <link rel="icon" type="image/x-icon" href="admin_v1/dist/img/money.jpeg">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .info-box {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .info-box p {
            font-size: 1.25rem;
            margin: 0;
        }
        .form-container {
            max-width: 500px;
            margin-top: 20px;
        }
        .bankdetails-container {
            position: relative;
            padding: 20px;
        }
        .no-copy {
            user-select: none; /* Disable text selection */
            -webkit-user-select: none; /* Disable for Safari */
            -ms-user-select: none; /* Disable for IE/Edge */
        }
        .otp-input {
        width: 50px;
        text-align: center;
        font-size: 1rem;
    }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
$(document).ready(function() {
    let printCount = <?php echo $printCount; ?>; // Get print count from PHP session
    const maxPrintCount = 50;
    const cooldownTime = 60; // Cooldown time in seconds (1 minute)
    let cooldownRemaining = 0;

    // Update the print count display when the page loads
    $("#printCount").text(printCount + "/" + maxPrintCount); // Initially display count

    // Check for cooldown state in local storage
    const storedCooldownEndTime = localStorage.getItem('cooldownEndTime');
    if (storedCooldownEndTime) {
        const currentTime = Math.floor(Date.now() / 1000);
        cooldownRemaining = storedCooldownEndTime - currentTime;
        if (cooldownRemaining > 0) {
            startCooldown(); // Start the cooldown if still remaining
        }
    }

    // If print count is already at max, enable the print button and disable the next button
    if (printCount >= maxPrintCount) {
        $("#printButton").removeClass('disabled').prop('disabled', false); // Enable Print Book button
        $("#nextButton").prop('disabled', true); // Disable Next button if at max count
    }

    // Handle "Next" button click
    $("#nextButton").click(function() {
        // Check if the form fields are filled out and validate all fields
        if (validateForm() && validateAllFields()) {
            if (cooldownRemaining <= 0 && printCount < maxPrintCount) {
                printCount++; // Increment print count
                $("#printCount").text(printCount + "/" + maxPrintCount); // Update display text

                // If printCount reaches max, enable the print button and disable the next button
                if (printCount >= maxPrintCount) {
                    $("#printButton").removeClass('disabled').prop('disabled', false); // Enable Print Book button
                    $("#nextButton").prop('disabled', true); // Disable Next button
                }

                // Send an AJAX request to update the print count in the session
                $.ajax({
                    type: "POST",
                    url: "", // Current page
                    data: { update_print_count: 1, new_count: printCount }, // Data to send
                    success: function(response) {
                        console.log("Count updated successfully");
                        // Reload the page to reflect the updated count
                        location.reload(); 
                    },
                    error: function() {
                        console.error("Error updating count");
                    }
                });
            }
        } else {
            // Show an error message if validation fails
            alert("Please fill out all required fields correctly before proceeding.");
        }
    });
    // New function to validate all fields (customer_name, book_name, author_name, book_id)
    function validateAllFields() {
        const inputCustomerName = $("#customer_name").val().trim();
        const inputBookName = $("#book_name").val().trim();
        const inputAuthorName = $("#author_name").val().trim();
        const inputBookId = $(".book_id").map(function() { return $(this).val().trim(); }).get().join('');

        // Get the stored values from PHP
        const storedCustomerName = "<?php echo addslashes($randomCustomerName); ?>";
        const storedBookName = "<?php echo addslashes($randomBookName); ?>";
        const storedAuthorName = "<?php echo addslashes($randomAuthorName); ?>";
        const storedBookId = "<?php echo addslashes($randomBookId); ?>";

        // Validate the inputs against the stored values
        let errors = '';
        if (inputCustomerName !== storedCustomerName) {
            errors += 'Customer name is incorrect.<br>';
        }
        if (inputBookName !== storedBookName) {
            errors += 'Book name is incorrect.<br>';
        }
        if (inputAuthorName !== storedAuthorName) {
            errors += 'Author name is incorrect.<br>';
        }
        if (inputBookId !== storedBookId) {
            errors += 'Book ID is incorrect.<br>';
        }

        // Show modal with errors if there are any
        if (errors) {
            $("#modalTitle").text("Error");
            $("#modalHeader").removeClass('bg-success').addClass('bg-danger');
            $("#modalMessage").html(errors); // Show the error message
            $("#responseModal").modal('show'); // Show the modal
            return false; // Return false to stop the process
        } else {
            return true; // No errors, return true to proceed
        }
    }

    // Function to start a cooldown timer after successful print
    function startCooldown() {
        cooldownRemaining = cooldownTime; // Start with 60 seconds
        $("#nextButton").prop('disabled', true); // Disable Next button
        const cooldownEndTime = Math.floor(Date.now() / 1000) + cooldownRemaining;
        localStorage.setItem('cooldownEndTime', cooldownEndTime); // Store end time in local storage

        // Update the button text with remaining time
        const intervalId = setInterval(() => {
            if (cooldownRemaining > 0) {
                $("#nextButton").text(`Next (Sync in ${cooldownRemaining} seconds)`);
                cooldownRemaining--;
            } else {
                clearInterval(intervalId); // Clear the timer once it reaches 0
                $("#nextButton").prop('disabled', false).text("Next"); // Re-enable the button
                localStorage.removeItem('cooldownEndTime'); // Clear the cooldown state
            }
        }, 1000); // Decrease cooldown every second (1000 ms = 1 second)
    }

    // Function to validate form fields
function validateForm() {
    let isValid = true;
    let errorMessages = new Set(); // Use a Set to hold unique error messages

    // Validate required fields
    $("input[required]").each(function() {
        const fieldValue = $(this).val().trim(); // Get trimmed value of the input
        const fieldName = $(this).attr("name"); // Get the name of the field

        if (fieldValue === "") {
            isValid = false; // Set to false if any required field is empty

            // Check if the fieldName is undefined or empty
            if (!fieldName) {
                errorMessages.add("Book ID is required."); // Add unique message for undefined name
            } else {
                errorMessages.add(fieldName + " is required."); // Add generic message for other fields
            }
        }
    });

    // If there are errors, show them in a modal
    if (!isValid) {
        showErrorModal(Array.from(errorMessages)); // Convert Set to Array and show errors
    }

    return isValid;
}

// Function to show errors in a modal
function showErrorModal(errors) {
    $("#modalTitle").text("Validation Errors");
    $("#modalHeader").removeClass('bg-success').addClass('bg-danger');

    // Format error messages into HTML
    const errorHtml = errors.join("<br>");
    $("#modalMessage").html(errorHtml); // Display the error messages in the modal
    $("#responseModal").modal('show'); // Show the modal
}

    // Handle form submission (print_form)
    $(document).on("submit", "form[name='printss']", function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Get the values from the inputs
        const inputCustomerName = $("#customer_name").val().trim();
        const inputBookName = $("#book_name").val().trim();
        const inputAuthorName = $("#author_name").val().trim();
        const inputBookId = $(".book_id").map(function() { return $(this).val().trim(); }).get().join('');

        // Get the stored values from PHP
        const storedCustomerName = "<?php echo addslashes($randomCustomerName); ?>";
        const storedBookName = "<?php echo addslashes($randomBookName); ?>";
        const storedAuthorName = "<?php echo addslashes($randomAuthorName); ?>";
        const storedBookId = "<?php echo addslashes($randomBookId); ?>";

        // Validate the inputs against the stored values
        let errors = '';
        if (inputCustomerName !== storedCustomerName) {
            errors += 'Customer name is incorrect.<br>';
        }
        if (inputBookName !== storedBookName) {
            errors += 'Book name is incorrect.<br>';
        }
        if (inputAuthorName !== storedAuthorName) {
            errors += 'Author name is incorrect.<br>';
        }
        if (inputBookId !== storedBookId) {
            errors += 'Book ID is incorrect.<br>';
        }

        if (errors) {
            $("#modalTitle").text("Error");
            $("#modalHeader").removeClass('bg-success').addClass('bg-danger');
            $("#modalMessage").html(errors); // Show the error message
            $("#responseModal").modal('show'); // Show the modal
            return; // Exit the function early
        }

        // Proceed with the AJAX request if there are no errors
        $.ajax({
            type: "POST",
            url: "", // Current page
            data: $(this).serialize() + "&printss=1", // Include the print_form parameter
            dataType: "json",
            success: function(response) {
                var modalHeader = $("#modalHeader");
                var modalTitle = $("#modalTitle");
                var modalMessage = $("#modalMessage");

                if (response.status === 'success') {
                    modalTitle.text("Success");
                    modalHeader.removeClass('bg-danger').addClass('bg-success');
                    modalMessage.html(response.message); // Show the success message
                    $("form")[0].reset(); // Reset the form

                    // Reset the print count to 0
                    printCount = 0;
                    $("#printCount").text(printCount + "/50"); // Reset display to 0/1

                    // Start cooldown timer
                    startCooldown();

                    // Refresh the page after a short delay
                    setTimeout(function () {
                        location.reload(); // Reload the entire page
                    }, 2000); // 2000 milliseconds = 2 seconds delay

                } else {
                    modalTitle.text("Error");
                    modalHeader.removeClass('bg-success').addClass('bg-danger');
                    var errorMessage = '';
                    if (response.errors) {
                        $.each(response.errors, function (key, value) {
                            errorMessage += value + '<br>';
                        });
                    } else {
                        errorMessage = "Please activate print jobs.";
                    }
                    modalMessage.html(errorMessage); // Show the error message
                }

                $("#responseModal").modal('show'); // Show the modal
            }
        });
    });
});
</script>

</head>
<body>
<section class="content-header">
    <?php echo isset($error['add_balance']) ? $error['add_balance'] : ''; ?>
</section>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include_once('sidebar.php'); ?>
        <div class="col py-3">
            <div id="bankdetails" class="bankdetails-container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #BF360C; color: white;">
                            <h4>Print Cost</h4>  <p>₹<?php echo $print_cost; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box" style="background-color: #F9A825; color: white;">
                            <h4>Balance</h4>  <p>₹<?php echo $balance; ?></p>
                        </div>
                    </div>
                </div>

                <h2 style="text-decoration: underline;">Print Books </h2>

                <!-- Modern Card Layout for Balance and Print Wallet -->
                <!-- Book Print Form -->
                <div class="form-container mt-4">
                    <form name="printss" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <p class="no-copy"><?php echo htmlspecialchars($randomCustomerName); ?></p>
                            <input type="text" id="customer_name" name="customer_name" placeholder="Customer Name"
                                   class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <p class="no-copy"><?php echo htmlspecialchars($randomBookName); ?></p>
                            <input type="text" id="book_name" name="book_name" placeholder="Book Name"
                                   class="form-control" required/>
                        </div>
                        <div class="mb-3">
                            <p class="no-copy"><?php echo htmlspecialchars($randomAuthorName); ?></p>
                            <input type="text" id="author_name" name="author_name" placeholder="Author Name"
                                   class="form-control"  required />
                        </div>
                        <div class="mb-3">
                            <p class="no-copy"><?php echo htmlspecialchars($randomBookId); ?></p>
                            
                            <div class="otp-container" style="display: flex; gap: 10px;">
                                <input type="text" class="form-control otp-input book_id" maxlength="1" required />
                                <input type="text" class="form-control otp-input book_id" maxlength="1" required />
                                <input type="text" class="form-control otp-input book_id" maxlength="1" required />
                                <input type="text" class="form-control otp-input book_id" maxlength="1" required />
                                <input type="text" class="form-control otp-input book_id" maxlength="1" required />
                            </div>
                        </div>


                        <div class="mb-3">
                                <button type="button" id="nextButton" class="btn btn-primary">Next</button>
                                <span id="printCount"></span>
                            </div>
                            <button type="submit" id="printButton" name="printss" style="background-color:#3eb3a8; color:white;" class="btn disabled" disabled>Print Book</button>
                        </form>

                <!-- Bootstrap Modal -->
               <!-- Bootstrap Modal -->
                <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div id="modalHeader" class="modal-header bg-success">
                                <h5 id="modalTitle" class="modal-title">Success</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p id="modalMessage">Your book printed successfully!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- End of Modal -->
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>