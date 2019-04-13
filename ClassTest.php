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

	 
		$varList = $this->getRandomNumber('2019-04-29','2019-05-10',30,5);
		var_dump($varList );
	}

	public function isWeekend($date) {
	    if (date('N', strtotime($date)) >= 6)
	    	return true;
	}

	public function getWeekDays($startDate,$endDate){
		$weekDays 	= 0;
		
		while (strtotime($startDate) <= strtotime($endDate)) {
            if(!$this->isWeekend($startDate))
            	$weekDays++;

            $startDate = date ("Y-m-d", strtotime("+1 day", strtotime($startDate)));
		}

		return $weekDays;
	}

	public function getRandomNumber($start_date , $end_date , $total , $baseline) {
		$list 				= [];
		$listDates 			= [];

		$onePerCentTotal	= ($total * 0.01);
		$globalTotal		= $total ;

		$weekDays 			= $this->getWeekDays($start_date,$end_date);

		$counter 			= 1;
		$minValue 			= ($weekDays > $counter) ? round($baseline  / ($weekDays - $counter) , 2) : 1;


		echo $weekDays . ' weekdayas <br>';
		echo $total + $onePerCentTotal . ' +1% <br>';
		echo $total - $onePerCentTotal . ' -1% <br>';
		echo $minValue . ' MinValue <br>';


		while (strtotime($start_date) <= strtotime($end_date)) {	
            if(!$this->isWeekend($start_date)){

				if($counter < $weekDays) {

					$maxValue 					= round($globalTotal - ($minValue * ($weekDays - $counter)) , 2);

					$randomNumber  				= mt_rand($minValue * 100, $maxValue * 100) / 100 ;

					$list[$counter] 			= $randomNumber;

					$listDates[] 				=  [$start_date => $randomNumber];

					$globalTotal 	   			-= $randomNumber;

					$counter++;

				}else{

					$arraySum 			= array_sum($list);
					$AboveOnePer 		= $total + $onePerCentTotal - $arraySum;
					$BellowOnePer 		= $total - $onePerCentTotal - $arraySum;

					$lastNumber 		= mt_rand($BellowOnePer  * 100, $AboveOnePer * 100) / 100;
					$list[$weekDays] 	= $lastNumber;


					$listDates[] 		=  [$start_date => $lastNumber];
				}

				
            }else{
            	$listDates[] =  [$start_date => 0];
            }

            $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		}

		return $listDates;
	}
}


$distrubed = new totalSpliter();
