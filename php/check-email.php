<?php
    header('Content-Type: application/json');
    if(isset($_POST['email'])) {
        $email = $_POST['email'];

        //Connect to database
        $conn = new mysqli("localhost", "f36im", "f36im", "f36im");

        if ($conn->connect_error) {
            echo json_encode(true);
            exit();
        }

        $query = 'SELECT id FROM accounts WHERE accounts.email = "' . $email . '";';
        $result = $conn->query($query);


        echo json_encode((!$result || $result->num_rows > 0));

    }
?>