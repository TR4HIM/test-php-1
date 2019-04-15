<?php
/* 
	File : Http requests and Middleware
*/
include 'inc/DistributerClass.php';
header('Content-Type: application/json');

if(empty($_POST)){
    echo json_encode(['error' => 'Access denied']);
    die();
}
$postTotal      = $_POST['total-amount'];
$postBaseLine   = $_POST['base-line'];
$postStartDate  = $_POST['start-date'];
$postEndDate    = $_POST['end-date'];

//Check if the fields contain only numbers
if(!is_numeric($postTotal) || !is_numeric($postBaseLine)) {
    echo json_encode(['error' => 'Please enter a valid number']);
    die();
}

//Check if the total is more than base line
if( $postTotal < $postBaseLine ) {
    echo json_encode(['error' => 'Total should be more than base line']);
    die();
} 

//Check base line value
if( $postBaseLine > 100 ||  $postBaseLine < 0) {
    echo json_encode(['error' => 'Base line should be betewen 0 and 100']);
    die();
}

//Check if dates are valide
if ((DateTime::createFromFormat('Y-m-d', $postStartDate) === false) || (DateTime::createFromFormat('Y-m-d', $postEndDate) === false)) {
    echo json_encode(['error' => 'Please enter a valide date']);
    die();
}


if (strtotime($postStartDate) >= strtotime($postEndDate)) {
    echo json_encode(['error' => 'Start date should be before end date']);
    die();
}

//Initial DistributerClass with post Values
$distrubed = new DistributerClass($postStartDate,$postEndDate,$postTotal,$postBaseLine);
//Get JSON data
$distrubed->getJson();