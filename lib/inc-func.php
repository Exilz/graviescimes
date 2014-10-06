<?php

require_once 'db.php';

function login_input($id){
	$value = isset($_POST['id']) ? $_POST[$id] : '';
	return "<input type='text' class='form-group' id='$id' name='$id' value='$value'>";
}

/*
	* Récupère un texte dans la base de données.
*/

function fetch_text($table, $row, $ref){
	global $db;
	$text = $db->query("SELECT $row FROM $table WHERE ref='$ref'")->fetch();
	return $text[$row];
}

/*
	* Crée un textarea pré-rempli (hors news)
*/

function textarea($table, $row, $ref, $class){
	global $db;
	$text = $db->query("SELECT $row FROM $table WHERE ref='$ref'")->fetch();
	$text = $text[$row];
	$submit = $ref . "_submit";
	return "<form method='POST' action='#'>
			<textarea class='$class' name='$ref'>$text</textarea>
			<button type='submit' name='$submit'>Envoyer</button>
			</form>
			";
}

/*
	* Crée un textarea pré-rempli (news)
*/

function textarea_news($table, $row, $id, $class){
	global $db;
	$text = $db->query("SELECT $row FROM $table WHERE id='$id'")->fetch();
	$text = $text[$row];
	return "<textarea class='$class' name='content'>$text</textarea>
			<button type='submit' name='$id'>Envoyer</button>
			<button type='submit' class='button alert right' name='delete_news'>Supprimer</button>
			";
}

/*
	* Crée un input pré-rempli.
*/

function input($table, $row, $id, $type="text"){
	global $db;
	$text = $db->query("SELECT $row FROM $table WHERE id='$id'")->fetch();
	$text = $text[$row];
	$text = str_replace('"', "'", $text);

//	return "<input type='$type' value='$text' name='$row'/>";
	return '<input type="' . $type . '" value="' . $text . '" name="' . $row . '"/>';
}

/*
	* Radio form pour afficher.
*/

function radio_show($table, $row, $id){
	global $db;
	$query = $db->query("SELECT $row FROM $table WHERE id=$id")->fetch();
	$active = $query['active'];

	if($active == "0"){
		echo "<input type='radio' name='active' value='1' id='active'>Oui";
		echo "<input type='radio' name='active' value='0' id='not_active' checked='checked'>Non";
	}else{
		echo "<input type='radio' name='active' value='1' id='active' checked='checked'>Oui";
		echo "<input type='radio' name='active' value='0' id='not_active'>Non";
	}
}

/*
	* Créer tableaux pré-inscrits
*/

function inscrits_table($titre, $age){
	global $db;

$select = $db->query("SELECT * FROM inscriptions WHERE age='$age';")->fetchAll();

	if(empty($select)){
		echo "<h3 id='$age'>$titre</h3>
				<h4>Personne n'est inscrit dans cette catégorie.</h4>";
	}
	else{
		echo "
		<table>
			<h3 id='$age'>$titre</h3>
		  <thead>
		    <tr>
		      <th width='75'>Pos.</th>
		      <th>Nom</th>
		      <th>Prénom</th>
		      <th>Mail</th>
		      <th>Téléphone</th>
		      <th>Adresse</th>
		      <th>Date inscription</th>
		      <th width='90'>Validé</th>
		      <th>Supprimer</th>
		    </tr>
		  </thead>
		  <tbody>";

	foreach($select as $row){

		if($row['valide'] == '0')
			$valide = 'Non | <a href="?activate='. $row['id'] . '"><img src="../img/admin/check.png" alt="activate"></a>';
		else
			$valide = 'Oui | <a href="?unactivate='. $row['id'] . '"><img src="../img/admin/uncheck.png" alt="unactivate"></a>';

		echo "<tr>
				<td><a href='?up=" . $row['id'] . "'><img src='../img/admin/up.png' alt='up'></a><a href='?down=" . $row['id'] . "'><img src='../img/admin/down.png' alt='down'></a></td>
				<td>" . $row['nom'] . "</td>
				<td>" . $row['prenom'] . "</td>
				<td><a href='mailto:" . $row['mail'] . "'>" . $row['mail'] . "</a></td>
				<td>" . $row['tel'] . "</td>
				<td>" . $row['adresse'] . "</td>
				<td>" . $row['date'] . "</td>
				<td>" . $valide . "</td>
				<td><a href='?delete=" . $row['id'] . "'>Supprimer</a></td>
			  </tr>";

	}
		 echo '</tbody>
		</table>';
	}

	
}