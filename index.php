<?php
session_start();
if (!isset($_SESSION['email'])) {
?>
    <script>
        alert("You are not authorised to see this page kindly login!");
        window.location = "login.php";
    </script>
    <?php
} else {

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'qr_codes' . DIRECTORY_SEPARATOR;

    //html PNG location prefix
    $PNG_WEB_DIR = 'qr_codes/';
    include('connection.php');
    include "phpqrcode/qrlib.php";



    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    // Append the host(domain name, ip) to the URL.   
    $url .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL   
    $url .= $_SERVER['REQUEST_URI'];







    if (isset($_POST['submit'])) {
        $aaf_id = mysqli_real_escape_string($con, $_REQUEST['aaf_id']);
        $child_name = mysqli_real_escape_string($con, $_REQUEST['child_name']);
        $father_name = mysqli_real_escape_string($con, $_REQUEST['father_name']);
        $mother_name = mysqli_real_escape_string($con, $_REQUEST['mother_name']);
        $date_of_birth = mysqli_real_escape_string($con, $_REQUEST['date_of_birth']);
        $contact_number = mysqli_real_escape_string($con, $_REQUEST['contact_number']);
        $gender = mysqli_real_escape_string($con, $_REQUEST['gender']);
        $aadhaar = mysqli_real_escape_string($con, $_REQUEST['aadhaar']);
        $sponsor_name = mysqli_real_escape_string($con, $_REQUEST['sponsor_name']);
        $sponsoring_period    = mysqli_real_escape_string($con, $_REQUEST['sponsoring_period']);


        // Image file name
        $child_image_name = $_FILES['child_image']['name'];
        $child_image_file_name = pathinfo($child_image_name, PATHINFO_FILENAME);

        // Image/File Temp Name
        $child_image_tmp_name = $_FILES['child_image']['tmp_name'];

        // Image/File explodation
        $child_image_name_ext = explode('.', $child_image_name);

        // Image/File check if extension is right or not
        $child_image_name_ext_check = strtolower(end($child_image_name_ext));

        // Store the extension of Image/File
        $child_image_name_ext_store = array('png', 'jpg', 'jpeg');

        // Check The extension for further process
        if (in_array($child_image_name_ext_check, $child_image_name_ext_store)) {
            $child_image_directory  = "children/" . date('Y') . "/" . date('m') . "/" . date('d');


            if (file_exists($child_image_directory)) {
            } else {
                mkdir($child_image_directory, 0777, true);
            }
            $x = 1;


            $destination_child_image = 'children/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $child_image_name;
            while (file_exists($destination_child_image)) {
                $child_image_name = (string) $child_image_file_name . $x;
                $destination_child_image = 'children/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $child_image_name . '.' . $child_image_name_ext_check;
                $x++;
            }
            move_uploaded_file($child_image_tmp_name, $destination_child_image);
        }






        $q = "INSERT INTO `aafCards`(`aaf_id`, `child_name`, `date_of_birth`, `father_name`, `mother_name`, `contact_number`, `child_image`, `gender`, `sponsor_name`, `sponsoring_period`, `aadhaar`) VALUES ('".$aaf_id."', '" . $child_name . "','" . $date_of_birth . "','" . $father_name . "','" . $mother_name . "','" . $contact_number . "','" . $destination_child_image . "','" . $gender . "', '" . $sponsor_name . "', '" . $sponsoring_period . "','" . $aadhaar . "')";


        if ($con->query($q) === TRUE) {
            // header("refresh:1;url=./");
            $id = $con->insert_id;
            // echo "HO GYA BALE BALE!!";


            //ofcourse we need rights to create temp dir
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);


            $filename = $PNG_TEMP_DIR . $child_name . '.png';

            //processing form input
            //remember to sanitize user input in real-life solution !!!
            $errorCorrectionLevel = 'L';
            // if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
            //     $errorCorrectionLevel = $_REQUEST['level'];    

            $matrixPointSize = 10;
            // if (isset($_REQUEST['size']))
            //     $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


            // user data
            $filename = $PNG_TEMP_DIR . $child_name . md5("http://akankshaaradhyafoundation.com/aafcards/card.php?ID='" . $id . "'" . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
            QRcode::png("http://akankshaaradhyafoundation.com/aafcards/card.php?ID='" . $id . "'", $filename, $errorCorrectionLevel, $matrixPointSize, 2);

            $qr_code = "qr_codes/" . $child_name . md5("http://akankshaaradhyafoundation.com/aafcards/card.php?ID='" . $id . "'" . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';


            $updateURL = "UPDATE `aafCards` SET card_url_id = '" . $qr_code . "' WHERE id = " . $id . "";



            if ($con->query($updateURL) === TRUE) {

    ?>
                <script type="text/javascript">
                    alert("We have saved and created your card successfully");
                </script>
    <?php
                header("refresh:1;url=card.php?ID='$id'");
            } else {
                echo $updateURL;
            }
        } else {
            echo $q;
        }
    }

    ?>




    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ID Card Genrator</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <!-- popper -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <!-- Bootstrap js -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
        <style>
            body {
                background: linear-gradient(80deg, rgba(255, 255, 255, 1), rgba(211, 100, 80, 1), rgba(247, 153, 127, 1), rgba(211, 100, 80, 1), rgba(255, 255, 255, 1));
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
                <h2 class="mr-auto my-auto"><strong>AKANKSHA ARADHYA FOUNDATION (AAF)</strong></h2>
            </div>
            <form method="post" enctype="multipart/form-data" class="border bg-light p-5 border-rounded mt-5" style="box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;">
                <div class="d-flex">
                    <div class="ml-auto">
                        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Log out</a>
                    </div>
                </div>
                <legend><strong>Create ID Card</strong></legend>
                <small>(Fields with <span class="text-danger"><strong>*</strong></span> are mandatory)</small>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>AAF ID<span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="Enter AAF ID" name="aaf_id" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Child name<span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="Enter child name" name="child_name" required>
                        </div>
                        <div class="col-md-6">
                            <label>Gender<span class="text-danger"><strong>*</strong></span></label>
                            <select name="gender" class="form-control" required>
                                <option disabled="true" selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Child's Father name<span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="Enter child's father name" name="father_name" required>
                        </div>
                        <div class="col-md-6">
                            <label>Child's Mother name<span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="Enter child's mother name" name="mother_name" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Date of birth</label>
                            <input type="date" class="form-control" name="date_of_birth" min="<?php
                                                                                                $year = date('20' . 'y') - 125;
                                                                                                echo date($year . '-m-d');
                                                                                                ?>" max="<?php
                                                                                                            echo date('20' . 'y-m-d');
                                                                                                            ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Child Image<span class="text-danger"><strong>*</strong></span></label>
                            <input type="file" class="form-control" accept="image/*" name="child_image" required>
                        </div>
                        <div class="col-md-4">
                            <label>Contact Number</label>
                            <div class="input-group">
                                <div class="input-group-prepand">
                                    <span class="input-group-text" id="validationTooltipUsernamePrepend">
                                        +91
                                    </span>
                                </div>
                                <input type="number" class="form-control" placeholder="Enter mobile no." pattern="[0-9]{10}" name="contact_number">
                                <style>
                                    /* Chrome, Safari, Edge, Opera */
                                    input::-webkit-outer-spin-button,
                                    input::-webkit-inner-spin-button {
                                        -webkit-appearance: none;
                                        margin: 0;
                                    }

                                    /* Firefox */
                                    input[type=number] {
                                        -moz-appearance: textfield;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Aadhaar card number</label>
                            <input type="text" class="form-control" placeholder="Enter aadhaar number" pattern="[0-9]{12}" name="aadhaar">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Sponsor's name<span class="text-danger"><strong>*</strong></span></label>
                            <input type="text" class="form-control" placeholder="Enter sponsor's name" name="sponsor_name" required>
                        </div>
                        <div class="col-md-6">
                            <label>Sponsoring upto</label>
                            <input type="date" placeholder="Enter sponsoring date" class="form-control" name="sponsoring_period" min="<?php echo date('20' . 'y-m-d') ?>">
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="mx-auto">
                        <button name="button" type="reset" class="btn btn-outline-secondary m-1">Reset</button>
                        <button name="submit" type="submit" class="btn btn-primary m-1">Submit</button>
                    </div>
                </div>
            </form>
            <div class="sticky-top">
                <p class="text-center my-3"><strong>Visit our site <span><a href="http://www.akankshaaradhyafoundation.com/index.php" target="_blank">AAF</a></span></strong></p>
            </div>
        </div>
    </body>

    </html>
<?php
}
