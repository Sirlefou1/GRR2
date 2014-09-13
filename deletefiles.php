<?php
  
	include "include/connect.inc.php";
	include "include/mysql.inc.php";
	include "include/misc.inc.php";
	

   if (isset($_POST["link"]) && strlen($_POST["link"]) > 0) {
        // On récupère le nom de fichier
        $file = $_POST["link"]; 
        $path = "uploadify/files/";

        // On tente d'effacer le fichier, si il existe et si il est effacer
        // le retour sera à true
        if (unlink($path.$file)) {
            $sql = "DELETE from ".TABLE_PREFIX."_files WHERE nom = '".$file."' ";
			grr_sql_command($sql);
            echo "deleted";
        }
    }



?>
