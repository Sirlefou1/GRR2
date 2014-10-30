<?php
/**
 * admin_config1.php
 * Interface permettant à l'administrateur la configuration de certains paramètres généraux
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-04-07 17:49:56 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config1.php,v 1.14 2010-04-07 17:49:56 grr Exp $
 * @filesource
 *
 * This file is part of GRR.
 *
 * GRR is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GRR is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GRR; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
if (isset($_POST['title_home_page']))
{
	if (!saveSetting("title_home_page", $_POST['title_home_page']))
	{
		echo "Erreur lors de l'enregistrement de title_home_page !<br />";
		die();
	}
}
if (isset($_POST['show_holidays']))
{
	if (!saveSetting("show_holidays", $_POST['show_holidays']))
	{
		echo "Erreur lors de l'enregistrement de show_holidays !<br />";
		die();
	}
}
if (isset($_POST['holidays_zone']))
{
	if (!saveSetting("holidays_zone", $_POST['holidays_zone']))
	{
		echo "Erreur lors de l'enregistrement de holidays_zone !<br />";
		die();
	}
}
if (isset($_POST['message_home_page']))
{
	if (!saveSetting("message_home_page", $_POST['message_home_page']))
	{
		echo "Erreur lors de l'enregistrement de message_home_page !<br />";
		die();
	}
}
if (isset($_POST['company']))
{
	if (!saveSetting("company", $_POST['company']))
	{
		echo "Erreur lors de l'enregistrement de company !<br />";
		die();
	}
}
if (isset($_POST['webmaster_name']))
{
	if (!saveSetting("webmaster_name", $_POST['webmaster_name']))
	{
		echo "Erreur lors de l'enregistrement de webmaster_name !<br />";
		die();
	}
}
if (isset($_POST['webmaster_email']))
{
	if (!saveSetting("webmaster_email", $_POST['webmaster_email']))
	{
		echo "Erreur lors de l'enregistrement de webmaster_email !<br />";
		die();
	}
}
if (isset($_POST['technical_support_email']))
{
	if (!saveSetting("technical_support_email", $_POST['technical_support_email']))
	{
		echo "Erreur lors de l'enregistrement de technical_support_email !<br />";
		die();
	}
}
if (isset($_POST['message_accueil']))
{
	if (!saveSetting("message_accueil", $_POST['message_accueil']))
	{
		echo "Erreur lors de l'enregistrement de message_accueil !<br />";
		die();
	}
}
if (isset($_POST['grr_url']))
{
	if (!saveSetting("grr_url", $_POST['grr_url']))
	{
		echo "Erreur lors de l'enregistrement de grr_url !<br />";
		die();
	}
}
if (isset($_POST["ok"]))
{
	if (isset($_POST['use_grr_url']))
		$use_grr_url = "y";
	else
		$use_grr_url = "n";
	if (!saveSetting("use_grr_url", $use_grr_url))
	{
		echo "Erreur lors de l'enregistrement de use_grr_url !<br />";
		die();
	}
}
// Style/thème
if (isset($_POST['default_css']))
{
	if (!saveSetting("default_css", $_POST['default_css']))
	{
		echo "Erreur lors de l'enregistrement de default_css !<br />";
		die();
	}
}
// langage
if (isset($_POST['default_language']))
{
	if (!saveSetting("default_language", $_POST['default_language']))
	{
		echo "Erreur lors de l'enregistrement de default_language !<br />";
		die();
	}
	unset ($_SESSION['default_language']);
}
// Type d'affichage des listes des domaines et des ressources
if (isset($_POST['area_list_format']))
{
	if (!saveSetting("area_list_format", $_POST['area_list_format']))
	{
		echo "Erreur lors de l'enregistrement de area_list_format !<br />";
		die();
	}
}
// site par défaut
if (isset($_POST['id_site']))
{
	if (!saveSetting("default_site", $_POST['id_site']))
	{
		echo "Erreur lors de l'enregistrement de default_site !<br />";
		die();
	}
}
// domaine par défaut
if (isset($_POST['id_area']))
{
	if (!saveSetting("default_area", $_POST['id_area']))
	{
		echo "Erreur lors de l'enregistrement de default_area !<br />";
		die();
	}
}
if (isset($_POST['id_room']))
{
	if (!saveSetting("default_room", $_POST['id_room']))
	{
		echo "Erreur lors de l'enregistrement de default_room !<br />";
		die();
	}
}
// Affichage de l'adresse email
if (isset($_POST['display_level_email']))
{
	if (!saveSetting("display_level_email", $_POST['display_level_email']))
	{
		echo "Erreur lors de l'enregistrement de display_level_email !<br />";
		die();
	}
}
/*-----MAJ Loïs THOMAS  --> Affichage de la page view_entry pour les réservations  -----*/
if (isset($_POST['display_level_view_entry']))
{
	if (!saveSetting("display_level_view_entry", $_POST['display_level_view_entry']))
	{
		echo "Erreur lors de l'enregistrement de display_level_view_entry !<br />";
		die();
	}
}
// display_info_bulle
if (isset($_POST['display_info_bulle']))
{
	if (!saveSetting("display_info_bulle", $_POST['display_info_bulle']))
	{
		echo "Erreur lors de l'enregistrement de display_info_bulle !<br />";
		die();
	}
}
// menu_gauche
if (isset($_POST['menu_gauche']))
{
	if (!saveSetting("menu_gauche", $_POST['menu_gauche']))
	{
		echo "Erreur lors de l'enregistrement de menu_gauche !<br />";
		die();
	}
}
// display_full_description
if (isset($_POST['display_full_description']))
{
	if (!saveSetting("display_full_description", $_POST['display_full_description']))
	{
		echo "Erreur lors de l'enregistrement de display_full_description !<br />";
		die();
	}
}
// display_short_description
if (isset($_POST['display_short_description']))
{
	if (!saveSetting("display_short_description", $_POST['display_short_description']))
	{
		echo "Erreur lors de l'enregistrement de display_short_description !<br />";
		die();
	}
}
// remplissage de la description brève
if (isset($_POST['remplissage_description_breve']))
{
	if (!saveSetting("remplissage_description_breve", $_POST['remplissage_description_breve']))
	{
		echo "Erreur lors de l'enregistrement de remplissage_description_breve !<br />";
		die();
	}
}
// pview_new_windows
if (isset($_POST['pview_new_windows']))
{
	if (!saveSetting("pview_new_windows", $_POST['pview_new_windows']))
	{
		echo "Erreur lors de l'enregistrement de pview_new_windows !<br />";
		die();
	}
}
/*-----MAJ Loïs THOMAS  -->Affichage ou non de la legende -----*/
if (isset($_POST['legend']))
{
	if (!saveSetting("legend", $_POST['legend']))
	{
		echo "Erreur lors de l'enregistrement de legend !<br />";
		die();
	}
}
/*-----MAJ David VOUE 22/01/2014-->Affichage ou non du formulaire de contact et adresse mail du destinataire -----*/
if (isset($_POST['mail_destinataire']))
{
	if (!saveSetting("mail_destinataire", $_POST['mail_destinataire']))
	{
		echo "Erreur lors de l'enregistrement de mail_destinataire !<br />";
		die();
	}
}
if (isset($_POST['mail_etat_destinataire']))
{
	if (!saveSetting("mail_etat_destinataire", $_POST['mail_etat_destinataire']))
	{
		echo "Erreur lors de l'enregistrement de mail_etat_destinataire !<br />";
		die();
	}
}
// gestion_lien_aide
if (isset($_POST['gestion_lien_aide']))
{
	if (($_POST['gestion_lien_aide'] == "perso") && (trim($_POST['lien_aide']) == ""))
		$_POST['gestion_lien_aide'] = "ext";
	else if ($_POST['gestion_lien_aide'] != "perso")
		$_POST['lien_aide']="";
	if (!saveSetting("lien_aide", $_POST['lien_aide']))
	{
		echo "Erreur lors de l'enregistrement de lien_aide !<br />";
		die();
	}
	if (!saveSetting("gestion_lien_aide", $_POST['gestion_lien_aide']))
	{
		echo "Erreur lors de l'enregistrement de gestion_lien_aide !<br />";
		die();
	}
}
# Lors de l'édition d'un rapport, valeur par défaut en nombre de jours
# de l'intervalle de temps entre la date de début du rapport et la date de fin du rapport.
if (isset($_POST['default_report_days']))
{
	settype($_POST['default_report_days'],"integer");
	if ($_POST['default_report_days'] <= 0)
		$_POST['default_report_days'] = 0;
	if (!saveSetting("default_report_days", $_POST['default_report_days']))
	{
		echo "Erreur lors de l'enregistrement de default_report_days !<br />";
		die();
	}
}
if (isset($_POST['longueur_liste_ressources_max']))
{
	settype($_POST['longueur_liste_ressources_max'],"integer");
	if ($_POST['longueur_liste_ressources_max'] <= 0)
		$_POST['longueur_liste_ressources_max'] = 1;
	if (!saveSetting("longueur_liste_ressources_max", $_POST['longueur_liste_ressources_max']))
	{
		echo "Erreur lors de l'enregistrement de longueur_liste_ressources_max !<br />";
		die();
	}
}
$msg = '';
if (isset($_POST["ok"]))
{
  // Suppression du logo
	if (isset($_POST['sup_img']))
	{
		$dest = './images/';
		$ok1 = false;
		if ($f = @fopen("$dest/.test", "w"))
		{
			@fputs($f, '<'.'?php $ok1 = true; ?'.'>');
			@fclose($f);
			include("$dest/.test");
		}
		if (!$ok1)
		{
			$msg .= "L\'image n\'a pas pu être supprimée : problème d\'écriture sur le répertoire. Veuillez signaler ce problème à l\'administrateur du serveur.\\n";
			$ok = 'no';
		}
		else
		{
			$nom_picture = "./images/".getSettingValue("logo");
			if (@file_exists($nom_picture))
				unlink($nom_picture);
			if (!saveSetting("logo", ""))
			{
				$msg .= "Erreur lors de l'enregistrement du logo !\\n";
				$ok = 'no';
			}
		}
	}
  	// Enregistrement du logo
	$doc_file = isset($_FILES["doc_file"]) ? $_FILES["doc_file"] : NULL;
	if (preg_match("`\.([^.]+)$`", $doc_file['name'], $match))
	{
		$ext = strtolower($match[1]);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif')
		{
			$msg .= "L\'image n\'a pas pu être enregistrée : les seules extentions autorisées sont gif, png et jpg.\\n";
			$ok = 'no';
		}
		else
		{
			$dest = './images/';
			$ok1 = false;
			if ($f = @fopen("$dest/.test", "w"))
			{
				@fputs($f, '<'.'?php $ok1 = true; ?'.'>');
				@fclose($f);
				include("$dest/.test");
			}
			if (!$ok1)
			{
				$msg .= "L\'image n\'a pas pu être enregistrée : problème d\'écriture sur le répertoire \"images\". Veuillez signaler ce problème à l\'administrateur du serveur.\\n";
				$ok = 'no';
			}
			else
			{
				$ok1 = @copy($doc_file['tmp_name'], $dest.$doc_file['name']);
				if (!$ok1)
					$ok1 = @move_uploaded_file($doc_file['tmp_name'], $dest.$doc_file['name']);
				if (!$ok1)
				{
					$msg .= "L\'image n\'a pas pu être enregistrée : problème de transfert. Le fichier n\'a pas pu être transféré sur le répertoire IMAGES. Veuillez signaler ce problème à l\'administrateur du serveur.\\n";
					$ok = 'no';
				}
				else
				{
					$tab = explode(".", $doc_file['name']);
					$ext = strtolower($tab[1]);
					if ($dest.$doc_file['name']!=$dest."logo.".$ext)
					{
						if (@file_exists($dest."logo.".$ext))
							@unlink($dest."logo.".$ext);
						rename($dest.$doc_file['name'],$dest."logo.".$ext);
					}
					@chmod($dest."logo.".$ext, 0666);
					$picture_room = "logo.".$ext;
					if (!saveSetting("logo", $picture_room))
					{
						$msg .= "Erreur lors de l'enregistrement du logo !\\n";
						$ok = 'no';
					}
				}
			}
		}
	}
	else if ($doc_file['name'] != '')
	{
		$msg .= "L\'image n\'a pas pu être enregistrée : le fichier image sélectionné n'est pas valide !\\n";
		$ok = 'no';
	}
}
// nombre de calendriers
if (isset($_POST['nb_calendar']))
{
	settype($_POST['nb_calendar'],"integer");
	if (!saveSetting("nb_calendar", $_POST['nb_calendar']))
	{
		echo "Erreur lors de l'enregistrement de nb_calendar !<br />";
		die();
	}
}
$demande_confirmation = 'no';
if (isset($_POST['begin_day']) && isset($_POST['begin_month']) && isset($_POST['begin_year']))
{
	while (!checkdate($_POST['begin_month'], $_POST['begin_day'], $_POST['begin_year']))
		$_POST['begin_day']--;
	$begin_bookings = mktime(0, 0, 0, $_POST['begin_month'], $_POST['begin_day'], $_POST['begin_year']);
	$test_del1 = mysqli_num_rows(mysqli_query($GLOBALS['db_c'], "SELECT * FROM ".TABLE_PREFIX."_entry WHERE (end_time < '$begin_bookings' )"));
	$test_del2 = mysqli_num_rows(mysqli_query($GLOBALS['db_c'], "SELECT * FROM ".TABLE_PREFIX."_repeat WHERE (end_date < '$begin_bookings')"));
	if (($test_del1 != 0) || ($test_del2 != 0))
		$demande_confirmation = 'yes';
	else
	{
		if (!saveSetting("begin_bookings", $begin_bookings))
			echo "Erreur lors de l'enregistrement de begin_bookings !<br />";
	}

	if (isset($_POST['end_day']) && isset($_POST['end_month']) && isset($_POST['end_year']))
	{
		while (!checkdate($_POST['end_month'], $_POST['end_day'], $_POST['end_year']))
			$_POST['end_day']--;
		$end_bookings = mktime(0, 0, 0, $_POST['end_month'], $_POST['end_day'] ,$_POST['end_year']);
		if ($end_bookings < $begin_bookings)
			$end_bookings = $begin_bookings;
		$test_del1 = mysqli_num_rows(mysqli_query($GLOBALS['db_c'], "SELECT * FROM ".TABLE_PREFIX."_entry WHERE (start_time > '$end_bookings' )"));
		$test_del2 = mysqli_num_rows(mysqli_query($GLOBALS['db_c'], "SELECT * FROM ".TABLE_PREFIX."_repeat WHERE (start_time > '$end_bookings')"));
		if (($test_del1 != 0) || ($test_del2 != 0))
			$demande_confirmation = 'yes';
		else
		{
			if (!saveSetting("end_bookings", $end_bookings))
				echo "Erreur lors de l'enregistrement de end_bookings !<br />";
		}
	}

	if ($demande_confirmation == 'yes')
	{
		header("Location: ./admin_confirm_change_date_bookings.php?end_bookings=$end_bookings&begin_bookings=$begin_bookings");
		die();
	}
}
if (!loadSettings())
	die("Erreur chargement settings");
