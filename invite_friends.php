<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Sidebar Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
        .friends-container {
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
        .button{
            padding:10px;
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
    <?php include_once('sidebar.php'); ?>
        <div class="col py-3">
        <div class="friends-container" id="invitefriends">
            <h2>Invite Friends</h2>
            <!-- Withdrawal Request Form -->
            <div class="form-container mt-4">
                <form action="submit_withdrawal_request.php" method="post">
                <div class="mb-3">
                <label for="link" class="form-label">Invite Link</label>
                <input type="text" class="form-control" id="inviteLink" name="link" value="https://example.com/invite" disabled>
            </div>
            <button type="button" id="copyButton" class="btn btn-primary">
                <i class="fs-5 bi-copy"></i> Copy Link
            </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>


    <!-- Bootstrap JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var copyButton = document.getElementById('copyButton');
        var inviteLink = document.getElementById('inviteLink');

        copyButton.addEventListener('click', function() {
            // Select the text field
            inviteLink.select();
            inviteLink.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(inviteLink.value)
                .then(function() {
                    // Success message
                    alert('Link copied to clipboard!');
                })
                .catch(function(err) {
                    // Error message
                    console.error('Failed to copy: ', err);
                });
        });
    });
</script>

</body>
</html>
