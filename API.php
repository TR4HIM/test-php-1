<?php
include 'inc/DistributerClass.php';
//header('Content-Type: application/json');


$postTotal      = $_POST['total-amount'];
$postBaseLine   = $_POST['base-line'];
$postStartDate  = $_POST['start-date'];
$postEndDate    = $_POST['end-date'];

if(empty($postTotal) || empty($postBaseLine)  || empty($postStartDate)  || empty($postEndDate ) ){
    echo json_encode(['error-required' => 'All fields are required']);
    die();
}

if(!is_numeric($postTotal) || !is_numeric($postBaseLine)) {
    echo json_encode(['error-type-number' => 'It s not a number']);
    die();
}

if ((DateTime::createFromFormat('Y-m-d', $postStartDate) === false) || (DateTime::createFromFormat('Y-m-d', $postEndDate) === false)) {
    echo json_encode(['error-type-date' => 'It s not a real date']);
    die();
}


$distrubed = new DistributerClass('2019-04-29','2019-05-13',40,5);
$distrubed->getJson();
echo "Good";