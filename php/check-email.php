<?php

if(isset($_POST['email'])) {
    $email = $_POST['email'];

    $query = 'SELECT id FROM accounts WHERE accounts.email = "' . $email . '";';
    $conn->query($query);

}
?>