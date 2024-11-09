<?php
// Function to display errors
function displayError($error_message) {
    echo '<div style="color: red; font-weight: bold;">Error: ' . $error_message . '</div>';
}

// Function to display success messages
function displaySuccess($success_message) {
    echo '<div style="color: green; font-weight: bold;">Success: ' . $success_message . '</div>';
}

// Function to display info messages
function displayInfo($info_message) {
    echo '<div style="color: blue; font-weight: bold;">Info: ' . $info_message . '</div>';
}
?>
