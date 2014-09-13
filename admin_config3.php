<?php
/**
 * admin_config3.php
 * Interface permettant à l'administrateur la configuration de certains paramètres généraux
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2009-10-09 07:55:48 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config3.php,v 1.9 2009-10-09 07:55:48 grr Exp $
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
/**
 * $Log: admin_config3.php,v $
 * Revision 1.9  2009-10-09 07:55:48  grr
 * *** empty log message ***
 *
 * Revision 1.8  2009-04-10 05:33:10  grr
 * *** empty log message ***
 *
 * Revision 1.6  2009-03-24 13:30:07  grr
 * *** empty log message ***
 *
 * Revision 1.5  2009-02-27 13:28:19  grr
 * *** empty log message ***
 *
 * Revision 1.4  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 *
 */

$msg = "";
// Automatic mail
if (isset($_GET['automatic_mail']))
{
	if (!saveSetting("automatic_mail", $_GET['automatic_mail']))
	{
		echo "Erreur lors de l'enregistrement de automatic_mail !<br />";
		die();
	}
}
//envoyer_email_avec_formulaire
if (isset($_GET['envoyer_email_avec_formulaire']))
{
	if (!saveSetting("envoyer_email_avec_formulaire", $_GET['envoyer_email_avec_formulaire']))
	{
		echo "Erreur lors de l'enregistrement de envoyer_email_avec_formulaire !<br />";
		die();
	}
}
// javascript_info_disabled
if (isset($_GET['javascript_info_disabled']))
{
	if (!saveSetting("javascript_info_disabled", $_GET['javascript_info_disabled']))
	{
		echo "Erreur lors de l'enregistrement de javascript_info_disabled !<br />";
		die();
	}
}
// javascript_info_admin_disabled
if (isset($_GET['javascript_info_admin_disabled']))
{
	if (!saveSetting("javascript_info_admin_disabled", $_GET['javascript_info_admin_disabled']))
	{
		echo "Erreur lors de l'enregistrement de javascript_info_admin_disabled !<br />";
		die();
	}
}
if (isset($_GET['grr_mail_method']))
{
	if (!saveSetting("grr_mail_method", $_GET['grr_mail_method']))
	{
		echo "Erreur lors de l'enregistrement de grr_mail_method !<br />";
		die();
	}
}
if (isset($_GET['grr_mail_smtp']))
{
	if (!saveSetting("grr_mail_smtp", $_GET['grr_mail_smtp']))
	{
		echo "Erreur lors de l'enregistrement de grr_mail_smtp !<br />";
		die();
	}
}
if (isset($_GET['grr_mail_Username']))
{
	if (!saveSetting("grr_mail_Username", $_GET['grr_mail_Username']))
	{
		echo "Erreur lors de l'enregistrement de grr_mail_Username !<br />";
		die();
	}
}
if (isset($_GET['grr_mail_Password']))
{
	if (!saveSetting("grr_mail_Password", $_GET['grr_mail_Password']))
	{
		echo "Erreur lors de l'enregistrement de grr_mail_Password !<br />";
		die();
	}
}

if (isset($_GET['grr_mail_from']))
{
	if (!saveSetting("grr_mail_from", $_GET['grr_mail_from']))
	{
		echo "Erreur lors de l'enregistrement de grr_mail_from !<br />";
		die();
	}
}
if (isset($_GET['grr_mail_fromname']))
{
	if (!saveSetting("grr_mail_fromname", $_GET['grr_mail_fromname']))
	{
		echo "Erreur lors de l'enregistrement de grr_mail_fromname !<br />";
		die();
	}
}
if (isset($_GET['ok']))
{
	if (isset($_GET['grr_mail_Bcc']))
		$grr_mail_Bcc = "y";
	else
		$grr_mail_Bcc = "n";
	if (!saveSetting("grr_mail_Bcc", $grr_mail_Bcc))
	{
		echo "Erreur lors de l'enregistrement de grr_mail_Bcc !<br />";
		die();
	}
}

if (isset($_GET['verif_reservation_auto']))
{
	if (!saveSetting("verif_reservation_auto", $_GET['verif_reservation_auto']))
	{
		echo "Erreur lors de l'enregistrement de verif_reservation_auto !<br />";
		die();
	}
	if ($_GET['verif_reservation_auto'] == 0)
	{
		$_GET['motdepasse_verif_auto_grr'] = "";
		$_GET['chemin_complet_grr'] = "";
	}
}

