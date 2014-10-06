<div id="footer">
  <ul class="links">
    <li><a href="http://iut.univ-amu.fr/sites/arles">Réalisation IUT Arles.</a></li>
  </ul>
</div>
   
    <script src="../js/jquery.js"></script>
    <script src="../js/foundation.min.js"></script>
    <script src="../js/foundation/foundation.orbit.js"></script>
    <script src="../js/foundation/foundation.alert.js"></script>
    <script src="../js/tinymce/tinymce.min.js">/</script>
    <script src="../js/dropzone/dropzone.min.js">/</script>
    <script src="../js/createcategory.js"></script>

    <script>
      $(document).foundation();
      
      tinyMCE.init({mode : "textareas", plugins : "code"});

       $('a[href^="#"]').click(function(){   // Smooth scrolling
      var the_id = $(this).attr("href");  
      $('html, body').animate({  
          scrollTop:$(the_id).offset().top  
      }, 'slow');  
      return false;  
  });  
      
    </script>
  </body>
</html>
