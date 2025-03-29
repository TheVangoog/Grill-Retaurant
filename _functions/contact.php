<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    echo "Data received successfully:<br>";
    foreach($_POST as $key => $value) {
        echo $key . ': ' , $value , '<br>';
    }
} else {
    echo "No data was received";
}

?>