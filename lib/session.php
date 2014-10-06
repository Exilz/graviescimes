<?php

if(!isset($_SESSION))
	session_start();

function flash(){
	if(isset($_SESSION['Flash'])){
		extract($_SESSION['Flash']);
		unset($_SESSION['Flash']);
		return "<div class='row'><div class='large-3 columns'>
		<div data-alert class='alert-box " . $type . " radius'>" .
              $message .
              "<a href='#' class='close'>&times;</a>
                </div></div></div>";
	}
}

function setFlash($message, $type = 'success'){
		$_SESSION['Flash']['message'] = $message;
		$_SESSION['Flash']['type'] = $type;
}