if (isset($_GET['motdepasse_verif_auto_grr']))
{
	if (($_GET['verif_reservation_auto'] == 1) && ($_GET['motdepasse_verif_auto_grr'] == ""))
		$msg .= "l'exécution du script verif_auto_grr.php requiert un mot de passe !\\n";
	if (!saveSetting("motdepasse_verif_auto_grr", $_GET['motdepasse_verif_auto_grr']))
	{
		echo "Erreur lors de l'enregistrement de motdepasse_verif_auto_grr !<br />";
		die();
	}
}
if (isset($_GET['chemin_complet_grr']))
{
	if (!saveSetting("chemin_complet_grr", $_GET['chemin_complet_grr']))
	{
		echo "Erreur lors de l'enregistrement de chemin_complet_grr !<br />";
		die();
	}
}
if (!loadSettings())
	die("Erreur chargement settings");
# print the page header
print_header("", "", "", "", $type = "with_session", $page = "admin");
if (isset($_GET['ok']))
{
	$msg = get_vocab("message_records");
	affiche_pop_up($msg,"admin");
}
// Affichage de la colonne de gauche
include "admin_col_gauche.php";
// Affichage du tableau de choix des sous-configuration
include "include/admin_config_tableau.inc.php";
echo "<form action=\"./admin_config.php\"  method=\"get\" style=\"width: 100%;\">\n";
//
// Automatic mail
//********************************
//
echo "<h3>".get_vocab('title_automatic_mail').grr_help("aide_grr_mail_auto")."</h3>\n";
echo "<p><i>".get_vocab("warning_message_mail")."</i></p>\n";
echo "<p>".get_vocab("explain_automatic_mail")."\n";
?>
<br />
<input type='radio' name='automatic_mail' value='yes' id='label_3' <?php if (getSettingValue("automatic_mail") == 'yes') echo "checked=\"checked\"";?> />
<label for='label_3'>
<?php
echo get_vocab("mail_admin_on");
if (getSettingValue("automatic_mail") == 'yes')
	echo " - <a href='admin_email_manager.php'>".get_vocab('admin_email_manager.php')."</a>\n";
?>
</label>
<br />
<input type='radio' name='automatic_mail' value='no' id='label_4' <?php if (getSettingValue("automatic_mail") == 'no') echo "checked=\"checked\"";?> />
<label for='label_4'><?php echo get_vocab("mail_admin_off"); ?></label>
<?php
// Configuration des liens adresses
echo "</p><hr /><h3>".get_vocab('configuration_liens_adresses')."</h3>\n";
echo "<p>";
?>
<input type='radio' name='envoyer_email_avec_formulaire' value='yes' id='label_5' <?php if (getSettingValue("envoyer_email_avec_formulaire") == 'yes') echo "checked=\"checked\"";?> /><label for='label_5'><?php echo get_vocab("envoyer_email_avec_formulaire_oui"); ?></label>
<br /><input type='radio' name='envoyer_email_avec_formulaire' value='no' id='label_6' <?php if (getSettingValue("envoyer_email_avec_formulaire") == 'no') echo "checked=\"checked\"";?> /> <label for='label_6'><?php echo get_vocab("envoyer_email_avec_formulaire_non"); ?></label>
<?php
echo "</p><hr /><h3>".get_vocab('Parametres configuration envoi automatique mails')."</h3>\n";
echo "<p>".get_vocab('Explications des parametres configuration envoi automatique mails');
echo "<br /><br /><input type=\"radio\" name=\"grr_mail_method\" value=\"mail\" ";
if (getSettingValue('grr_mail_method') == "mail")
	echo " checked=\"checked\" ";
echo "/>\n";
echo get_vocab('methode mail');
echo "&nbsp;&nbsp;<input type=\"radio\" name=\"grr_mail_method\" value=\"smtp\" ";
if (getSettingValue('grr_mail_method') == "smtp")
	echo " checked=\"checked\" ";
echo "/>\n";
echo get_vocab('methode smtp');
echo "\n<br /><br />".get_vocab('Explications methode smtp 1').get_vocab('deux_points');
echo "\n<input type = \"text\" name=\"grr_mail_smtp\" value =\"".getSettingValue('grr_mail_smtp')."\" />";
echo "\n<br />".get_vocab('Explications methode smtp 2');
echo "\n<br />".get_vocab('utilisateur smtp').get_vocab('deux_points');
echo "\n<input type = \"text\" name=\"grr_mail_Username\" value =\"".getSettingValue('grr_mail_Username')."\" />";
echo "\n<br />".get_vocab('pwd').get_vocab('deux_points');
echo "\n<input type = \"password\" name=\"grr_mail_Password\" value =\"".getSettingValue('grr_mail_Password')."\" />";
echo "\n<br />".get_vocab('Email_expediteur_messages_automatiques').get_vocab('deux_points');
if (trim(getSettingValue('grr_mail_from')) == "")
	$grr_mail_from = "noreply@mon.site.fr";
