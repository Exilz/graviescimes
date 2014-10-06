<h1 class="center">Gestion de la galerie photo</h1>
<?php

$storeFolder = '../img/gallery/';
$storeFolderDelete = '../img/gallery/';
$authorizedExtensions = array("jpg", "png", "jpeg");

if(isset($_GET['id'])){ // Récupération catégorie
	$id = $_GET['id'];
	$current_gategory = $db->query("SELECT name FROM gallery_categories WHERE id='$id';")->fetch();
	$current_gategory = $current_gategory['name'];
}

if(isset($_GET['delete'])){ // Suppression catégories
	$delete = $_GET['delete'];
	$db->query("DELETE FROM gallery_categories WHERE id='$delete';");
	setFlash('Cette catégorie a bien été supprimée', 'warning');
	header('Location:gallery.php');
	die();
}
	
$categories = $db->query("SELECT * FROM gallery_categories;")->fetchAll();
$photos = $db->query("SELECT id, file FROM gallery_images WHERE id_category = '$id';")->fetchAll();
$listecategories = NULL;
$listePhotos = NULL;

foreach($categories as $row){ // Liste catégories
	$id_category = $row['id'];
	$name_category = $row['name'];
	$listecategories .= "<li><a href='gallery.php?id=$id_category'>$name_category</a></li>";
}

if(isset($_POST['submit_uncheck']) && isset($_POST['new_category_name'])){ // Création de catégories
	$new_category_name = $_POST['new_category_name'];
	$db->query("INSERT INTO gallery_categories VALUES(NULL, '$new_category_name');");
	setFlash("La catégorie $new_category_name a bien été ajoutée");
	header('Location:gallery.php');
	die();
}

if(isset($_GET['deleteimage'])){ // Suppression des images déjà envoyées
	$idToDelete = $_GET['deleteimage'];
	$nameToDelete = $db->query("SELECT file FROM gallery_images WHERE id='$idToDelete';")->fetch();
	unlink($storeFolderDelete .  $nameToDelete); // Supprime le fichier du serveur
	$db->query("DELETE FROM gallery_images WHERE id='$idToDelete';");
	setFlash("L'image a bien été supprimée");
	header("Location:gallery.php?id=$id");
	die($storeFolderDelete .  $nameToDelete);
}

if (!empty($_FILES)) { // Si des fichiers sont glissés

		$tempFile = $_FILES['file']['tmp_name'];
		$type = explode('/', $_FILES['file']['type']);
		$type = strtolower($type[1]);
		$nom = md5(uniqid(rand(), true)); 
		$dbName = $nom . '.' . $type; 
		$insertId = $id;
	   

	   if($type == 'jpg' || $type == 'jpeg' || $type == 'png'){
	   		 move_uploaded_file($tempFile, $storeFolder . $nom . '.' . $type);
	   		 $db->query("INSERT INTO gallery_images VALUES(NULL, '$dbName', '$insertId');");
		}

}

foreach($photos as $row){
	$fileId = $row['id'];
	$file = $row['file'];
	$listePhotos .= "<li class='listgallery'><a href='../img/gallery/$file'>$file</a><a href='gallery.php?id=$id&deleteimage=$fileId'><img src='../img/admin/deleteimage.png' class='delete deleteimage' alt='delete'></a></li>";
}

?>

<div class="row">

		<div class="panel callout radius">
		  <p>N'utilisez que des images au format <strong>.jpg/.jpeg</strong> ou <strong>.png</strong>.</p>
		  <p>Vous pouvez importer autant d'images que vous le voulez en même temps, <strong>pensez à recharger la page une fois l'envoi effectué</strong> pour voir les images envoyées.</p>
		</div>

	<div class="large-9 columns">
		<?php if(!isset($id)){
					echo "<h2>Sélectionnez une catégorie de photos à droite pour pouvoir envoyer des photos</h2>";
				}
			  elseif(!isset($current_gategory)){
			  		echo "<h2>Aucune catégorie n'existe avec cette ID";
			  		die();
			  	}
			  else
			  		echo "<h2 class='center'>Gestion de la galerie $current_gategory</h2><a href='gallery.php?delete=$id'><h5 class='danger'>Supprimer cette catégorie</h4></a>";
		
		if(isset($current_gategory)){
			echo "<form action='gallery.php?id=$id' class='dropzone'></form>";
			echo "<h2 class='center'>Liste des photos de cette catégorie : </h2>";
			echo $listePhotos;
		}

		?>
	</div>

	<div class="large-2 columns side-nav">
		<h3>Catégories de photos</h3>
		<h4 class="center createcategory underline">Créer une catégorie</h4>
		
		<form method='POST' action='#' class='hidden createcategoryform'>
           <input type='text' name='new_category_name' id='new_category_name'>
            <button type='submit' class='button tiny [radius round]' name='submit_uncheck' placeholder='Votre mot de passe'>Ok !</button>
         </form>

		<ul>
			<?php if(isset($listecategories))
						echo $listecategories;
					else
						echo '<h4>Pas de catégories pour le moment</h4>';
			?>

		</ul>
	</div>

</div>