// Si pas de problème, message de confirmation
if (isset($_POST['ok']))
{
	$_SESSION['displ_msg'] = 'yes';
	if ($msg == '')
		$msg = get_vocab("message_records");
	Header("Location: "."admin_config.php?msg=".$msg);
	exit();
}
if ((isset($_GET['msg'])) && isset($_SESSION['displ_msg']) && ($_SESSION['displ_msg'] == 'yes'))
	$msg = $_GET['msg'];
else
	$msg = '';
// Utilisation de la bibliothèqye prototype dans ce script
$use_prototype = 'y';
# print the page header
print_header("", "", "", $type="with_session");
affiche_pop_up($msg,"admin");
// Affichage de la colonne de gauche
include "admin_col_gauche.php";
// Affichage du tableau de choix des sous-configuration
include "include/admin_config_tableau.inc.php";
//echo "<h2>".get_vocab('admin_config1.php')."</h2>";
//echo "<p>".get_vocab('mess_avertissement_config')."</p>";
// Adapter les fichiers de langue
echo "<h3>".get_vocab("adapter fichiers langue")."</h3>\n";
echo get_vocab("adapter fichiers langue explain");
//
// Config générale
//****************
//
echo "<form enctype=\"multipart/form-data\" action=\"./admin_config.php\" id=\"nom_formulaire\" method=\"post\" action=\"#\" style=\"width: 100%;\">";
echo "<h3>".get_vocab("miscellaneous")."</h3>\n";
?>
<table border='0'>
	<tr>
		<td>
			<?php echo get_vocab("title_home_page"); ?>
		</td>
		<td>
			<input type="text" name="title_home_page" id="title_home_page" size="40" value="<?php echo(getSettingValue("title_home_page")); ?>" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo get_vocab("message_home_page"); ?>
		</td>
		<td>
			<textarea name="message_home_page" rows="3" cols="40"><?php echo(getSettingValue("message_home_page")); ?>
			</textarea>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo get_vocab("company"); ?>
		</td>
		<td>
			<input type="text" name="company" size="40" value="<?php echo(getSettingValue("company")); ?>" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo get_vocab("grr_url"); ?>
		</td>
		<td>
			<input type="text" name="grr_url" size="40" value="<?php echo(getSettingValue("grr_url")); ?>" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="checkbox" name="use_grr_url" value="y" <?php if (getSettingValue("use_grr_url") == 'y') echo " checked=\"checked\" "; ?> />
			<i><?php echo get_vocab("grr_url_explain"); ?></i>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo get_vocab("webmaster_name"); ?>
		</td>
		<td>
			<input type="text" name="webmaster_name" size="40" value="<?php echo(getSettingValue("webmaster_name")); ?>" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo get_vocab("webmaster_email")."<br /><i>".get_vocab("plusieurs_adresses_separees_points_virgules")."</i>"; ?>
		</td>
		<td>
			<input type="text" id="webmaster_email" name="webmaster_email" size="40" value="<?php echo(getSettingValue("webmaster_email")); ?>" />
		</td>
	</tr>
	<tr>
		<td>
			<?php echo get_vocab("technical_support_email")."<br /><i>".get_vocab("plusieurs_adresses_separees_points_virgules")."</i>"; ?>
		</td>
		<td>
			<input type="text" id="technical_support_email" name="technical_support_email" size="40" value="<?php echo(getSettingValue("technical_support_email")); ?>" />
		</td>
	</tr>
