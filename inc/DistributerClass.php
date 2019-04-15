<?php
/* 
	File : algorithm class 
*/

class DistributerClass {

	private $totalAmount ;
	private $baseLine ;
	private $startDate ;
	private $endDate ;
	private $amountPerDayList ;

	function  __construct($start_date , $end_date , $total , $baseline){

		//Save data Globaly (In case we need it)
		$this->totalAmount 	= $total;
		$this->baseLine 	= $baseline;
		$this->startDate	= $start_date;
		$this->endDate		= $end_date;

		// Init function GetRandomNumber
		$this->amountPerDayList 	= $this->getRandomNumber($this->startDate,$this->endDate,$this->totalAmount,$this->baseLine);
	}

	/* 
		Check day if it's a weekend
	*/
	private function isWeekend($date) {
	    return (date('N', strtotime($date)) >= 6);
	}

	/* 
		return number of weeks days in the range given
	*/
	private function getWeekDays($startDate,$endDate){
		$weekDays 	= 0;
		
		while (strtotime($startDate) <= strtotime($endDate)) {
            if(!$this->isWeekend($startDate))
            	$weekDays++;

            $startDate = date ("Y-m-d", strtotime("+1 day", strtotime($startDate)));
		}

		return $weekDays;
	}

	private function getRandomNumber($start_date , $end_date , $total , $baseline) {

		// Array to save all random amount to calculate the Generated numbers 
		$list 				= [];
		// Array to save the final results
		$listDates 			= [];

		// Calculate and save Total amount + 1% and Total amount - 1%
		$totalMax			= $total + ($total * 0.01);
		$totalMin			= $total - ($total * 0.01);
		
		// Get number of weekdays bewteen two dates 
		$weekDays 			= $this->getWeekDays($start_date,$end_date);

		//Counter to stop the loop before the last date
		$counter 			= 1;

		//Calculate the min amount for each day based on Base Line and Weekdays
		//Added a condition if the user entred Start Date == End date 
		//NB :: I Return an error for user 

		$minValue 			= ($weekDays > $counter) ? round($baseline  / ($weekDays - $counter) , 2) : 1;

		
		while (strtotime($start_date) <= strtotime($end_date)) {	


            if(!$this->isWeekend($start_date)){
				/* 
					If the day is not a weekend
					we genereate a random amount for that day
				*/
				if($counter < $weekDays) {
					/* 
						Check if it's not the last weekday 
					*/

					// Limit the max amount for each day based on the reains weekdays and the total remains
					$maxValue 					= round($total - ($minValue * ($weekDays - $counter)) , 2);

					//Get a random amount between MinValue (Minimun amount to spend each dat) and MaxValue
					$randomNumber  				= mt_rand($minValue * 100, $maxValue * 100) / 100 ;

					//Save the random amount in the list
					$list[$counter] 			= $randomNumber;

					//Save the random amount for each date
					$listDates[] 				=  ['date' => $start_date , 'amount' => $randomNumber];

					//Minus the amount we spend from the total
					$total 	   				   -= $randomNumber;

					//Incress counter to move to next day
					$counter++;

				} else {
					/* 
						If it's the last day
					*/

					//We calculate the sum of amounts we spend in all previous days
					$arraySum 			= array_sum($list);

					// Max random amount for the last day based on TotalMax (Total + 1% Total) Minus the amounts we spend
					$AboveOnePer 		= $totalMax - $arraySum;

					// Min random amount for the last day based on TotalMin (Total - 1% Total) Minus the amounts we spend
					//We check if the MinAmount for the last day is bellow our MINAMOUNT for each day
					//we return the default min amount for each day

					$BellowOnePer 		= ( ($totalMin - $arraySum) > $minValue) ? ($totalMin - $arraySum) : $minValue;

					//Generate the the amount for the last day
					$lastNumber 		= mt_rand($BellowOnePer  * 100, $AboveOnePer * 100) / 100;

					//Save the amount (( we don't need it :) ))
					$list[$weekDays] 	= $lastNumber;

					//Save the amount for the last date
					$listDates[] 		= ['date' => $start_date , 'amount' => $lastNumber];
				}

            }else{
				/* 
					If it's a weekend we assign 0 to the amount
				*/
            	$listDates[] =  ['date' => $start_date , 'amount' => 0];
            }

			//Incresse the day by one for the loop
            $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		}

		// Return array with values
		return $listDates;
	}

	/* 
		Helper public function to convert and retrun data  
	*/
	public function getJson(){
		echo json_encode(['success' => $this->amountPerDayList]);
	}
}