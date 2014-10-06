<h1 class="center">Gestion des sorties</h1>
<h3 class="right news"><a href="?id=0">Ajouter une sortie</a></h2>

<?php
$id = $_GET['id'];
$inscrits = $db->query("SELECT id, nom, prenom, baudrier, casque FROM inscriptionsorties WHERE id_sortie='$id';")->fetchAll();
$listeinscrits = '';
$nb_casques = 0;
$nb_baudriers = 0;

foreach($inscrits as $row){
  $nom = $row['nom'];
  $prenom = $row['prenom'];
  $casque = $row['casque'];
  $baudrier = $row['baudrier'];
  $id_inscrit = $row['id'];
  $listeinscrits .= "<li>$nom, $prenom <a href='#uncheck'></a>
                        <form method='POST' action='#' class='hidden $id_inscrit' id='$id_inscrit'>
                          <label>Entrez votre mot de passe de déinscription</label>
                          <input type='password' name='password_uncheck' id='password_uncheck'>
                          <input type='hidden' name='id_inscrit' id='id_inscrit' value='$id_inscrit'>
                          <button type='submit' class='button tiny [radius round]' name='submit_uncheck' placeholder='Votre mot de passe'>Ok !</button>
                        </form>
                      </li>";
  if($casque == 1)
    $nb_casques++;
  if($baudrier == 1)
    $nb_baudriers++;
}
	$query = $db->query("SELECT id, title FROM sorties");
	$titles = $query->fetchAll();

	if(isset($_POST['submit'])){
		$news_author = str_replace('"', "'", $_POST['author']);
		$news_author = addslashes($news_author);

		$news_title = str_replace('"', "'", $_POST['title']);
		$news_title = addslashes($news_title);
		
		$news_date = addslashes($_POST['date']);
		$content = addslashes($_POST['content']);
		
		if($_POST['active'] == '1')
			$active = 1;
		else
			$active = 0;

		$db->query("INSERT INTO sorties VALUES (NULL, '$news_title', '$news_author', '$news_date', '$content', $active)");
		setFlash("La sortie $news_title a bien été ajoutée.");
		header('Location:sorties.php');
		die();
	}

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$current_title = $db->query("SELECT title FROM sorties WHERE id=$id")->fetch();

		if(isset($_POST['delete_news'])){ // Si le bouton supprimé est cliqué
			$db->query("DELETE FROM sorties WHERE id=$id");
			setFlash("La sortie $news_title a bien été supprimée.", 'alert');
			header('Location:sorties.php');
			die();
		}


		if(isset($_POST[$id])){ // Si bouton envoyer cliqué
			$news_author = str_replace('"', "'", $_POST['author']);
			$news_author = addslashes($news_author);

			$news_title = str_replace('"', "'", $_POST['title']);
			$news_title = addslashes($news_title);

			$news_date = addslashes($_POST['date']);
			$content =addslashes( $_POST['content']);
			if($_POST['active'] == '1')
				$active = 1;
			else
				$active = 0;

			$db->query("UPDATE sorties SET author='$news_author' WHERE id='$id'");
			$db->query("UPDATE sorties SET title='$news_title' WHERE id='$id'");
			$db->query("UPDATE sorties SET date='$news_date' WHERE id='$id'");
			$db->query("UPDATE sorties SET content='$content' WHERE id='$id'");
			$db->query("UPDATE sorties SET active='$active' WHERE id='$id'");
			setFlash("La sortie $news_title a bien été modifiée.");
			header('Location:sorties.php');
			die();
		}
}


?>

<div class="row">

	<ul class="large-2 columns side-nav">
		<p class="pdf">Sélectionner une sortie</p>

			<?php
			foreach($titles as $title){
				echo "<li><a href='?id=" . $title['id'] . "'><img src='../img/admin/arrow.png' alt='arrow'/>" . $title['title'] . '</a></li>';

			}
			?>
	</ul>

	<div class="large-7 columns">
		<?php 

		if(isset($_GET['id']) && $_GET['id'] == 0){
			echo '<form method="POST" action="#">
					<label>Auteur : </label><input type="text" name="author" required>
					<label>Titre (lieu) : </label><input type="text" name="title" required>
					<label>Date : </label><input type="date" name="date" required>
					<label>Affiché (oui/non) ? : </label>
						<input type="radio" name="active" value="1" id="active" checked="checked">Oui
						<input type="radio" name="active" value="0" id="active">Non
					<textarea class="news_form" name="content" required>Votre sortie.</textarea>
					<button type="submit" name="submit">Créer</button>
				   </form>';
		}


		if(!isset($id)){
				die('<h3>Sélectionnez une sortie pour la modifier</h3>'); } // Si pas d'id en GET, on n'affiche pas le formulaire

		if(!$current_title && $_GET['id'] != 0){
			echo('<h3>Cette sortie n\'existe pas !</h3>');
			die();
		}

		?>

		<?php if($_GET['id'] == 0){
			include '../partials/private/footer.php';
				die();
			}
		?>

		<h3 class="center"><?php echo $current_title['title'] . "   " ?></h3>

		<form method="POST" action="#">

			<label>Auteur : </label><?php echo input("sorties", "author", $id); ?>
			<label>Titre (lieu) : </label><?php echo input("sorties", "title", $id); ?>
			<label>Date : </label><?php echo input("sorties", "date", $id, "date"); ?>
			<label>Affiché (oui/non) ? :</label> <?php radio_show("sorties", "active", $id); ?>
			<?php echo textarea_news("sorties", "content", $id, "sorties_form"); ?>

		</form>

	</div>

	<ul class="large-3 columns side-nav">
  <?php if(empty($inscrits))
          echo "<p class='pdf'>Pas d'inscrits.</p>";
        else
          echo "<p class='pdf'>Liste des inscrits : </p>" . $listeinscrits;
 ?>
         <div class="panel center">
          <h3>Besoins en matériel :</h3>
          <p>Casques : <?php echo $nb_casques; ?></p>
          <p>Baudriers : <?php echo $nb_baudriers; ?></p>
        </div>
</ul>

</div>