<?php

///// check if is login and not valid return validation page 
if(isset($_SESSION['user'])){
	$typeacc=$_SESSION['user'][1];
	if($typeacc==0) $cmpt="freelancer";
	else $cmpt="entreprise";
	$isval = $conn->query("SELECT acc_valide FROM $cmpt WHERE id={$_SESSION['user'][0]}")->fetch_array()['acc_valide'];
	if($isval==0) header("location: activation.php");
}
?>