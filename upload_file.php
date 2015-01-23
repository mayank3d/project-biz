<?php

$ex = "";
try {
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $extension = $_FILES["file"]["type"];
    $fileName = $_FILES["file"]["name"];
    $saveFileName = $_POST["userId"];
    $size = ($_FILES["file"]["size"] / 1024);

    if ((($extension == "image/gif") || ($extension == "image/jpeg") || ($extension == "image/jpg") || ($extension == "image/pjpeg") || ($extension == "image/x-png") || ($extension == "image/png")) && ($size < 20000)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
        } else {
            echo "Upload: " . $_FILES["file"]["name"] . "<br>";
            echo "Type: " . $_FILES["file"]["type"] . "<br>";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $saveFileName . '.png');
            include('SimpleImage.php');
            $image = new SimpleImage();
            $image->load("upload/" . $saveFileName . '.png');
            $image->resize(32, 32);
            $image->save("upload/" . $saveFileName . '_S.png');
            $image = new SimpleImage();
            $image->load("upload/" . $saveFileName . '.png');
            $image->resize(150, 150);
            $image->save("upload/" . $saveFileName . '_M.png');
            echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        }
    } else {
        echo "Invalid file";
    }
} catch (Exception $e) {
    $ex = $e;
}
header("Location: viewProfile.php?e=" . $ex);
?>