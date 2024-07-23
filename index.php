<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Sidebar Example</title>
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
    </style>
</head>
<body>
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
                                        <img src="https://media.istockphoto.com/id/492529287/photo/portrait-of-happy-laughing-man.jpg?s=612x612&w=0&k=20&c=0xQcd69Bf-mWoJYgjxBSPg7FHS57nOfYpZaZlYDVKRE="
                                            class="rounded-circle shadow-1-strong" width="100" height="100" />
                                    </div>
                                    <h5 class="font-weight-bold">John</h5>
                                    <h6 class="font-weight-bold my-3">Founder at ET Company</h6>
                                    <ul class="list-unstyled d-flex justify-content-center">
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-half text-info"></i></li>
                                    </ul>
                                    <p class="mb-2">
                                        <i class="bi bi-quote quote-left pe-2"></i>Lorem ipsum dolor sit amet,
                                        consectetur adipisicing elit. Quod eos id officiis hic tenetur quae quaerat
                                        ad velit ab hic tenetur.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="card">
                                <div class="card-body py-4 mt-2">
                                    <div class="d-flex justify-content-center mb-4">
                                        <img src="https://www.stryx.com/cdn/shop/articles/man-looking-attractive.jpg?v=1666662774"
                                            class="rounded-circle shadow-1-strong" width="100" height="100" />
                                    </div>
                                    <h5 class="font-weight-bold">Alex Carey</h5>
                                    <h6 class="font-weight-bold my-3">Photographer at Studio LA</h6>
                                    <ul class="list-unstyled d-flex justify-content-center">
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                    </ul>
                                    <p class="mb-2">
                                        <i class="bi bi-quote quote-left pe-2"></i>Autem, totam debitis suscipit saepe
                                        sapiente magnam officiis quaerat necessitatibus odio assumenda perferendis
                                        labore laboriosam.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Review 3 -->
                        <div class="col-md-4 mb-0">
                            <div class="card">
                                <div class="card-body py-4 mt-2">
                                    <div class="d-flex justify-content-center mb-4">
                                        <img src="https://media.istockphoto.com/id/2043245952/photo/portrait-smile-and-business-woman-in-office-workplace-and-female-person-on-computer-in.webp?b=1&s=170667a&w=0&k=20&c=oe5sdtU9ZbOflBnSK7oa3ivYv2SXXS8A43SIhTUXO2s="
                                            class="rounded-circle shadow-1-strong" width="100" height="100" />
                                    </div>
                                    <h5 class="font-weight-bold">Jenifer Winget</h5>
                                    <h6 class="font-weight-bold my-3">Front-end Developer in NY</h6>
                                    <ul class="list-unstyled d-flex justify-content-center">
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star-fill text-info"></i></li>
                                        <li><i class="bi bi-star text-info"></i></li>
                                    </ul>
                                    <p class="mb-2">
                                        <i class="bi bi-quote quote-left pe-2"></i>Cras sit amet nibh libero, in gravida
                                        nulla metus scelerisque ante sollicitudin commodo cras purus odio,
                                        vestibulum in tempus viverra turpis.
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
    <a href="login.php"  style="background-color:#3eb3a8; color:white;" class="btn" >Login</a>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>window.$zoho=window.$zoho || {};$zoho.salesiq=$zoho.salesiq||{ready:function(){}}</script><script id="zsiqscript" src="https://salesiq.zohopublic.in/widget?wc=siq7f332814434ba123f5efbf2d82a7e47947952e33ecc6bf4b78f9f89edf3ad350" defer></script>
</body>
</html>
