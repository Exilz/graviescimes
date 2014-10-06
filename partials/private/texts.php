<h1 class="center">Gestion des textes</h1>

<?php

if(isset($_POST['small_pres_submit'])){ // Modification texte présentation court
	$content = addslashes($_POST['small_pres']);
	$query = $db->query("UPDATE texts SET content='$content' WHERE ref='small_pres'");
	setFlash('Texte de présentation de l\'accueil modifié.');
	header('Location:texts.php');
	die();
}

if(isset($_POST['long_pres_submit'])){ // Modification texte présentation long
	$content = addslashes($_POST['long_pres']);
	$query = $db->query("UPDATE texts SET content='$content' WHERE ref='long_pres'");
	setFlash('Texte de présentation modifié.');
	header('Location:texts.php');
	die();
}

if(isset($_POST['fonctionnement_submit'])){ // Modification texte fonctionnement
	$content = addslashes($_POST['fonctionnement']);
	$query = $db->query("UPDATE texts SET content='$content' WHERE ref='fonctionnement'");
	setFlash('Texte de fonctionnement modifié.');
	header('Location:texts.php');
	die();
}

if(isset($_POST['mentions_submit'])){ // Modification mentions légales
	$content = addslashes($_POST['mentions']);
	$query = $db->query("UPDATE texts SET content='$content' WHERE ref='mentions'");
	setFlash('Mentions légales modifiées.');
	header('Location:texts.php');
	die();
}

?>

<div class="row">

<ul class="large-3 columns side-nav show-for-large-up texts-nav">
	<p class="pdf">Accès rapide</p>
  <li><a href="#small_pres"><img src="../img/admin/arrow.png" alt="arrow" />Texte présentation accueil</a></li>
  <li><a href="#long_pres"><img src="../img/admin/arrow.png" alt="arrow" />Texte présentation Informations</a></li>
  <li><a href="#fonctionnement"><img src="../img/admin/arrow.png" alt="arrow" />Texte fonctionnement</a></li>
  <li><a href="#mentions"><img src="../img/admin/arrow.png" alt="arrow" />Mentions légales</a></li>
</ul>

	<div class="large-8 columns">
		<h3 id="small_pres">Texte présentation accueil</h3>
			<?php echo textarea("texts", "content", "small_pres", "small_pres_form"); ?>

		<h3 id="long_pres">Texte présentation Informations</h3>
			<?php echo textarea("texts", "content", "long_pres", "long_pres_form"); ?>

		<h3 id="fonctionnement">Texte fonctionnement</h3>
			<?php echo textarea("texts", "content", "fonctionnement", "fonctionnement_form"); ?>

		<h3 id="mentions">Mentions légales</h3>
			<?php echo textarea("texts", "content", "mentions", "mentions_form"); ?>
	</div>

</div>


