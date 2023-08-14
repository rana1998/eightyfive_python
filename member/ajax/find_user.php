<?php
// Get Country Details
include '../connection.php';

if (isset($_POST['username']) && !empty($_POST['username'])) {
    $userInput = $_POST['username'];
    $select = "SELECT * FROM user_registration WHERE user_name=? OR email=?";
    $stmt = mysqli_prepare($con, $select);
    
    // Bind the user input to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $userInput, $userInput);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    
    // Get the query result
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_num_rows($res);
    $data = mysqli_fetch_array($res);

    if ($row < 1) {
        echo 'No User Found with given Details';
    } else {
        $userName = $data['user_name'];
        $email = $data['email'];
        $fullName = $data['full_name'];
        $walletAddress = $data['wallet_address'];
        echo "<p>Username: $userName </p>";
        echo "<p>Email: $email </p>";
        echo "<p>Full Name: $fullName </p>";
        echo "<p>Wallet Address: $walletAddress </p>";
    }
}
?>