</table>
<?php
echo "<h3>".get_vocab("logo_msg")."</h3>\n";
echo "<table><tr><td>".get_vocab("choisir_image_logo")."</td>
<td><input type=\"file\" name=\"doc_file\" size=\"30\" /></td></tr>\n";
$nom_picture = "./images/".getSettingValue("logo");
if ((getSettingValue("logo") != '') && (@file_exists($nom_picture)))
{
	echo "<tr><td>".get_vocab("supprimer_logo").get_vocab("deux_points");
	echo "<img src=\"".$nom_picture."\" class=\"image\" alt=\"logo\" title=\"".$nom_picture."\"/>\n";
	echo "</td><td><input type=\"checkbox\" name=\"sup_img\" /></td></tr>";
}
echo "</table>";
echo "<h3>".get_vocab("affichage_calendriers")."</h3>\n";
echo "<p>".get_vocab("affichage_calendriers_msg").get_vocab("deux_points");
echo "<select name=\"nb_calendar\" >\n";
for ($k = 0; $k < 6; $k++)
{
	echo "<option value=\"".$k."\" ";
	if (getSettingValue("nb_calendar") == $k)
		echo " selected=\"selected\" ";
	echo ">".$k."</option>\n";
}
echo "</select></p>";
if (getSettingValue("use_fckeditor") == 1)
	echo "<script type=\"text/javascript\" src=\"js/ckeditor/ckeditor.js\"></script>\n";
