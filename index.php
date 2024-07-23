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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .card {
            border-radius: .7rem;
        }
        .text-info {
            color: #17a2b8 !important; /* Ensure the color is applied */
        }
        .shadow-1-strong {
            box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.3);
        }
        .login-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 999; /* Make sure the button stays on top */
        }
        .navbar-custom {
            padding: 0 15px;
        }
        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #3eb3a8;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-light bg-light navbar-custom">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <!-- Logo Image -->
            <img src="admin_v1/dist/img/money.jpeg" alt="Logo" class="me-2" style="max-width: 70px; height: auto; margin-right: 10px; border-radius:14px;">
            <!-- Logo Text -->
            <span class="logo-text">Money Book</span>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col py-3">
            <section style="color: #000;">
                <div class="container py-5">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-10 col-xl-8 text-center">
                            <h3 class="fw-bold mb-4">Customer Reviews</h3>
                        </div>
                    </div>

                    <div class="row text-center">
                        <!-- Review 1 -->
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="card">
                                <div class="card-body py-4 mt-2">
                                    <div class="d-flex justify-content-center mb-4">
                                        <img src="https://i.pinimg.com/736x/ae/c2/60/aec260543b7e65f0986ef4364c7a5776.jpg"
                                            class="rounded-circle shadow-1-strong" width="100" height="100" />
                                    </div>
                                    <h5 class="font-weight-bold">Sneha</h5>
                                    <h6 class="font-weight-bold my-3">Madurai,Tamil nadu</h6>
                                    <ul class="list-unstyled d-flex justify-content-center">
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-half text-info"></i></li>
                                    </ul>
                                    <p class="mb-2">
                                        <i class="bi bi-quote quote-left pe-2"></i>Money Book மிகவும் நம்பிக்கையான கம்பெனி நான் தினமும் Withdrawal எடுத்துக் கொண்டிருக்கிறேன், 😊 <i class="bi bi-quote quote-right pe-2"></i>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="card">
                                <div class="card-body py-4 mt-2">
                                    <div class="d-flex justify-content-center mb-4">
                                        <img src="img.jpg"
                                            class="rounded-circle shadow-1-strong" width="100" height="100" />
                                    </div>
                                    <h5 class="font-weight-bold">Reshma</h5>
                                    <h6 class="font-weight-bold my-3">Chennai,Tamil nadu</h6>
                                    <ul class="list-unstyled d-flex justify-content-center">
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                    </ul>
                                    <p class="mb-2">
                                        <i class="bi bi-quote quote-left pe-2"></i>இந்த App மிகவும் பயனுள்ளதாக உள்ளது நல்ல வருமானம் கிடைக்கிறது <i class="bi bi-quote quote-right pe-2"></i>

                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Review 3 -->
                        <div class="col-md-4 mb-0">
                            <div class="card">
                                <div class="card-body py-4 mt-2">
                                    <div class="d-flex justify-content-center mb-4">
                                        <img src="https://png.pngtree.com/png-vector/20230928/ourmid/pngtree-young-indian-man-png-image_10149661.png"
                                            class="rounded-circle shadow-1-strong" width="100" height="100" />
                                    </div>
                                    <h5 class="font-weight-bold">Arshath Ali</h5>
                                    <h6 class="font-weight-bold my-3">Tiruvarur,Tamilnadu</h6>
                                    <ul class="list-unstyled d-flex justify-content-center">
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star text-info"></i></li>
                                    </ul>
                                    <p class="mb-2">
                                        <i class="bi bi-quote quote-left pe-2"></i>இந்த நிறுவனத்தில் வாழ்க்கை முழுவதும் வருமானம் கிடைப்பது சந்தோஷம் <i class="bi bi-quote quote-right pe-2"></i>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Login Button -->
<div class="login-btn">
    <a href="login.php" style="background-color:#3eb3a8; color:white;" class="btn">Login</a>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>window.$zoho=window.$zoho || {};$zoho.salesiq=$zoho.salesiq||{ready:function(){}}</script><script id="zsiqscript" src="https://salesiq.zohopublic.in/widget?wc=siq7f332814434ba123f5efbf2d82a7e47947952e33ecc6bf4b78f9f89edf3ad350" defer></script>
</body>
</html>
