<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Accès au formulaire</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <script src="/ckeditor/ckeditor.js"></script>
    </head>
    <body>

        <?php
    if (isset($_POST['mot_de_passe']) AND $_POST['mot_de_passe'] ==  "Talmont") // Si le mot de passe est bon
    {
    // On affiche les codes
    ?>
        <h1>Accès au formulaire :</h1>
<p>Cette page est réservée au personnel.</p>
<form method="post" action="screensaver.php">
   <p>
       <label for="messageVeille">
       </label>
       <br />
          <textarea cols="80" class="ckeditor" id="editeur" name="editeur" rows="10"></textarea>
       <input type="submit" value="Valider" />


   </p>
</form>

<?php
    }
    else // Sinon, on affiche un message d'erreur
    {
        echo '<p>Mot de passe incorrect</p>';
	}

	?>


    </body>
</html>

