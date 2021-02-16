<?php
session_start();

include "connection.php";

$id = $_GET['ID'];

$query = "SELECT * FROM `aafCards` WHERE id = $id";

$result = $con->query($query);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {




?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>AAF Card | <?php echo $row['child_name'] ?></title>


            <link rel="preconnect" href="https://fonts.gstatic.com">

            <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <!-- Jquery -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <!-- popper -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <!-- Bootstrap js -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <!-- Fontawesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
            <link rel="stylesheet" href="assets/fonts/font.css">
            <script src="assets/js/html2canvas.js"></script>
            <!-- <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script> -->
            <script src="assets/js/canvas2image.js"></script>


            <style>
                body {
                    background: linear-gradient(88deg, rgba(255, 255, 255, 1), rgba(211, 100, 80, 1), rgba(247, 153, 127, 1), rgba(211, 100, 80, 1), rgba(255, 255, 255, 1));
                    background-size: 400% 400%;
                    animation: gradient 8s ease infinite;
                }

                @keyframes gradient {
                    0% {
                        background-position: 0% 50%;
                    }

                    50% {
                        background-position: 100% 50%;
                    }

                    100% {
                        background-position: 0% 50%;
                    }
                }

                .shadow {
                    box-shadow: 0 10px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) !important;
                }

                .border-rounded {
                    border-radius: 35px;
                }

                .railway {
                    font-family: 'Raleway', sans-serif;
                }

            </style>
        </head>

        <body>
            <div class="container h-100">
                <div class="w-100 d-flex mt-5">
                    <img src="assets/images/aaf logo.png" class="ml-auto d-none d-md-block" style="width: 13%;">
                    <h2 class="mr-auto my-auto" style="font-family: 'Josefin Sans', sans-serif;"><strong>AKANKSHA ARADHYA FOUNDATION (AAF)</strong></h2>
                </div>

                <div class="w-100 d-flex mb-5">
                    <img src="<?php echo $row['child_image']; ?>" alt="Child Image" class="mx-auto rounded-circle shadow" style="width:188px;height:188px; border:4px solid white;">
                </div>

                <div class="border bg-light border-rounded mt-5 shadow main">
                    <div class="container">
                        <?php
                        if (isset($_SESSION['email'])) {
                        ?>
                            <div class="d-flex">
                                <div class="mr-auto px-2 py-4">
                                    <a href="index.php">
                                        <i class="fa fa-arrow-alt-circle-left"></i> Back
                                    </a>

                                </div>
                                <div class="ml-auto px-2 py-4">
                                    <a href="logout.php">
                                        <i class="fa fa-sign-out-alt"></i> Log out
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="row m-4 h-100">
                            <div class="col-md-6 border p-4 rounded">
                                <h3>
                                    <strong class="railway">Personal Details</strong>
                                </h3>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th>AAF ID</th>
                                            <td><?php echo $row['aaf_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td><?php echo $row['child_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Father's / Spouse name</th>
                                            <td><?php echo $row['father_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mother's name</th>
                                            <td><?php echo $row['mother_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Aadhaar Card</th>
                                            <td><?php echo $row['aadhaar']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td><?php echo $row['gender'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td><?php
                                                $today = new DateTime(date('y-m-d'));
                                                $dob = new DateTime($row['date_of_birth']);
                                                $diff = $today->diff($dob);
                                                echo $diff->y . ' Years ' . $diff->m . ' Months ' . $diff->d . ' Days';
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <th>Registered on</th>
                                            <td><?php
                                                $timestamp = new DateTime($row['timestamp']);
                                                echo $timestamp->format('d/m/20y');
                                                ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 my-auto">
                                <div class="d-flex">
                                    <img src="<?php echo $row['card_url_id']; ?>" class="w-75 mx-auto">
                                </div>
                            </div>
                        </div>
                        <div class="row m-4 h-100">
                            <div class="col-md-6 border rounded p-4 my-1">
                                <h3>
                                    <strong class="railway">Sponsor's Details</strong>
                                </h3>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Sponsor's name</th>
                                            <td><?php echo $row['sponsor_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Sponsoring upto</th>
                                            <td><?php
                                                if ($row['sponsoring_period']) {
                                                    echo $row['sponsoring_period'];
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 border rounded p-4 my-1">
                                <h3>
                                    <strong class="railway">Contact Details</strong>
                                </h3>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Contact number</th>
                                            <td><?php echo $row['contact_number'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            if (isset($_SESSION['email'])) {
                            ?>
                                <button type="button" class="btn btn-lg btn-block btn-primary border-rounded my-4" data-toggle="modal" data-target="#idCard">Generate ID Card</button>
                                <div class="modal fade" id="idCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div style="border:2px solid black" id="capture">
                                                    
                                                    <div class="row h-100 mx-auto" style="width:100%">
                                                        <div class="col-9 pb-5" >
                                                            <div class="d-flex mt-4">
                                                                <h3 class="mx-auto my-auto text-center" style="font-family: 'Times New Roman';font-size:2.75rem;font-weight:200;">AKANKSHA ARADHYA<br>FOUNDATION</h3>
                                                            </div>
                                                            <hr class="my-4" style="position:absolute;left:-2px;width:120%;border-bottom:8px solid black">
                                                            <table class="table-borderless w-100 my-5" style="height:68%;background-image: url('assets/images/AAF.png'); background-repeat: no-repeat;background-size:contain;background-position: center; ">
                                                                <tbody>
                                                                    <tr style="font-family:arial;font-weight:200;">
                                                                        <th style="font-size:22px;">AAF ID</th>
                                                                        <th style="font-size:22px;">:&nbsp;&nbsp;&nbsp;<?php echo $row['aaf_id'] ?></th>
                                                                    </tr>
                                                                    <tr style="font-family:arial;font-weight:200;">
                                                                        <th style="font-size:22px;">Name</th>
                                                                        <th style="font-size:22px;">:&nbsp;&nbsp;&nbsp;<?php echo $row['child_name'] ?></th>
                                                                    </tr>
                                                                    <tr style="font-family:arial;font-weight:200;">
                                                                        <th style="font-size:22px;">Father / Spouse</th>
                                                                        <th style="font-size:22px;">:&nbsp;&nbsp;&nbsp;<?php echo $row['father_name'] ?></th>
                                                                    </tr>
                                                                    <tr style="font-family:arial;font-weight:200;">
                                                                        <th style="font-size:22px;">Mother</th>
                                                                        <th style="font-size:22px;">:&nbsp;&nbsp;&nbsp;<?php echo $row['mother_name'] ?></th>
                                                                    </tr>
                                                                    <tr style="font-family:arial;font-weight:200;">
                                                                        <th style="font-size:22px;">D.O.B.</th>
                                                                        <th style="font-size:22px;">:&nbsp;&nbsp;&nbsp;<?php echo $row['date_of_birth'] ?></th>
                                                                    </tr>
                                                                    <tr style="font-family:arial;font-weight:200;">
                                                                        <th style="font-size:22px;">Gender</th>
                                                                        <th style="font-size:22px;">:&nbsp;&nbsp;&nbsp;<?php echo $row['gender'] ?></th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-3 pt-4" style="background-color:#b34f3e">
                                                            <div class="d-flex">
                                                                <div class="mx-auto my-1">
                                                                    <img src="<?php echo $row['child_image'] ?>" alt="Child Image" class="rounded w-100" style="border:2px solid white;">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="mx-auto mt-1 p-3">
                                                                    <img src="<?php echo $row['card_url_id'] ?>" alt="Child QR Code" class="w-100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex">
                                                    <div class="mx-auto my-3">
                                                        
                                                        <button class="btn btn-primary border-rounded" onclick="doCapture()">Save &amp; Download</button>
                                                        <script>
                                                            function doCapture() {
                                                                window.scrollTo(0, 0);
                                                                html2canvas(document.getElementById("capture")).then(function(canvas) {

                                                                    // Create an AJAX object
                                                                    var ajax = new XMLHttpRequest();

                                                                    // Setting method, server file name, and asynchronous
                                                                    ajax.open("POST", "save-card.php", true);

                                                                    // Setting headers for POST method
                                                                    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                                                                    // Sending image data to server
                                                                    ajax.send("image=" + canvas.toDataURL("image/jpeg", 1) + "&name=<?php echo $row['child_name'].$row['id'];?>");

                                                                    // Receiving response from server
                                                                    // This function will be called multiple times
                                                                    ajax.onreadystatechange = function() {

                                                                        // Check when the requested is completed
                                                                        if (this.readyState == 4 && this.status == 200) {

                                                                            // Displaying response from server
                                                                            var win = window.open("<?php echo $row['child_name'].$row['id'].".jpeg" ?>", '_blank');
                                                                            if (win) {
                                                                                //Browser has allowed it to be opened
                                                                                win.focus();
                                                                            } else {
                                                                                //Browser has blocked it
                                                                                alert('Please allow popups for this website');
                                                                            }
                                                                        }
                                                                    };
                                                                });
                                                            }
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>




            </div>
            <div class="sticky-top">
                <p class="text-center my-3"><strong>Visit our site <span><a href="http://www.akankshaaradhyafoundation.com/index.php" target="_blank">AAF</a></span></strong></p>
            </div>
        </body>

        </html>
    <?php
    }
} else {
    ?>
    <h1>404 Not found</h1>
<?php
}
$con->close();





?>