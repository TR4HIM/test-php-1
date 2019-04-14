<?php


class DistributerClass {

	private $totalAmount ;
	private $baseLine ;
	private $startDate ;
	private $endDate ;
	private $amountPerDayList ;

	function  __construct($start_date , $end_date , $total , $baseline){
		$this->totalAmount 	= $total;
		$this->baseLine 	= $baseline;
		$this->startDate	= $start_date;
		$this->endDate		= $end_date;

		$this->amountPerDayList 	= $this->getRandomNumber($this->startDate,$this->endDate,$this->totalAmount,$this->baseLine);
	}

	public function isWeekend($date) {
	    return (date('N', strtotime($date)) >= 6);
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

		$totalMax			= $total + ($total * 0.01);
		$totalMin			= $total - ($total * 0.01);

		$weekDays 			= $this->getWeekDays($start_date,$end_date);

		$counter 			= 1;

		$minValue 			= ($weekDays > $counter) ? round($baseline  / ($weekDays - $counter) , 2) : 1;

		while (strtotime($start_date) <= strtotime($end_date)) {	
            if(!$this->isWeekend($start_date)){

				if($counter < $weekDays) {

					$maxValue 					= round($total - ($minValue * ($weekDays - $counter)) , 2);

					$randomNumber  				= mt_rand($minValue * 100, $maxValue * 100) / 100 ;

					$list[$counter] 			= $randomNumber;

					$listDates[] 				=  ['date' => $start_date , 'amount' => $randomNumber];

					$total 	   				   -= $randomNumber;

					$counter++;

				} else {

					$arraySum 			= array_sum($list);

					$AboveOnePer 		= $totalMax - $arraySum;

					$BellowOnePer 		= ( ($totalMin - $arraySum) > $minValue) ? ($totalMin - $arraySum) : $minValue;

					$lastNumber 		= mt_rand($BellowOnePer  * 100, $AboveOnePer * 100) / 100;

					$list[$weekDays] 	= $lastNumber;

					$listDates[] 		= ['date' => $start_date , 'amount' => $lastNumber];
				}

            }else{
            	$listDates[] =  ['date' => $start_date , 'amount' => 0];
            }

            $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		}

		return $listDates;
	}

	public function getJson(){
		echo json_encode(['success' => $this->amountPerDayList]);
	}
}