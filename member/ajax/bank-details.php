<?php
// Get Country Details
include '../connection.php';



if(isset($_POST['changeBank']) && !empty($_POST['changeBank'])){

    $bankName = $_POST['changeBank'];

    $select="SELECT * FROM bank WHERE bank_name='$bankName'";
    $res=mysqli_query($con,$select);
    if (!$res) {
        mysqli_error($con);
    }
    $data=mysqli_fetch_assoc($res);
    
    $accountTitle= $data['account_title'];
    $accountNumber= $data['account_number'];

    echo 
    '
    <div class="input-group-sm m-2">
           <label class="col-form-label text-left" for="inputText3">Account Number</label>
           <h5 class="text-success" id="checkOutAccountNumber">'.$accountNumber.'</h5> 
    </div>
    <div class="input-group-sm m-2">
           <label class="col-form-label text-left" for="inputText3">Account Title</label>
           <h5 class="text-success" id="checkOutAccountTitle">'.$accountTitle.'</h5> 
    </div>
    ';

}

