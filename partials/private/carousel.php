<h1 class="center">Gestion du carousel</h1>
<?php

$storeFolder = '../img/carousel';
$storeFolderDelete = '../img/carousel/';
$authorizedExtensions = array("jpg", "png", "jpeg");

if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	$name = $db->query("SELECT file FROM carousel WHERE position='$id'")->fetch();
	$name = $name['file'];
	$onlyName = explode('.', $name);
	$onlyName = $onlyName[0];
	$extension = explode('.', $name);
	$extension = $extension[1];

	$db->query("DELETE FROM carousel WHERE position=$id;");

	unlink($storeFolderDelete .  $name); // Supprime le fichier du serveur
	unlink($storeFolderDelete . 'thumbnails/' . $name); // Supprime la miniature
	
	setFlash("L'image $name a bien été supprimée", 'alert');
	header('Location:carousel.php');
	die();
}

if (!empty($_FILES)) { // Si des fichiers sont glissés


	// Upload des images sur le site
	    $tempFile = $_FILES['file']['tmp_name'];            
	    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $storeFolder;
	    $targetFile =  $targetPath. $_FILES['file']['name'];
	    $nameFile = explode('/', $_FILES['file']['tmp_name'])[2];
		$extension = explode('.', $_FILES['file']['name'])[1];
		$extension = strtolower($extension);
		$dbName = $nameFile . '.' . $extension;
	    $onlyName = explode('.', $nameFile);
	    $onlyName = $onlyName[0];

	    if(in_array($extension, $authorizedExtensions)){ // si l'extension est bonne

	    	if($extension == "jpg" || $extension == "jpeg")
	    		$chosenImage = imagecreatefromjpeg($_FILES['file']['tmp_name']);

	    	if($extension == "png")
	    		$chosenImage = imagecreatefrompng($_FILES['file']['tmp_name']);

	    	$chosenImageSize = getimagesize($_FILES['file']['tmp_name']);


	    	// Création miniature
			$newWidth = 200;
			$Reduction = ( ($newWidth * 100)/$chosenImageSize[0] );
			$newHeight = ( ($chosenImageSize[1] * $Reduction)/100 );
			$newImage = imagecreatetruecolor($newWidth , $newHeight) or die ("Erreur");
			imagecopyresampled($newImage , $chosenImage, 0, 0, 0, 0, $newWidth, $newHeight, $chosenImageSize[0],$chosenImageSize[1]);
			imagejpeg($newImage , '../img/carousel/thumbnails/' . $nameFile . '.' . $extension, 100);
			////////////////////////////////////////////

			// Création image pour carousel
			$newWidth = 1920;
			$Reduction = ( ($newWidth * 100)/$chosenImageSize[0] );
			$newHeight = ( ($chosenImageSize[1] * $Reduction)/100 );
			$newImage = imagecreatetruecolor($newWidth , $newHeight) or die ("Erreur");
			imagecopyresampled($newImage , $chosenImage, 0, 0, 0, 0, $newWidth, $newHeight, $chosenImageSize[0],$chosenImageSize[1]);
			imagejpeg($newImage , '../img/carousel/' . $nameFile . '.' . $extension, 100);		
			////////////////////////////////////////////	

	    	$db->query("INSERT INTO carousel VALUES('$dbName', NULL);"); // Insertion du nom du fichier sur la table carousel
	    }
	   		 

 }


$select = $db->query("SELECT file, position FROM carousel")->fetchAll();
$list = ""; // Liste vide à concaténer

foreach($select as $row){ // Crée l'HTML pour chaque vignette
	$file = $row['file'];
	$extension = explode('.', $file);
	$extension = $extension[1];
	$nameOnly = explode('.', $file);
	$nameOnly = $nameOnly[0];
	$fileAndExtension = $nameOnly . '.' . $extension;

	$position = $row['position'];
	$list .= "<li><a href='?delete=$position'><img src='../img/admin/deleteimage.png' alt='delete' class='delete'></a><img src='../img/carousel/thumbnails/$fileAndExtension' alt='$file' class='th'></li>";
}

?>

<div class="row">

	<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-5">
	  <?php if(!empty($list))
	  			echo "<h3>Images déjà présentes</h3><br/>" . $list;
	  		else
	  			 echo "<h3>Pas d'images pour le moment</h3><br/>"; ?>
	</ul>

	<div class="large-3 columns">
		<div class="panel callout radius">
		  <p>N'utilisez que des images au format <strong>.jpg/.jpeg</strong> ou <strong>.png</strong>.</p>
		  <p>Les images sont aggrandies pour figurer pleine largeur sur les écrans hautes définition, veillez donc à utiliser de grandes images <strong>en largeur</strong>.</p>
		  <p>Utilisez des images raisonnablement hautes pour que le confort de lecture ne soit pas impacté. <strong>recommandé : 550px</strong>.
		  <p>Vous pouvez importer autant d'images que vous le voulez en même temps, <strong>pensez à recharger la page une fois l'envoi effectué</strong> pour voir les images envoyées.</p>
		</div>
	</div>

	<div class="large-9 columns">
		
		<form action="carousel.php" class="dropzone"></form>

	</div>

</div>