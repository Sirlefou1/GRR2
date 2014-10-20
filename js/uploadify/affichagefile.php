
<?php
// ANTHNOY ARCHAMBEAU 
// AFFICHAGE DES FICHIERS LIES A LA RESERVATION APRES SUPRESSION DES FICHIERS SELECTIONNES 

// On se connecte à la bdd pour effectuer notre requete sql 
include "../include/connect.inc.php";
include "../include/mysql.inc.php";
include "../include/misc.inc.php";

$id = $_GET['id']; // On récupère l'id de la réservation , précédement passé dans $GET grâce à notre script AJAX 


$res = grr_sql_query("SELECT nom FROM ".TABLE_PREFIX."_files WHERE identry = '".$id."' ");
$nbresult = mysql_num_rows($res); // compte le nombre de lignes retournées 


$monUrl = "http://".$_SERVER['HTTP_HOST']."/uploadify/files/"; // lien vers le répertoir d'upload
if ($nbresult != 0) { // Si on a un fichier correspondant à la réservation ouverte 
	echo"<br /> <br /> ";
	echo"Fichier(s) lié(s) à cette réservation : <br /> ";
	echo"<TABLE border = 1 '>";
    for ($i = 0; ($row777 = grr_sql_row($res, $i)); $i++){ 
          // // pour chaques tuples renvoyés dans  $res 
		$nom = $row777[0]; // on attribut à la variable nom , la valeur du champs nom (0)  à l'indice $i
						   // de la boucle
		echo"<tr>";
		echo"<TD><a href='".$monUrl."".$nom."' class=\"button\">'".$nom."'</a>  <br /></TD>";
							// on affiche le liens correspondant à notre fichié uploadé en concatainant
							// le chemin du repertoire d'upload avec notre nom complet de fichier 
		echo"<TD><a href=".$nom." class=\"deletefile\" value=".$id." > <img src=\"uploadify/uploadify-cancel.png\"</a> </TD>";
		echo"</tr>";
		
		}
		echo"</TABLE>";
}


?>
