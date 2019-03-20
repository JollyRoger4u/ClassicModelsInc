<?php  $session_test = session_start();
        if(!$session_test) {
            echo "Session har inte startat.";
        }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    include_once "classes.php";
    // check that you are logged in otherwise reroute to login page

    if(!(isset($_SESSION['administrator']))) {
        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'admin_login.php\'">';
    }
    
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

        echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'Admin.php?page=productlines\'">';
    }

    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ändra kategori</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="admin.css">
    <script src="admin.js"></script>
</head>
<body>
<?php include_once 'headnav.php'; ?>
    
    <main>
        <!-- List the different info -->
        <?php
        //fetch the productline to alter from post

        $productLine = filter_input(INPUT_POST, 'productline', FILTER_SANITIZE_MAGIC_QUOTES);

        $productLineObject->productLine = $productLine;

        $result = $productLineObject->get_productline();
        $row = $result->fetch();
        ?>
        <form action="alterProductline.php" method="post">
            <table>
                <tbody>
                    <tr>
                        <td>Kategori</td>
                        <td><input type="hidden" name="productline" value="<?php echo $row['productLine']; ?>">
                            <input type="text" value="<?php echo $row['productLine']; ?>" disabled></td>
                    </tr>
                    <tr>
                        <td>Text beskrivning</td>
                        <td><input type="text" name="textDescription" value="<?php echo $row['textDescription']; ?>"></td>
                    </tr>
                    <tr>
                        <td>HTML beskrivning</td>
                        <td><input type="text" name="htmlDescription" value="<?php echo $row['htmlDescription']; ?>"><td>
                    </tr>
                    <tr>
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