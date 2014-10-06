<?php
$news = $db->query("SELECT * FROM news")->fetchAll();
$sorties = $db->query("SELECT * FROM sorties")->fetchAll();
$selectCarousel = $db->query("SELECT file, position FROM carousel")->fetchAll();
$datesArray = array();

          function aasort (&$array, $key) {
              $sorter=array();
              $ret=array();
              reset($array);
              foreach ($array as $ii => $va) {
                  $sorter[$ii]=$va[$key];
              }
              asort($sorter);
              foreach ($sorter as $ii => $va) {
                  $ret[$ii]=$array[$ii];
              }
              $array=$ret;
          }

?>

<ul class="orbit" data-orbit data-options="variable_height: true;">
  <?php 
  $carousel = "";
  foreach($selectCarousel as $row){
      $file = "img/carousel/" . $row['file'];
      $position = $row['position'];
      $carousel .= "<li><img src='$file'alt='$position' class='carousel_image'/></li>";
  }
  echo $carousel;
  ?>
</ul>

  <div class="presentation">
    <?php echo fetch_text("texts", "content", "small_pres"); ?>

    <div class="sep-shadow"></div>

  </div>

<div class="row">

  <div class="large-8 columns news">
    <p class="title-content">News</p>
        <ul class="news-orbit" data-orbit data-options="timer_speed:100000;navigation_arrows:true;">
          <?php foreach($news as $row){
            $active = $row['active'];
            if($active == '1'){
            $title = $row['title'];
            $date = $row['date'];
            $date = date("d-m-Y", strtotime($date));
            $author = $row['author'];
            $content = $row['content'];
            echo "<li>
                    <p class='title-news'>$title, le $date par $author</p>
                    $content
                  </li>" ;}
          } ?>
        </ul>
  </div>

  <div class="large-3 columns sorties">
    <p class="title-content">Sorties</p>
        <ul class="news-orbit" data-orbit data-options="timer_speed:50000;navigation_arrows:true;">
          <?php 

       foreach($sorties as $row){ // Récupération de toutes les orties, on les ajoute au tableau si elles sont dans le futur
            $date = explode('-', $row['date']);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            $elapsedTimeToday = time();
            $elapsedTimeDate = mktime(0, 0, 0, $month, $day, $year);
            $row['elapsedTimeDate'] = $elapsedTimeDate;

            if($elapsedTimeDate > $elapsedTimeToday)
              array_push($datesArray, $row);

          } 

          aasort($datesArray,"elapsedTimeDate"); // On trie le tableau : sorties les plus proches au plus anciennes

          foreach($datesArray as $row){ // On les affiche avec des <li>

            $active = $row['active'];
              if($active == '1'){
                $title = $row['title'];
                $date = $row['date'];
                $author = $row['author'];
                $content = $row['content'];
                $id = $row['id'];
                echo "<li>
                        <p class='date'>$date : $title par $author</p>
                        $content <br/>
                        <a href='inscriptionsortie.php?id=$id' class='button small radius'>S'inscrire</a>
                      </li>" ;
                }
          }

        ?>
        </ul>
  </div>

</div>

<div class="partenaires">
      <p class="title-content">Partenaires</p>

      <ul class="small-block-grid-4">
        <li><a href="http://www.ville-arles.fr/"><img src="img/partenaires/arles.png" alt="arles" class="th"><p>Ville d'Arles</p></a></li>
        <li><a href="http://www.soescalade.com/"><img src="img/partenaires/conseilgeneral.png" alt="conseil" class="th"><p>Matériel d'escalade - SOS Escalade</p></a></li>
        <li><a href="http://www.cg13.fr/"><img src="img/partenaires/ministere.png" alt="ministere" class="th"></a><p>Conseil Général des Bouches-du-Rhône</p></li>
        <li><a href="http://www.sports.gouv.fr/"><img src="img/partenaires/randonnee.png" alt="randonnee" class="th"></a><p>Ministère de la jeunesse et des Sports</p></li>
      </ul>

</div>