echo "<h3>".get_vocab("message perso")."</h3>\n";
echo "<p>".get_vocab("message perso explain");
if (getSettingValue("use_fckeditor") != 1)
	echo " ".get_vocab("description complete2");
if (getSettingValue("use_fckeditor") == 1)
{
	echo "<textarea class=\"ckeditor\" id=\"editor1\" name=\"message_accueil\" rows=\"8\" cols=\"120\">\n";
	echo htmlspecialchars(getSettingValue('message_accueil'));
	echo "</textarea>\n";
	?>
	<script type="text/javascript">
		//<![CDATA[
		CKEDITOR.replace( 'editor1',
		{
			toolbar :
			[
			['Source'],
			['Cut','Copy','Paste','PasteText','PasteFromWord', 'SpellChecker', 'Scayt'],
			['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
			['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
			['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
			['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
			['Link','Unlink','Anchor'],
			['Image','Table','HorizontalRule','SpecialChar','PageBreak'],
			]
		});
		//]]>
	</script>
	<?php
}
else
	echo "\n<textarea name=\"message_accueil\" rows=\"8\" cols=\"120\">".htmlspecialchars(getSettingValue('message_accueil'))."</textarea>\n";
echo "</p>";
//
// Début et fin des réservations
//******************************
//
echo "<hr /><h3>".get_vocab("title_begin_end_bookings")."</h3>\n";
?>
<table border='0'>
	<tr>
		<td>
			<?php echo get_vocab("begin_bookings"); ?>
		</td>
		<td>
			<?php
			$bday = strftime("%d", getSettingValue("begin_bookings"));
			$bmonth = strftime("%m", getSettingValue("begin_bookings"));
			$byear = strftime("%Y", getSettingValue("begin_bookings"));
			genDateSelector("begin_", $bday, $bmonth, $byear,"more_years") ?>
		</td>
		<td> </td>
	</tr>
</table>
<?php echo "<p><i>".get_vocab("begin_bookings_explain")."</i>"; ?>
<br /><br />
</p>
<table border='0'>
	<tr
	><td>
	<?php echo get_vocab("end_bookings"); ?>
</td>
<td>
	<?php
	$eday = strftime("%d", getSettingValue("end_bookings"));
	$emonth = strftime("%m", getSettingValue("end_bookings"));
	$eyear= strftime("%Y", getSettingValue("end_bookings"));
	genDateSelector("end_",$eday,$emonth,$eyear,"more_years") ?>
</td>
</tr>
</table>
<?php echo "<p><i>".get_vocab("end_bookings_explain")."</i></p>";
//
// Configuration de l'affichage par défaut
//****************************************
//
?>
<hr />
<?php echo "<h3>".get_vocab("default_parameter_values_title")."</h3>\n";
echo "<p>".get_vocab("explain_default_parameter")."</p>";
//
// Choix du type d'affichage
//
echo "<h4>".get_vocab("explain_area_list_format")."</h4>";
echo "<table><tr><td>".get_vocab("liste_area_list_format")."</td><td>";
echo "<input type='radio' name='area_list_format' value='list' ";
if (getSettingValue("area_list_format") == 'list')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("select_area_list_format")."</td><td>";
echo "<input type='radio' name='area_list_format' value='select' ";
if (getSettingValue("area_list_format") == 'select')
	echo "checked=\"checked\"";
echo " />";
echo "<tr><td>".get_vocab("item_area_list_format")."</td><td>";
echo "<input type='radio' name='area_list_format' value='item' ";
if (getSettingValue("area_list_format") == 'item')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</td></tr></table>";
//
// Choix du domaine et de la ressource
// http://www.phpinfo.net/articles/article_listes.html
//
if (getSettingValue("module_multisite") == "Oui")
	$use_site='y';
else
	$use_site='n';
?>
<script type="text/javascript">
	function modifier_liste_domaines(){
		new Ajax.Updater($('div_liste_domaines'),"my_account_modif_listes.php",{method: 'get', parameters: $('id_site').serialize(true)+'&'+'default_area=<?php echo getSettingValue("default_area"); ?>'+'&'+'session_login=<?php echo getUserName(); ?>'+'&'+'use_site=<?php echo $use_site; ?>'+'&'+'type=domaine'});
	}
	function modifier_liste_ressources(action){
		new Ajax.Updater($('div_liste_ressources'),"my_account_modif_listes.php",{method: 'get', parameters: $('id_area').serialize(true)+'&'+'default_room=<?php echo getSettingValue("default_room"); ?>'+'&'+'type=ressource'+'&'+'action='+action});
	}
</script>
<?php
if (getSettingValue("module_multisite") == "Oui")
	echo ('<h4>'.get_vocab('explain_default_area_and_room_and_site').'</h4>');
else
	echo ('<h4>'.get_vocab('explain_default_area_and_room').'</h4>');
/**
 * Liste des sites
 */
if (getSettingValue("module_multisite") == "Oui")
{
	$sql = "SELECT id,sitecode,sitename
	FROM ".TABLE_PREFIX."_site
	ORDER BY id ASC";
	$resultat = grr_sql_query($sql);
	echo('
		<table>
			<tr>
				<td>'.get_vocab('default_site').get_vocab('deux_points').'</td>
				<td>
					<select id="id_site" name="id_site" onchange="modifier_liste_domaines();modifier_liste_ressources(2)">
						<option value="-1">'.get_vocab('choose_a_site').'</option>'."\n");
	for ($enr = 0; ($row = grr_sql_row($resultat, $enr)); $enr++)
	{
		echo '<option value="'.$row[0].'"';
		if (getSettingValue("default_site") == $row[0])
			echo ' selected="selected" ';
		echo '>'.htmlspecialchars($row[2]);
		echo '</option>'."\n";
	}
	echo('</select>
</td>
</tr>');
}
else
{
	echo '<input type="hidden" id="id_site" name="id_site" value="-1" />
	<table>';
	}
/**
  * Liste des domaines
 */
echo '<tr><td colspan="2">';
echo '<div id="div_liste_domaines">';
// Ici, on insère la liste des domaines avec de l'ajax !
echo '</div></td></tr>';
/**
 * Liste des ressources
 */
echo '<tr><td colspan="2">';
echo '<div id="div_liste_ressources">';
echo '<input type="hidden" id="id_area" name="id_area" value="'.getSettingValue("default_area").'" />';
// Ici, on insère la liste des ressouces avec de l'ajax !
echo '</div></td></tr></table>';
// Au chargement de la page, on remplit les listes de domaine et de ressources
echo '<script type="text/javascript">modifier_liste_domaines();</script>'."\n";
echo '<script type="text/javascript">modifier_liste_ressources(1);</script>'."\n";
//
// Choix de la feuille de style
//
echo "<h4>".get_vocab("explain_css")."</h4>";
echo "<table><tr><td>".get_vocab("choose_css")."</td><td>";
echo "<select name='default_css'>\n";
$i = 0;
while ($i < count($liste_themes))
{
	echo "<option value='".$liste_themes[$i]."'";
	if (getSettingValue("default_css") == $liste_themes[$i])
		echo " selected=\"selected\"";
	echo " >".encode_message_utf8($liste_name_themes[$i])."</option>";
	$i++;
}
echo "</select></td></tr></table>\n";
//
// Choix de la langue
//
echo "<h4>".get_vocab("choose_language")."</h4>";
echo "<table><tr><td>".get_vocab("choose_css")."</td><td>";
echo "<select name='default_language'>\n";
$i = 0;
while ($i < count($liste_language))
{
	echo "<option value='".$liste_language[$i]."'";
	if (getSettingValue("default_language") == $liste_language[$i])
		echo " selected=\"selected\"";
	echo " >".encode_message_utf8($liste_name_language[$i])."</option>\n";
	$i++;
}
echo "</select></td></tr></table>\n";
#
# Affichage du contenu des "info-bulles" des réservations, dans les vues journées, semaine et mois.
# display_info_bulle = 0 : pas d'info-bulle.
# display_info_bulle = 1 : affichage des noms et prénoms du bénéficiaire de la réservation.
# display_info_bulle = 2 : affichage de la description complète de la réservation.
echo "<hr /><h3>".get_vocab("display_info_bulle_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("info-bulle0")."</td><td>";
echo "<input type='radio' name='display_info_bulle' value='0' ";
if (getSettingValue("display_info_bulle") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("info-bulle1")."</td><td>";
echo "<input type='radio' name='display_info_bulle' value='1' ";
if (getSettingValue("display_info_bulle") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("info-bulle2")."</td><td>";
echo "<input type='radio' name='display_info_bulle' value='2' ";
if (getSettingValue("display_info_bulle") == '2')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
#MAJ Hugo FORESTIER - Choix  de l'affichage du bouton "afficher le menu de gauche ou non"
#SQL : menu_gauche==1  //le bouton s'affiche par default
# menu_gauche==0 //le bouton ne s'affiche pas par default
#Test pour savoir la valeur présente dans la base de données : echo getSettingValue("menu_gauche");
echo "<hr /><h3>".get_vocab("display_menu")."</h3>\n";
echo "<p>".get_vocab("display_menu_1")."</p>";
echo "<table>";
echo "<tr><td>".get_vocab("display_menu_2")."</td><td>";
echo "<input type='radio' name='menu_gauche' value='0' ";
if (getSettingValue("menu_gauche") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("display_menu_3")."</td><td>";
echo "<input type='radio' name='menu_gauche' value='1' ";
if (getSettingValue("menu_gauche") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
#mail_destinataire = 0 //Le formulaire de contact est désactivé (0 par défaut)
#mail_destinataire = 1 //Le formulaire de contact est activé
echo "<hr /><h3>".get_vocab("display_mail_etat_destinataire")."</h3>\n";
echo "<p>".get_vocab("display_mail_etat_destinataire_1")."</p>";
echo "<table>";
echo "<tr><td>".get_vocab("display_mail_etat_destinataire_2")."</td><td>";
echo "<input type='radio' id='mail_etat_destinataire' name='mail_etat_destinataire' value='0' ";
if (getSettingValue("mail_etat_destinataire") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("display_mail_etat_destinataire_3")."</td><td>";
echo "<input type='radio' id='mail_etat_destinataire' name='mail_etat_destinataire' value='1'";
if (getSettingValue("mail_etat_destinataire") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
//echo "<td><tr></td></tr>";
echo "<tr><td>".get_vocab("display_mail_destinataire")."</td><td>";
echo "</tr>";
echo "<tr><td><input type=\"text\" id=\"mail_destinataire\" name=\"mail_destinataire\" value=\"".getSettingValue("mail_destinataire")."\" size=\"30\">\n";
echo "</td>";
echo "</tr>";
echo "</table>";
//echo "<input type=\"text\" name=\"lien_aide\" value=\"".getSettingValue("lien_aide")."\" size=\"40\" />\n";
//echo "</td></tr>\n";
# Afficher la description complète de la réservation dans les vues semaine et mois.
# display_full_description=1 : la description complète s'affiche.
# display_full_description=0 : la description complète ne s'affiche pas.
echo "<hr /><h3>".get_vocab("display_full_description_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("display_full_description0")."</td><td>";
echo "<input type='radio' name='display_full_description' value='0' ";
if (getSettingValue("display_full_description") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("display_full_description1")."</td><td>";
echo "<input type='radio' name='display_full_description' value='1' ";
if (getSettingValue("display_full_description") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
# Afficher la description courte de la réservation dans les vues semaine et mois.
# display_short_description=1 : la description  s'affiche.
# display_short_description=0 : la description  ne s'affiche pas.
echo "<hr /><h3>".get_vocab("display_short_description_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("display_short_description0")."</td><td>";
echo "<input type='radio' name='display_short_description' value='0' ";
if (getSettingValue("display_short_description") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("display_short_description1")."</td><td>";
echo "<input type='radio' name='display_short_description' value='1' ";
if (getSettingValue("display_short_description") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
###########################################################
# Affichage des  adresses email dans la fiche de réservation
###########################################################
# Qui peut voir les adresse email ?
# display_level_email  = 0 : N'importe qui allant sur le site, meme s'il n'est pas connecté
# display_level_email  = 1 : Il faut obligatoirement se connecter, même en simple visiteur.
# display_level_email  = 2 : Il faut obligatoirement se connecter et avoir le statut "utilisateur"
# display_level_email  = 3 : Il faut obligatoirement se connecter et être au moins gestionnaire d'une ressource
# display_level_email  = 4 : Il faut obligatoirement se connecter et être au moins administrateur du domaine
# display_level_email  = 5 : Il faut obligatoirement se connecter et être administrateur de site
# display_level_email  = 6 : Il faut obligatoirement se connecter et être administrateur général
echo "<hr /><h3>".get_vocab("display_level_email_msg1")."</h3>\n";
echo "<p>".get_vocab("display_level_email_msg2")."</p>";
echo "<table cellspacing=\"5\">";
echo "<tr><td>".get_vocab("visu_fiche_description0")."</td><td>";
echo "<input type='radio' name='display_level_email' value='0' ";
if (getSettingValue("display_level_email") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description1")."</td><td>";
echo "<input type='radio' name='display_level_email' value='1' ";
if (getSettingValue("display_level_email") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description2")."</td><td>";
echo "<input type='radio' name='display_level_email' value='2' ";
if (getSettingValue("display_level_email") == '2')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description3")."</td><td>";
echo "<input type='radio' name='display_level_email' value='3' ";
if (getSettingValue("display_level_email") == '3')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("visu_fiche_description4")."</td><td>";
echo "<input type='radio' name='display_level_email' value='4' ";
if (getSettingValue("display_level_email") == '4')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
if (getSettingValue("module_multisite") == "Oui")
{
	echo "<tr><td>".get_vocab("visu_fiche_description5")."</td><td>";
	echo "<input type='radio' name='display_level_email' value='5' ";
	if (getSettingValue("display_level_email") == '5')
		echo "checked=\"checked\"";
	echo " />";
	echo "</td></tr>";
}
echo "<tr><td>".get_vocab("visu_fiche_description6")."</td><td>";
echo "<input type='radio' name='display_level_email' value='6' ";
if (getSettingValue("display_level_email") == '6')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
#Affichage de view_entry sous forme de page ou de popup
echo "<hr /><h3>".get_vocab("display_level_view_entry")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("display_level_view_entry_0")."</td><td>";
echo "<input type='radio' name='display_level_view_entry' value='0' ";
if (getSettingValue("display_level_view_entry") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("display_level_view_entry_1")."</td><td>";
echo "<input type='radio' name='display_level_view_entry' value='1' ";
if (getSettingValue("display_level_view_entry") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo " </table>";
# Remplissage de la description courte
echo "<hr /><h3>".get_vocab("remplissage_description_breve_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("remplissage_description_breve0")."</td><td>";
echo "<input type='radio' name='remplissage_description_breve' value='0' ";
if (getSettingValue("remplissage_description_breve") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("remplissage_description_breve1")."</td><td>";
echo "<input type='radio' name='remplissage_description_breve' value='1' ";
if (getSettingValue("remplissage_description_breve") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("remplissage_description_breve2")."</td><td>";
echo "<input type='radio' name='remplissage_description_breve' value='2' ";
if (getSettingValue("remplissage_description_breve") == '2')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
# Ouvrir les pages au format imprimable dans une nouvelle fenêtre du navigateur (0 pour non et 1 pour oui)
echo "<hr /><h3>".get_vocab("pview_new_windows_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("pview_new_windows0")."</td><td>";
echo "<input type='radio' name='pview_new_windows' value='0' ";
if (getSettingValue("pview_new_windows") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("pview_new_windows1")."</td><td>";
echo "<input type='radio' name='pview_new_windows' value='1' ";
if (getSettingValue("pview_new_windows") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
# Afficher la legende en couleur dans le menu gauche
echo "<hr /><h3>".get_vocab("legend_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("legend0")."</td><td>";
echo "<input type='radio' name='legend' value='0' ";
if (getSettingValue("legend") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("legend1")."</td><td>";
echo "<input type='radio' name='legend' value='1' ";
if (getSettingValue("legend") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
# Afficher vacance et jour ferie
echo "<hr /><h3>".get_vocab("holidays_msg")."</h3>\n";
echo "<table>";
echo "<tr><td>".get_vocab("legend0")."</td><td>";
echo "<input type='radio' name='show_holidays' value='Oui' ";
if (getSettingValue("show_holidays") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "<tr><td>".get_vocab("legend1")."</td><td>";
echo "<input type='radio' name='show_holidays' value='Non' ";
if (getSettingValue("show_holidays") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>";
echo "</table>";
# Choix de la zone de vacance
echo "<hr /><h3>".get_vocab("holidays_zone_msg")."</h3>\n";
echo "<table>";
echo "<input type='text' name='holidays_zone' value='".getSettingValue("holidays_zone")."'/>";
echo "</td></tr>";
echo "</table>";
# Gestion du lien aide
echo "<hr /><h3>".get_vocab("Gestion lien aide bandeau superieur")."</h3>\n";
echo "<table>\n";
echo "<tr><td>".get_vocab("lien aide pointe vers documentation officielle site GRR")."</td><td>\n";
echo "<input type='radio' name='gestion_lien_aide' value='ext' ";
if (getSettingValue("gestion_lien_aide") == 'ext')
	echo "checked=\"checked\"";
echo " />";
echo "</td></tr>\n";
echo "<tr><td>".get_vocab("lien aide pointe vers adresse perso").get_vocab("deux_points")."</td><td>\n";
echo "<input type='radio' name='gestion_lien_aide' value='perso' ";
if (getSettingValue("gestion_lien_aide") == 'perso')
	echo "checked=\"checked\"";
echo " />\n";
echo "<input type=\"text\" name=\"lien_aide\" value=\"".getSettingValue("lien_aide")."\" size=\"40\" />\n";
echo "</td></tr>\n";
echo "</table>\n";
# Lors de l'édition d'un rapport, valeur par défaut en nombre de jours
# de l'intervalle de temps entre la date de début du rapport et la date de fin du rapport.
echo "<hr /><h3>".get_vocab("default_report_days_msg")."</h3>\n";
echo "<p>".get_vocab("default_report_days_explain").get_vocab("deux_points")."\n<input type=\"text\" name=\"default_report_days\" value=\"".getSettingValue("default_report_days")."\" size=\"5\" />\n";
# Formulaire de réservation
echo "</p><hr /><h3>".get_vocab("formulaire_reservation")."</h3>\n";
echo "<p>".get_vocab("longueur_liste_ressources").get_vocab("deux_points")."<input type=\"text\" name=\"longueur_liste_ressources_max\" value=\"".getSettingValue("longueur_liste_ressources_max")."\" size=\"5\" />";
/*
# nb_year_calendar permet de fixer la plage de choix de l'année dans le choix des dates de début et fin des réservations
# La plage s'étend de année_en_cours - $nb_year_calendar à année_en_cours + $nb_year_calendar
# Par exemple, si on fixe $nb_year_calendar = 5 et que l'on est en 2005, la plage de choix de l'année s'étendra de 2000 à 2010
echo "<hr /><h3>".get_vocab("nb_year_calendar_msg")."</h3>\n";
echo get_vocab("nb_year_calendar_explain").get_vocab("deux_points");
echo "<select name=\"nb_year_calendar\" size=\"1\">\n";
$i = 1;
while ($i < 101) {
	echo "<option value=\".$i.\"";
	if (getSettingValue("nb_year_calendar") == $i)
		echo " selected=\"selected\" ";
	echo ">".(date("Y") - $i)." - ".(date("Y") + $i)."</option>\n";
	$i++;
}
echo "</select>\n";
*/
echo "<br /><br /></p><div id=\"fixe\" style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>";
echo "</form>";
?>
<!--MAJ David VOUE 23/01/2014 Script de validation du mail du destinataire -->
<script>
	jQuery.validator.setDefaults(
	{
		debug: false,
		success: "valid"
	});
	$( "#nom_formulaire" ).validate(
	{
		rules: {
			mail_destinataire:
			{
				required: true,
				email: true
			},
			webmaster_email:
			{
				required: true,
				email: true
			},
			technical_support_email:
			{
				required: true,
				email: true
			}
		}
	});
</script>
<script type="text/javascript">
	document.getElementById('title_home_page').focus();
</script>
<?php
// fin de l'affichage de la colonne de droite
echo "</td></tr></table>";
?>
