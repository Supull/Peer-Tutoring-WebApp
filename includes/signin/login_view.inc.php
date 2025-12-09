<?php
declare(strict_types=1);

//Handles CSS for inout data validation

function input_validation() {
    if (isset($_SESSION['VALIDATION_ERRORS'])) {
        $ERRORS = $_SESSION['VALIDATION_ERRORS'];

        echo "<br>";

        //Goes over errors and displays to user
        foreach ($ERRORS as $ERROR) {
            echo '<p class="form-error" style="margin-left: 90px; color: white;">' . $ERROR . '</p>';
        }

        //Clear VALIDATION_ERRORS
        unset($_SESSION['VALIDATION_ERRORS']);

    
    } else if (isset($_GET["login"]) && $_GET["login"] === "success") {
        //Hanlde valid login
        echo '<br>';
        echo '<p class="form-success" style="margin-left: 75px; color: white;">Login success!</p>';
    }
}
?>
