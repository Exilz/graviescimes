<?php

function select($id, $options = array()){
	$return = "<select class='form-group' id='$id' name='$id'>";
	foreach($options as $k => $v){
		$selected = '';
		if(isset($_POST[$id]) && $k== $_POST[$id]){
			$selected = 'selected ="selected"';
		}
		$return .= "<option value='$k' $selected>$v</option>";
	}
	$return .= '</select>';
	return $return;
}