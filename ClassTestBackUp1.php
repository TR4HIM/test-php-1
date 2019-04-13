<?php


class totalSpliter {
	private $total 		= 650;
	private $base  		= 10;
	private $dateStart 	= 1;
	private $dateEnd 	= 10;
	private $listNumber 	= 10;

	function  __construct(){
		echo "<pre>";
		echo "<b> Total : 30 , Jours : 4 , Base : 5 </b><br> ";
		//echo $this->rand_float(0.36,5.36) ."<br>";
		//die();

		$varList = $this->getRandomNumber(30,1,10,5);
		var_dump($varList );
		var_dump(array_sum($varList));
	}


	public function getRandomNumber($total,$startDate,$endDate,$baseLine) {
		$list = [];
		$onePerCentTotal	= ($total * 0.01);
		$globalTotal		= $total ;

		if(($endDate - $startDate) > 1){
			$minValue 			= round($baseLine  / ($endDate - $startDate) , 2);
			while($startDate < $endDate) {

				$maxValue 			= round($globalTotal - ($minValue * ($endDate - $startDate)) , 2);
				$randomNumber  		= mt_rand($minValue * 100, $maxValue * 100) / 100 ;
				$list[$startDate] 	= $randomNumber;
				$startDate++;
				$globalTotal = $globalTotal - $randomNumber;
			}
		}


		$arraySum 		= array_sum($list);
		$AboveOnePer 	= $total + $onePerCentTotal - $arraySum;
		$BellowOnePer 	= $total - $onePerCentTotal - $arraySum;

		$lastNumber 		= mt_rand($BellowOnePer  * 100, $AboveOnePer * 100) / 100;
		$list[$endDate] 	= $lastNumber;

		return $list;
	}
}


$distrubed = new totalSpliter();
