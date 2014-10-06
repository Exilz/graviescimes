<h1 class="center">Gestion des pré-inscriptions</h1>

<?php

if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	$select = $db->query("DELETE FROM inscriptions WHERE id=$id;");
	setFlash("L'inscription $id a été supprimée");
	header('Location:inscriptions.php');
	die();
}

if(isset($_GET['activate'])){
	$id = $_GET['activate'];
	$select = $db->query("UPDATE inscriptions SET valide='1' WHERE id='$id';");
	setFlash("L'inscription $id a été activée");
	header('Location:inscriptions.php');
	die();
}

if(isset($_GET['unactivate'])){
	$id = $_GET['unactivate'];
	$select = $db->query("UPDATE inscriptions SET valide='0' WHERE id='$id';");
	setFlash("L'inscription $id a été désactivée");
	header('Location:inscriptions.php');
	die();
}

if(isset($_GET['up'])){ // Voir commentaires pour down
	$id = intval($_GET['up']);
	$age = $db->query("SELECT age FROM inscriptions WHERE id='$id';")->fetch();
	$age = $age['age'];
	$idarray = array();

		if($id > 0){
			$select = $db->query("SELECT id FROM inscriptions WHERE age='$age';")->fetchAll();
			foreach($select as $row){
				array_push($idarray, $row['id']);
			}
			
			$tempid = $id;

			foreach($idarray as $row){
				$test = intval($row);
				
				if($tempid > $test){
					$newid = $test;
				}
				
				if(!isset($newid)){
					header('Location:inscriptions.php');
					die();
				}
			}

			$db->query("UPDATE inscriptions SET id='4545' WHERE id='$id'"); // On passe à 4545 celle à changer
			$db->query("UPDATE inscriptions SET id='$id' WHERE id='$newid'"); // On change celle à permuter par la précédente
			$db->query("UPDATE inscriptions SET id='$newid' WHERE id='4545'"); // On passe 4545 à la nouvelle bonne ID
		}

	header('Location:inscriptions.php');
	die();
}

if(isset($_GET['down'])){
	$id = intval($_GET['down']); // On transforme l'id string en int

	 // On récupere l'age et on crée un tableau vide
	$age = $db->query("SELECT age FROM inscriptions WHERE id='$id';")->fetch();
	$age = $age['age'];
	$idarray = array();
	//

		if($id >= 0){

			//On crée un tableau avec toutes les id pour cet âge
			$select = $db->query("SELECT id FROM inscriptions WHERE age='$age';")->fetchAll();
			foreach($select as $row){
				array_push($idarray, $row['id']);
			}
			array_reverse($idarray);
			//

			$tempid = $id; // Variable tampon pour la permutation

			// On teste jusqu'à trouver l'id la plus petite en dessous qui deviendra la nouvelle id $newid
			foreach($idarray as $row){
				$test = intval($row);
				if(isset($newid)) $test = $newid;
				
				if($tempid < $test){
					$newid = $test;
				}
			}
			//

			/* Si on a trouvé cette nouvelle ID, on permute avec un tampon de 9999
			 (jamais atteint donc pas de clé primaire dupliquée)
			*/

			if(isset($newid)){
			$db->query("UPDATE inscriptions SET id='99999' WHERE id='$id'");
			$db->query("UPDATE inscriptions SET id='$id' WHERE id='$newid'");
			$db->query("UPDATE inscriptions SET id='$newid' WHERE id='99999'");
		}
		}

	header('Location:inscriptions.php');
	die();
}


?>

<div class="row">

<ul class="large-2 columns side-nav show-for-large-up texts-nav">
	<p class="pdf">Accès rapide</p>
  <li><a href="#79"><img src="../img/admin/arrow.png" alt="arrow" />7-9 ans</a></li>
  <li><a href="#1012"><img src="../img/admin/arrow.png" alt="arrow" />10-12 ans</a></li>
  <li><a href="#1317"><img src="../img/admin/arrow.png" alt="arrow" />13-17 ans</a></li>
  <li><a href="#18"><img src="../img/admin/arrow.png" alt="arrow" />Adultes</a></li>
</ul>

<div class="large-9 columns">

		<?php inscrits_table("7-9 ans", "79"); 
			  inscrits_table("10-12 ans", "1012");
			  inscrits_table("13-17 ans", "1317");
			  inscrits_table("Adultes", "18");
		?>

</div>

</div>