else
	$grr_mail_from = getSettingValue('grr_mail_from');
echo "\n<input type = \"text\" name=\"grr_mail_from\" value =\"".$grr_mail_from."\" size=\"30\" />";
echo "\n<br />".get_vocab('Nom_expediteur_messages_automatiques').get_vocab('deux_points');
echo "\n<input type = \"text\" name=\"grr_mail_fromname\" value =\"".getSettingValue('grr_mail_fromname')."\" size=\"30\" />";
echo "\n<br /><br />";
echo "\n<input type=\"checkbox\" name=\"grr_mail_Bcc\" value=\"y\" ";
if (getSettingValue('grr_mail_Bcc') == "y")
	echo " checked=\"checked\" ";
echo "/>";
echo get_vocab('copie cachee');
# Désactive les messages javascript (pop-up) après la création/modificatio/suppression d'une réservation
# 1 = Oui, 0 = Non
echo "\n</p><hr /><h3>".get_vocab("javascript_info_disabled_msg")."</h3>";
echo "\n<table cellspacing=\"5\">";
echo "\n<tr><td>".get_vocab("javascript_info_disabled0")."</td><td>";
echo "\n<input type='radio' name='javascript_info_disabled' value='0' ";
if (getSettingValue("javascript_info_disabled") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("javascript_info_disabled1")."</td><td>";
echo "\n<input type='radio' name='javascript_info_disabled' value='1' ";
if (getSettingValue("javascript_info_disabled") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "\n</td></tr>";
echo "\n</table>";

# Désactive les messages javascript d'information (pop-up) dans les menus d'administration
# 1 = Oui, 0 = Non
echo "\n<hr /><h3>".get_vocab("javascript_info_admin_disabled_msg")."</h3>";
echo "\n<table cellspacing=\"5\">";
echo "\n<tr><td>".get_vocab("javascript_info_admin_disabled0")."</td><td>";
echo "\n<input type='radio' name='javascript_info_admin_disabled' value='0' ";
if (getSettingValue("javascript_info_admin_disabled") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("javascript_info_disabled1")."</td><td>";
echo "\n<input type='radio' name='javascript_info_admin_disabled' value='1' ";
if (getSettingValue("javascript_info_admin_disabled") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "\n</td></tr>";
echo "\n</table>";

# tâche automatique de suppression
echo "\n<hr /><h3>".get_vocab("suppression automatique des réservations")."</h3>";
echo "\n<p>".get_vocab('Explications suppression automatique des réservations').grr_help("aide_grr_verif_auto_grr")."</p>";
echo "\n<table cellspacing=\"5\">";
echo "\n<tr><td>".get_vocab("verif_reservation_auto0")."</td><td>";
echo "\n<input type='radio' name='verif_reservation_auto' value='0' ";
if (getSettingValue("verif_reservation_auto") == '0')
	echo "checked=\"checked\"";
echo " />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("verif_reservation_auto1")."</td><td>";
echo "\n<input type='radio' name='verif_reservation_auto' value='1' ";
if (getSettingValue("verif_reservation_auto") == '1')
	echo "checked=\"checked\"";
echo " />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("verif_reservation_auto2").get_vocab("deux_points")."</td><td>";
echo "\n<input type=\"text\" name=\"motdepasse_verif_auto_grr\" value=\"".getSettingValue("motdepasse_verif_auto_grr")."\" size=\"20\" />";
echo "\n</td></tr>";
echo "\n<tr><td>".get_vocab("verif_reservation_auto3").get_vocab("deux_points")."</td><td>";
echo "\n<input type=\"text\" name=\"chemin_complet_grr\" value=\"".getSettingValue("chemin_complet_grr")."\" size=\"20\" />";
echo "\n</td></tr>";
echo "\n</table>";
echo "\n<p><input type=\"hidden\" name=\"page_config\" value=\"3\" />";
echo "\n<br /></p><div id=\"fixe\"  style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" style=\"font-variant: small-caps;\"/></div>";
echo "\n</form>";
// fin de l'affichage de la colonne de droite
echo "\n</td></tr></table>";
?>
