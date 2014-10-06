<?php

if(isset($_POST['coords_submit'])){ // Modification mentions légales
	$content = addslashes($_POST['coords']);
	$query = $db->query("UPDATE texts SET content='$content' WHERE ref='coords'");
	setFlash('Coordonnées modifiées.');
	header('Location:coords.php');
	die();
}

?>

<h1 class="center">Modification des coordonnées</h1>


<div class="row">

	<div class="large-8 columns">
			<?php echo textarea("texts", "content", "coords", "coords_form"); ?>
	</div>

</div>


