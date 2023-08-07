<?php
if (isset($_POST['request-cancel'])) {
    // Redirect the user back to the previous page
    if (isset($_SERVER['HTTP_REFERER'])) {
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        echo $_SERVER['HTTP_REFERER'];
    } else {
        // If no previous page information is available, redirect to a default page
        header("Location: index.php");
    }
    exit();
}


?>