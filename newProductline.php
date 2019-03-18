<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    if(!isset($_COOKIE['administrator'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'admin_login.php\'">';
    }
    
    // create a productline object

    $productLineObject = new ProductLine;
    $result1 = FALSE;
    $result2 = FALSE;
    $result3 = FALSE;
    $err_message = "";
    $err_message2 = "";

    //check for if the productline is saved

    if(isset($_POST['productLineSave'])) {

        $productLine = filter_input(INPUT_POST, 'productline', FILTER_SANITIZE_MAGIC_QUOTES);
        $textDescription = filter_input(INPUT_POST, 'textDescription', FILTER_SANITIZE_MAGIC_QUOTES);
        $htmlDescription = filter_input(INPUT_POST, 'htmlDescription', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $productLineObject->productLine = $productLine;
        $productLineObject->textDescription = $textDescription;
        $productLineObject->htmlDescription = $htmlDescription;
        $testReturn =  $productLineObject->get_productline();
        $testResult = $testReturn->fetch();
        if($productLine == $testResult['productLine']){
            $err_message = "There is already an category with this name";
            $result3 = TRUE;
        } else {
            $result1 = $productLineObject->create_productline();
        }

        if(isset($_FILES["fileToUpload"])&&$result1) {

            if(is_uploaded_file($_FILES["fileToUpload"]["tmp_name"]) ) {
                $target_file = basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                
                // Check if image file is a actual image or fake image
                
                if(isset($_POST["submit"])) {
                
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                
                    if($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $err_message = "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                
                // check that it has the right type
                
                if($imageFileType != "jpg" && $imageFileType != "png" &&
                $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $err_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                } 

                // upload if it passes all checks
                if($uploadOK==1){
                    $image = $_FILES['fileToUpload'];
                    $productLineObject->image = $image;
                    $result2 = $productLineObject->upload_picture();
                }
            }
        }
        if($result2 || $result1) {
            echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=productlines\'">';
        } elseif($result3){
                
        } elseif (!$result1) {
            $err_message2 = "Something is wrong in the save function. Contact support.";
        }
    }

    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
</head>
<body>
<?php include_once 'headnav.php'; ?> 
    
    <main>
        <!-- List the different info -->
        <form action="newProductline.php" method="post">
            <table>
                <tbody>
                    <tr>
                        <td>Kategori</td>
                        <td>
                            <input name="productline" type="text"></td>
                    </tr>
                    <tr>
                        <td>Text beskrivning</td>
                        <td><input type="text" name="textDescription"></td>
                    </tr>
                    <tr>
                        <td>HTML beskrivning</td>
                        <td><input type="text" name="htmlDescription"><td>
                    </tr>
                    <tr>
                        <td>Image</td>
                        <td>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="submit" name="productLineSave" value="Spara">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $err_message; ?>
                        </td>
                        <td>
                            <?php echo $err_message2; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </main>
</body>
</html>