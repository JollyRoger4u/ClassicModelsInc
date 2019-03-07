<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    /*if(!isset($_COOKIE['administrator'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php\'">';
    }*/ //enable when tables are complete
    
    // create a productline object

    $productLineObject = new ProductLine;

    //check for if the productline is saved

    if(isset($_POST['productLineSave'])) {
        $productLine = filter_input(INPUT_POST, 'productline', FILTER_SANITIZE_MAGIC_QUOTES);
        $textDescription = filter_input(INPUT_POST, 'textDescription', FILTER_SANITIZE_MAGIC_QUOTES);
        $htmlDescription = filter_input(INPUT_POST, 'htmlDescription', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $productLineObject->productLine = $productLine;
        $productLineObject->textDescription = $textDescription;
        $productLineObject->htmlDescription = $htmlDescription;
        $productLineObject->update_productline();

        if(isset($_FILES["fileToUpload"])) {

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
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                
                // check that it has the right type
                
                if($imageFileType != "jpg" && $imageFileType != "png" &&
                $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                } 

                // upload if it passes all checks
                if($uploadOK==1){
                    $image = $_FILES['fileToUpload'];
                    $productLineObject->image = $image;
                    $productLineObject->upload_picture();
                }
            }
        }
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=productlines\'">';
    }

    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <header>
        <a href="admin.php"><img src="/uploads/productImg/Centennial-Light.jpg"></a>
    </header>
    <nav>
        <ul>
            <li>
                <a href="admin.php?page=orders">Ordrar</a>
            </li>
            <li>
                <a href="admin.php?page=products">Produkter</a>
            </li>
            <li>
                <a href="admin.php?page=productlines">Kategorier</a>
            </li>
            <li>
                <a href="admin.php?page=customers">Kunder</a>
            </li>
            <li>
                <a href="admin.php?page=administrators">Administratörer</a>
            </li>
            <li>
                <a href="admin.php?page=profile">Min Profil</a>
            </li>
        </ul>
    </nav>   
    <?php
    include_once "functions.php";
    ?>
    
    <main>
        <!-- List the different info -->
        <?php
        //fetch the productline to alter from post

        $productLine = filter_input(INPUT_POST, 'productline', FILTER_SANITIZE_MAGIC_QUOTES);

        $productLineObject->productLine = $productLine;

        $result = $productLineObject->get_productline();
        ?>
        <form action="alterProductline.php" method="post">
            <table>
                <tbody>
                    <tr>
                        <td>Kategori</td>
                        <td><input type="hidden" name="productline" value="<?php echo $result['productLine']; ?>">
                            <input type="text" value="<?php echo $result['productLine']; ?>" disabled></td>
                    </tr>
                    <tr>
                        <td>Text beskrivning</td>
                        <td><input type="text" name="textDescription" value="<?php echo $result['textDescription']; ?>"></td>
                    </tr>
                    <tr>
                        <td>HTML beskrivning</td>
                        <td><input type="text" name="htmlDescription" value="<?php echo $result['htmlDescription']; ?>"><td>
                    </tr>
                    <tr>
                        <td>Image</td>
                        <td><img src="<?php 
                        
                        if($result['image']!=NULL) {

                        echo $result['image'];
                        
                        } else {
                            echo "#";
                        }
                        ?>"></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </td>
                        <td>
                            <input type="submit" name="productLineSave" value="Spara">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </main>
</body>
</html>