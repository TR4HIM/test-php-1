<?php

$valueGlobal 	= 75300;
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


function randDomNumbers($valuePr,$joursPr,$basePr,$globalValue) {
	$list = [];

	$value 			= $valuePr;
	$jours 			= $joursPr;
	$base  			= $basePr;

	$min = ($value * 0.01) * -1;
	$max = ($value * 0.01) * 1;

	$randomFloat 	= ($min + ($max - $min) * (mt_rand() / mt_getrandmax()));

	if($joursPr == 1){
		echo   'jour : ' . $jours . ' valu : '  . round($value + $randomFloat,2)    . '<br>';
		die('Here');
	}

	

	$minValue 	= round($base  / $jours , 2);
	$maxValue 	= round($value / $jours , 2);

	$randomNumber  = round(rand($minValue,$maxValue) + $randomFloat, 2);
	echo 'jour : ' . $jours . ' number : ' . $randomNumber  . '<br>';
	$nextValue 	= $value - $randomNumber;
	$nextJour 	= $jours - 1;
	randDomNumbers($nextValue,$nextJour,$base,$globalValue);
}


randDomNumbers($valueGlobal , $jours , $base, $valueGlobal);

/*echo $minValue . '<br>';
echo $maxValue . '<br>';*/