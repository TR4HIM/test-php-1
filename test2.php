<?php

$valueGlobal 	= 80;
$jours 			= 3;
$base  			= 50;

$val = rand(0,1)*2-1;

//$randomFloat 	=  rand(-1.5, 1.5);
$min = ($valueGlobal * 0.01) * -1;
$max = ($valueGlobal * 0.01) * 1;

$maxV = $valueGlobal + $max;
$minV = $valueGlobal + $min;

echo "<b>". $valueGlobal ."</b><br>";
echo "<b>". $jours ."</b><br>";
echo "<b>". $base ."</b><br>";
echo "<b> min : ". $minV ."</b><br>";
echo "<b> max : ". $maxV ."</b><br>";


function randDomNumbers($valuePr,$start_date , $end_date ,$basePr) {
	$list = array();

	$min = ($valuePr * 0.01) * -1;
	$max = ($valuePr * 0.01) * 1;

	$randomFloat 	= ($min + ($max - $min) * (mt_rand() / mt_getrandmax()));

	

	$minValue 	= round($basePr  / $end_date  , 2);
	$maxValue 	= round($valuePr / $end_date  , 2);

	$randomNumber  = round(rand($minValue,$maxValue) + $randomFloat, 2);
 
	$list = array_merge($list,randDomNumbers($valuePr - $randomNumber,$start_date + 1 , $end_date ,$basePr));
 
	//$list[] = $valuePr;
		
 
	return $list;
}


var_dump(randDomNumbers($valueGlobal , 1, 2 , $base));

/*echo $minValue . '<br>';
echo $maxValue . '<br>';*/