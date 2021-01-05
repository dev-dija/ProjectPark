<?php
/////////////////////Date to string Converter v. FR
/////////////////////Created : 30/05/2017
/////////////////////Function name : dateToString(version : Français)
/////////////////////Parametres 1 : type string
/////////////////////Date format : m/d/Y h:i:sa (a : am-pm)
/////////////////////Parametre must be in the same format
function dateToString($date){
	try{
		$d = new DateTime($date);
		$str = $d->format("d");
		switch($d->format("m")){
			case 1: $str.=" janvier ";break;
			case 2: $str.=" février ";break;
			case 3: $str.=" mars ";break;
			case 4: $str.=" avril ";break;
			case 5: $str.=" mai ";break;
			case 6: $str.=" juin ";break;
			case 7: $str.=" juillet ";break;
			case 8: $str.=" août ";break;
			case 9: $str.=" septembre ";break;
			case 10: $str.=" octobre ";break;
			case 11: $str.=" nouvembre ";break;
			case 12: $str.=" décembre ";break;
		}
		return $str.$d->format("Y");
	}catch(Exception $e){
		return $e->getMessage();// return the message error
	    exit(1);////////////////// then exit the function
	}
}
?>


<?php
/////////////////////Function calculate passed_time
/////////////////////Programmed by Zakaria HBA
/////////////////////Using PHP language
/////////////////////Function name : time_passed
/////////////////////Parametres 1 : type string (DateTime)
/////////////////////Parametres 2 : type string (message text ex : il y a, pondant...)
/////////////////////Date format : m/d/Y h:i:sa (a : am-pm)
/////////////////////Parametre must be in the same format
function time_passed($time='', $msg=''){
	try {
	    $date = date("m/d/Y h:i:sa"); /// current moment time
	    if($time == "") return "maintenant"; // return this moment's label and exit
		else{
			$ca = array("min","heur", "jour", "semaine", "mois", "anne");
			$this_moment = new DateTime($date); /// the current time
			$pdate = new DateTime($time); /// the given time
			$interval = $this_moment->diff($pdate);// the difference betweet now and the entered date
			$y = $interval->format('%y'); /////////// the diff by years
			$m = $interval->format('%m'); /////////// the diff by months
			$d = $interval->format('%d'); /////////// the diff by days
			$h = $interval->format('%h'); /////////// the diff by hours
			$mn = $interval->format('%i');/////////// the diff by minutes
			$s = $interval->format('%s'); /////////// the diff by seconds

			if($y){ // if the diff is upper than a year
				$time="$msg ".$y." ".$ca[5];
				if($y>1) $time.="s ";
				//$time.=" ago";
			}else{
				if($m){ // if the diff is upper than a month and lower than a year
					$time="$msg ".$m." ".$ca[4];
					if($m>1) $time.="s ";
					//$time.=" ago";
				}else{
					if($d>7){ // if the diff is upper than week and lower than a month
						$time="$msg ".(floor($d/7))." ".$ca[3];
						if(floor($d/7)>1) $time.="s ";
						//$time.=" ago";
					}else{
						if($d){ // if the diff is upper than day 
							$time="$msg ".$d." ".$ca[2];
							if($d>1) $time.="s ";
							//$time.=" ago";
						}else{
							if($h){ // if the diff is upper than an hour
								$time="$msg ".$h." ".$ca[1];
								if($h>1) $time.="s ";
								//$time.=" ago";
							}else{
								if($mn){ // if the diff is upper than a minute
									$time="$msg ".$mn." ".$ca[0];
									if($mn>1) $time.="s ";
									//$time.=" ago";
								}else{ // if the diff is lower than a minute
									$time = "maintenant";
								}
							}
						}
					}
				}
			}
		}
	} catch (Exception $e) {
	    return $e->getMessage();// return the message error
	    exit(1);////////////////// then exit the function
	}
	return $time; /// return the right time passsed
}
?>


<?php
/////////////////////Password generator
/////////////////////Created : 30/05/2017
/////////////////////Function name : generate_pwd
/////////////////////Parametres 1 : type int
/////////////////////Parametres 1 : type int
/////////////////////Parametres 1 : type int
function generate_pwd($nC, $nL, $nN){
$t=""; // initialize password
for($i=0;$i<$nC;$i++) $t=$t.chr(rand(65,90));
for($i=0;$i<$nL;$i++) $t=$t.chr(rand(97,122));
for($i=0;$i<$nN;$i++) $t=$t.chr(mt_rand(48,57));
$t=str_shuffle($t); // Shuffle password
return $t; // Return password
}
?>


<?php
////////////////:: Add notifications function
////////////////:: will control adding notofication from any page for any entry

function add_notify($content, $link, $type="bell text-blue"){
	@$conn->query("INSERT INTO notification VALUES('', '$content', CURDATE(), CURTIME(), '$link', '$type', 0)");
}
?>