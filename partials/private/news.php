<h1 class="center">Gestion des news</h1>
<h3 class="right news"><a href="?id=0">Créer une news</a></h2>

<?php
	$query = $db->query("SELECT id, title FROM news");
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

		$db->query("INSERT INTO news VALUES (NULL, '$news_title', '$news_date', '$news_author', '$content', $active)");
		setFlash("La news $news_title a bien été ajoutée.");
		header('Location:news.php');
		die();
	}

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$current_title = $db->query("SELECT title FROM news WHERE id=$id")->fetch();

		if(isset($_POST['delete_news'])){ // Si le bouton supprimé est cliqué
			$db->query("DELETE FROM news WHERE id=$id");
			setFlash("La news $news_title a bien été supprimée.", 'alert');
			header('Location:news.php');
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

			$db->query("UPDATE news SET author='$news_author' WHERE id='$id'");
			$db->query("UPDATE news SET title='$news_title' WHERE id='$id'");
			$db->query("UPDATE news SET date='$news_date' WHERE id='$id'");
			$db->query("UPDATE news SET content='$content' WHERE id='$id'");
			$db->query("UPDATE news SET active='$active' WHERE id='$id'");
			setFlash("La news $news_title a bien été modifiée.");
			header('Location:news.php');
			die();
		}
}


?>

<div class="row">

	<ul class="large-2 columns side-nav">
		<p class="pdf">Sélectionner une news</p>

			<?php
			foreach($titles as $title){
				echo "<li><a href='?id=" . $title['id'] . "'><img src='../img/admin/arrow.png' alt='arrow'/>" . $title['title'] . '</a></li>';

			}
			?>
	</ul>

	<div class="large-9 columns">
		<?php 

		if(isset($_GET['id']) && $_GET['id'] == 0){
			echo '<form method="POST" action="#">
					<label>Auteur : </label><input type="text" name="author" required>
					<label>Titre : </label><input type="text" name="title" required>
					<label>Date : </label><input type="date" name="date" required>
					<label>Affiché (oui/non) ? : </label>
						<input type="radio" name="active" value="1" id="active" checked="checked">Oui
						<input type="radio" name="active" value="0" id="active">Non
					<textarea class="news_form" name="content" required>Votre news.</textarea>
					<button type="submit" name="submit">Créer</button>
				   </form>';
		}


		if(!isset($id)){
				die('<h3>Sélectionnez une news pour la modifier</h3>'); } // Si pas d'id en GET, on n'affiche pas le formulaire

		if(!$current_title && $_GET['id'] != 0){
			echo('<h3>Cette news n\'existe pas !</h3>');
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

			<label>Auteur : </label><?php echo input("news", "author", $id); ?>
			<label>Titre : </label><?php echo input("news", "title", $id); ?>
			<label>Date : </label><?php echo input("news", "date", $id, "date"); ?>
			<label>Affiché (oui/non) ? :</label> <?php radio_show("news", "active", $id); ?>
			<?php echo textarea_news("news", "content", $id, "news_form"); ?>

		</form>

	</div>

</div>