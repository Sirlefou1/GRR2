<?php

//DAVID VOUE 04/02/2014 -- Importation des fichiers n�ccessaires

include "include/connect.inc.php";
include "include/config.inc.php";
include "include/misc.inc.php";
include "include/functions.inc.php";
include "include/$dbsys.inc.php";
include "include/mincals.inc.php";
include "include/mrbs_sql.inc.php";
$grr_script_name = "contactFormulaire.php";
// Settings
require_once("./include/settings.inc.php");
//Chargement des valeurs de la table settingS
if (!loadSettings())
    die("Erreur chargement settings");

// Session related functions
require_once("./include/session.inc.php");
// Param�tres langage
include "include/language.inc.php";



echo "<link href=\"themes/default/css/styles.css\" rel=\"stylesheet\" type=\"text/css\">";

//DAVID VOUE 04/02/2014 -- Cr�ation du formulaire contactreservation pour que les visiteurs puissent remplir ce formulaire pour r�server une
//salle de sport.
# Affichage de header


echo "<form class='contactreservation' id=\"contactreservation\" name=\"contactreservation\" action=''>";

//DAVID VOUE 04/02/2014 -- Premier fieldset qui contient les coordonn�es des visiteurs
//(nom, pr�nom, email, t�l�phone).
//On v�rifie le champ nom et pr�nom sont bien remplis.
//L'email doit bien �tre valide
//Enfin le t�l�phone doit contenir uniquement des chiffres (10)

echo " <fieldset><legend><b>Vos coordonn�es</b></legend>";
echo "<br />";
echo " <label for=\"nom\"> &nbsp ".get_vocab("nomR")." &nbsp : &nbsp </label><input type=\"text\" id=\"nom\"  size=\"8\"name=\"nom\">";

echo " <label for=\"prenom\"> &nbsp Prenom &nbsp : &nbsp &nbsp</label><input  type=\"text\" size=\"8\" id=\"prenom\"  name=\"prenom\">";
echo " <br /><br />";
echo "<label for=\"email\">&nbsp Email &nbsp : &nbsp</label><input type=\"text\" id=\"email\" size=\"8\" name=\"email\" />";

echo "<label for=\"telephone\"> T�l�phone :  &nbsp</label><input type=\"text\" size=\"8\" maxlength=\"14\" id=\"telephone\" name=\"telephone\"  /><br/><br/>";

echo "</fieldset>";

echo "<br />";

//DAVID VOUE 04/02/2014-- Deuxi�me Fielset con�ernant la r�servation (Sujet, Domaines, Ressources)

echo "<fieldset><legend><b>R�servation</b></legend>";

echo "  <label for=\"subject\">Sujet :</label><br/>";
echo "<br />";
echo " <textarea id=\"subject\" name=\"sujet\" cols=\"30\" rows=\"4\"></textarea><br/>";

echo "<br />";

echo "  <label for=\"domaine\">Domaines : </label>";

echo " <select id=\"area\" name=\"area\">";
//David VOUE 10/01/2014 -- Ajout d'une balise optgroup
echo "<optgroup label=\"Domaines\">";

$sql_areaName = "select id,area_name FROM ".TABLE_PREFIX."_area order by area_name";
$res_areaName = grr_sql_query($sql_areaName); 
for ($i = 0; ($row_areaName = grr_sql_row($res_areaName, $i)); $i++)
{
	$id = $row_areaName[0];
	$area_name = $row_areaName[1];
	echo "<option onclick=\"\" value=\"$id\"> $area_name</option>";
}




echo "</select>";

?>

<script src="jquery-1.8.3.js"></script>

<script>
$(document).ready(function() {
    var $domaine = $('#area'); // encien region 
    var $salle = $('#room'); // encien departement 
 
    // � la s�lection d une r�gion dans la liste
    $domaine.on('change', function() {
        var id = $(this).attr("value"); // on r�cup�re la valeur de la r�gion
			if (id != '') {
            $salle.empty(); // on vide la liste des d�partements
             
             jQuery.ajax({
							type: 'GET', // pour recevoir du contenu html on utilise GET. 
							url: 'frmcontactlist.php', // On utilise un fichier php pour r�afficher 
							data: { 							// les fichiers li�s. 
									 id: id // On transmet l'ID pour pouvoir faire notre req�te sql. 
								},
									success: function(returnData){
							$("#room").html(returnData); // On r�affiche nos fichiers li� dans la view_entry 
							},							// Le fichier supprim� a donc dispar�t de l'affichage 
							error: function(returnData){
							alert('Erreur lors de l execution de la commande AJAX  ');
							}  
          });
        }
    });
});

</script>

<?






echo " <label for=\"ressource\">Ressources : </label>";
echo " <select id=\"room\" name=\"room\">"; 
//David VOUE 10/01/2014 -- Ajout d'une balise optgroup
echo "<optgroup label=\"Salles\">";

echo " <option > SELECTIONNER UN DOMAINE </option>";

echo "</select>";
echo "<br /><br />";
echo "<fieldset><legend><b> D�but de la r�servaton</b></legend>";
echo "<br />";

jQuery_DatePicker('start');

echo "&nbsp";
echo " <select name=\"heure\"> ";
for ($h =1 ; $h <24 ; $h++ )
{
	echo "<option value =\"$h\"> ".sprintf("%02d",$h)."h </option>";
}
echo "</select>";
echo " <select name=\"minutes\"> ";      
for ($m =00 ; $m <60 ; $m = $m+30 )
{
	echo "<option value =\"$m\"> ".sprintf("%02d",$m)."min </option>";
}
echo "</select>";
echo "&nbsp &nbsp";
echo "<br><br>";
echo " <label for=\"duree\">Dur�e :   </label><input type=\"text\" id=\"duree\" name=\"duree\" size=\"2\" maxlength=\"2\" tabindex=\"5\" />";    
echo "&nbsp";
echo "<select name=\"typeDuree\">";
//David VOUE 03/02/2014 -- Les citoyens peuvent r�server seulement des heures  
$units = array("heures");
for ($s=0;$s < sizeof($units); $s++)
{
	echo "<option value=\"$units[$s]\">$units[$s] </option>";
}
echo "</select>\n";
echo "</fieldset><br/>";  
echo "<div id=\"planning\" style=\"margin-left:0px;\"\>";
echo "<div id=\"buttonsReservation\" style=\"margin-left:0px;\"\>";
echo " <input  type=\"submit\" name=\"submit\" value=\"Envoyer la demande de r�servation\" />";
echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
echo " <input  type=\"reset\" name=\"cancel\" value=\"Annuler\" />";
echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp "; 
// David VOUE 03/02/2014 -- Cr�ation bouton Retour � l'accueil
echo "<a href='javascript:history.go(-1)'><input type=\"button\" name=\"retouraccueil\" value=\"Retour � l'accueil\" /></a>"; 
echo "</div>";
echo " </div>";
echo " </form>";
?>

<!--David VOUE 11/02/2014 -- Script qui permet de contr�ler certains champs du formulaire comme le nom ou le pr�nom par exemple
-->

<script src="jquery.validate.js"></script>
<script >
jQuery.validator.setDefaults({
debug: true,
success: "valid",
onsubmit: true
});
$(" #contactreservation").validate({
rules: {
nom: {
required: true
},
prenom: {
required: true
},
email: {
required: true,
email: true
},
telephone: {
required: true,
digits: true
},
duree: {
required: true,
digits: true
}
}
});
</script>
