<?php
/**
 * view_entry.php
 * Interface de visualisation d'une réservation
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-04-07 15:38:14 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: view_entry.php,v 1.16 2010-04-07 15:38:14 grr Exp $
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
 * $Log: view_entry.php,v $
 * Revision 1.16  2010-04-07 15:38:14  grr
 * *** empty log message ***
 *
 * Revision 1.15  2009-09-29 18:02:57  grr
 * *** empty log message ***
 *
 * Revision 1.14  2009-04-14 12:59:17  grr
 * *** empty log message ***
 *
 * Revision 1.13  2009-04-09 14:52:31  grr
 * *** empty log message ***
 *
 * Revision 1.12  2009-03-24 13:30:07  grr
 * *** empty log message ***
 *
 * Revision 1.11  2009-01-20 07:19:17  grr
 * *** empty log message ***
 *
 * Revision 1.10  2008-11-16 22:00:59  grr
 * *** empty log message ***
 *
 * Revision 1.9  2008-11-11 22:01:14  grr
 * *** empty log message ***
 *
 * Revision 1.8  2008-11-10 08:17:34  grr
 * *** empty log message ***
 *
 * Revision 1.7  2008-11-10 07:06:39  grr
 * *** empty log message ***
 *
 *
 */
echo"<div>";
include_once('include/connect.inc.php');
include_once('include/config.inc.php');
include_once('include/functions.inc.php');
include_once('include/'.$dbsys.'.inc.php');
include_once('include/misc.inc.php');
include_once('include/mrbs_sql.inc.php');


$grr_script_name = 'view_entry.php';

// Settings
require_once('include/settings.inc.php');

//Chargement des valeurs de la table settingS
if (!loadSettings())
    die("Erreur chargement settings");

// Session related functions
require_once('include/session.inc.php');

// Paramètres langage
include_once('include/language.inc.php');



//Hugo A VOIR
//Ajout d'une condition par rapport à la configuration (popup ou non) pour le header

if(getSettingValue("display_level_view_entry")=='0')
    header('Content-Type: text/xml; charset=ISO-8859-1');
// Resume session
$fin_session = 'n';
if (!grr_resumeSession())
    $fin_session = 'y';

if (($fin_session == 'y') and (getSettingValue("authentification_obli")==1)) {
    header("Location: ./logout.php?auto=1&url=$url");
    die();
};

if ((getSettingValue("authentification_obli")==0) and (getUserName()=='')) {
    $type_session = "no_session";
}
else
{
  $type_session = "with_session";
}

// Initialisation
unset($reg_statut_id);
$reg_statut_id = isset($_GET["statut_id"]) ? $_GET["statut_id"] : "";
if (isset($_GET["id"]))
{
  $id = $_GET["id"];
  settype($id,"integer");
} else {
  die();
}

$back = '';
if (isset($_SERVER['HTTP_REFERER'])) $back = htmlspecialchars($_SERVER['HTTP_REFERER']);

if (isset($_GET["action_moderate"])) {
    // on modère
    moderate_entry_do($id,$_GET["moderate"],$_GET["description"]);
};


// Recherche des infos liée à la réservation
$sql = "SELECT ".TABLE_PREFIX."_entry.name,
       ".TABLE_PREFIX."_entry.description,
       ".TABLE_PREFIX."_entry.beneficiaire,
       ".TABLE_PREFIX."_room.room_name,
       ".TABLE_PREFIX."_area.area_name,
       ".TABLE_PREFIX."_entry.type,
       ".TABLE_PREFIX."_entry.room_id,
       ".TABLE_PREFIX."_entry.repeat_id,
             ".grr_sql_syntax_timestamp_to_unix("".TABLE_PREFIX."_entry.timestamp").",
       (".TABLE_PREFIX."_entry.end_time - ".TABLE_PREFIX."_entry.start_time),
       ".TABLE_PREFIX."_entry.start_time,
       ".TABLE_PREFIX."_entry.end_time,
       ".TABLE_PREFIX."_area.id,
       ".TABLE_PREFIX."_entry.statut_entry,
       ".TABLE_PREFIX."_room.delais_option_reservation,
       ".TABLE_PREFIX."_entry.option_reservation, " .
       "".TABLE_PREFIX."_entry.moderate,
       ".TABLE_PREFIX."_entry.beneficiaire_ext,
       ".TABLE_PREFIX."_entry.create_by,
       ".TABLE_PREFIX."_entry.jours,
       ".TABLE_PREFIX."_room.active_ressource_empruntee
FROM ".TABLE_PREFIX."_entry, ".TABLE_PREFIX."_room, ".TABLE_PREFIX."_area
WHERE ".TABLE_PREFIX."_entry.room_id = ".TABLE_PREFIX."_room.id
  AND ".TABLE_PREFIX."_room.area_id = ".TABLE_PREFIX."_area.id
        AND ".TABLE_PREFIX."_entry.id='".$id."'";

$sql_backup = "SELECT ".TABLE_PREFIX."_entry_moderate.name,
       ".TABLE_PREFIX."_entry_moderate.description,
       ".TABLE_PREFIX."_entry_moderate.beneficiaire,
       ".TABLE_PREFIX."_room.room_name,
       ".TABLE_PREFIX."_area.area_name,
       ".TABLE_PREFIX."_entry_moderate.type,
       ".TABLE_PREFIX."_entry_moderate.room_id,
       ".TABLE_PREFIX."_entry_moderate.repeat_id,
                    ".grr_sql_syntax_timestamp_to_unix("".TABLE_PREFIX."_entry_moderate.timestamp").",
       (".TABLE_PREFIX."_entry_moderate.end_time - ".TABLE_PREFIX."_entry_moderate.start_time),
       ".TABLE_PREFIX."_entry_moderate.start_time,
       ".TABLE_PREFIX."_entry_moderate.end_time,
       ".TABLE_PREFIX."_area.id,
       ".TABLE_PREFIX."_entry_moderate.statut_entry,
       ".TABLE_PREFIX."_room.delais_option_reservation,
       ".TABLE_PREFIX."_entry_moderate.option_reservation, " .
       "".TABLE_PREFIX."_entry_moderate.moderate,
       ".TABLE_PREFIX."_entry_moderate.beneficiaire_ext,
       ".TABLE_PREFIX."_entry_moderate.create_by
FROM ".TABLE_PREFIX."_entry_moderate, ".TABLE_PREFIX."_room, ".TABLE_PREFIX."_area
WHERE ".TABLE_PREFIX."_entry_moderate.room_id = ".TABLE_PREFIX."_room.id
  AND ".TABLE_PREFIX."_room.area_id = ".TABLE_PREFIX."_area.id
                AND ".TABLE_PREFIX."_entry_moderate.id='".$id."'";

$res = grr_sql_query($sql);
if (! $res) fatal_error(0, grr_sql_error());
if(grr_sql_count($res) < 1)
{
  $reservation_is_delete = 'y';
  // La réservation n'est pas présente dans la table ".TABLE_PREFIX."_entry, cela signifie qu'elle a été supprimée
  // On en cherche donc la trace dans ".TABLE_PREFIX."_entry_moderate
  $was_del = TRUE;
  $res_backup = grr_sql_query($sql_backup);
  if (! $res_backup) fatal_error(0, grr_sql_error());
  $row = grr_sql_row($res_backup, 0);
  grr_sql_free($res_backup);
}
else {
  // la réservation est normalement présente dans ".TABLE_PREFIX."_entry
  $was_del = FALSE;
  $row = grr_sql_row($res, 0);
}
grr_sql_free($res);

$breve_description = $row[0];
$description  = bbcode(htmlspecialchars($row[1]),'');
$beneficiaire    = htmlspecialchars($row[2]);
$room_name    = htmlspecialchars($row[3]);
$area_name    = htmlspecialchars($row[4]);
$type         = $row[5];
$room_id      = $row[6];
$repeat_id    = $row[7];
$updated      = time_date_string($row[8],$dformat);
$duration     = $row[9];
$area      = $row[12];
$statut_id = $row[13];
$delais_option_reservation = $row[14];
$option_reservation = $row[15];
$moderate = $row[16];
$beneficiaire_ext    = htmlspecialchars($row[17]);
$create_by    = htmlspecialchars($row[18]);
$jour_cycle    = htmlspecialchars($row[19]);
$active_ressource_empruntee = htmlspecialchars($row[20]);
$rep_type = 0;
$verif_display_email = verif_display_email(getUserName(), $room_id);
if ($verif_display_email)
   $option_affiche_nom_prenom_email = "withmail";
else
   $option_affiche_nom_prenom_email = "nomail";

// Si l'utilisateur est administrateur, possibilité de modifier le statut de la réservation (en cours / libérée)
if (($fin_session == 'n') and (getUserName()!='') and (authGetUserLevel(getUserName(),$room_id) >= 3) and (isset($_GET['ok'])))
{
  if (!$was_del)
    {
      if ($reg_statut_id != "") {
        $upd1 = "update ".TABLE_PREFIX."_entry set statut_entry='-' where room_id = '".$room_id."'";
        if (grr_sql_command($upd1) < 0) return 0;
        $upd2 = "update ".TABLE_PREFIX."_entry set statut_entry='$reg_statut_id' where id = '".$id."'";
        if (grr_sql_command($upd2) < 0) return 0;
      }
      if ((isset($_GET["envoyer_mail"])) and (getSettingValue("automatic_mail") == 'yes')) {
          $_SESSION['session_message_error'] = send_mail($id,7,$dformat);
          if ($_SESSION['session_message_error'] == "") {
              $_SESSION['displ_msg'] = "yes";
              $_SESSION["msg_a_afficher"] = get_vocab("un email envoye")." ".$_GET["mail_exist"];
          }
      }
      header("Location: ".$_GET['back']."");
      die();
    }
}

#If we dont know the right date then make it up
if(!isset($day) or !isset($month) or !isset($year))
{
    $day   = date("d");
    $month = date("m");
    $year  = date("Y");
}

// Calcul du niveau d'accès aux fiche de réservation détaillées des ressources
if (!verif_acces_fiche_reservation(getUserName(), $room_id))
{
    showAccessDenied($day, $month, $year, $area,$back);
    exit();
}

// Fichiers de personnalisation de langue pour le domaine
if (@file_exists("language/lang_subst_".$area.".".$locale))
    include "language/lang_subst_".$area.".".$locale;


if((authGetUserLevel(getUserName(),-1) < 1) and (getSettingValue("authentification_obli")==1))
{
    showAccessDenied($day, $month, $year, $area,$back);
    exit();
}
if(authUserAccesArea(getUserName(), $area)==0)
{
if (isset($reservation_is_delete))
    showNoReservation($day, $month, $year, $area,$back);
else
    showAccessDenied($day, $month, $year, $area,$back);

    exit();
}

$date_now = mktime();

$page = verif_page();


//Hugo A VOIR
//LOIS - Ceci est passé en commentaire
//print_header($day, $month, $year, $area, $type_session);


// Récupération des données concernant l'affichage du planning du domaine
get_planning_area_values($area);

if($enable_periods=='y') list( $start_period, $start_date) =  period_date_string($row[10]);
else $start_date = time_date_string($row[10],$dformat);

if($enable_periods=='y') list( , $end_date) =  period_date_string($row[11], -1);
else $end_date = time_date_string($row[11],$dformat);

if ($beneficiaire!="") {
    $mail_exist = grr_sql_query1("select email from ".TABLE_PREFIX."_utilisateurs where login='$beneficiaire'");
} else {
    $tab_benef = donne_nom_email($beneficiaire_ext);
    $mail_exist = $tab_benef["email"];
}


if ($enable_periods=='y') toPeriodString($start_period, $duration, $dur_units);
else toTimeString($duration, $dur_units);


# Now that we know all the data we start drawing it
// if ($was_del) echo "effacé"; else echo "OK";

// Cas où la page pointe sur elle-même, on recalcul $back
if (strstr ($back, 'view_entry.php')) {
    $sql = "select start_time, room_id from ".TABLE_PREFIX."_entry where id=". $id;
    $res = grr_sql_query($sql);
    if (! $res) fatal_error(0, grr_sql_error());
    if(grr_sql_count($res) >= 1) {
        $row1 = grr_sql_row($res, 0);
        $year = date ('Y', $row1['0']); $month = date ('m', $row1['0']); $day = date ('d', $row1['0']);
        $back = $page.'.php?year='.$year.'&amp;month='.$month.'&amp;day='.$day;
        if ((isset($_GET["page"])) and (($_GET["page"] == "week") or ($_GET["page"] == "month") or ($_GET["page"] == "week_all") or ($_GET["page"] == "month_all")))
        {
        $back .= "&amp;area=".mrbsGetRoomArea($row1['1']);
        }
        if ((isset($_GET["page"])) and (($_GET["page"] == "week") or ($_GET["page"] == "month") ))
        {
        $back .= "&amp;room=".$row1['1'];
        }

    } else
        $back = "";
}

//Ajout d'une condition pour le déroulement de la condition if($back..) ou non
if(getSettingValue("display_level_view_entry")=='1') {if ($back != "") echo "<div><a href=\"".$back."\">".get_vocab("returnprev")."</a></div>\n";}
echo '<fieldset><legend style="font-size:12pt;font-weight:bold">'.get_vocab('entry').get_vocab('deux_points').affichage_lien_resa_planning($breve_description, $id).'</legend>'."\n";
?>
 <table border="0">
   <tr>
    <td><b><?php echo get_vocab("description") ?></b></td>
    <td><?php    echo nl2br($description)  ?></td>
   </tr>
   <?php
    //Informations additionnelles
    if (!$was_del) {
      $overload_data = mrbsEntryGetOverloadDesc($id);
      foreach ($overload_data as $fieldname=>$fielddata) {
        if ($fielddata["confidentiel"] == 'n')
            $affiche_champ = 'y';
        else
            if (($fin_session != 'n') or (getUserName()==''))
               $affiche_champ = 'n';
            else
               // seuls les administrateurs et le bénéficiaire peut voir un champ confidentiel
               if ((authGetUserLevel(getUserName(),$room_id) >= 4) or ($beneficiaire == getUserName()))
                   $affiche_champ = 'y';
               else
                   $affiche_champ = 'n';
        if ($affiche_champ == 'y') {
           
            echo "<tr><td><b>".bbcode(htmlspecialchars($fieldname).get_vocab("deux_points"),'')."</b></td>\n";
            echo "<td>".bbcode(htmlspecialchars($fielddata["valeur"]),'')."</td></tr>\n";
        }
      }
    }
   ?>
   <tr>
    <td><b><?php echo get_vocab("room").get_vocab("deux_points")  ?></b></td>
    <td><?php    echo  nl2br($area_name . " - " . $room_name) ?></td>
   </tr>
   <tr>
    <td><b><?php echo get_vocab("start_date").get_vocab("deux_points") ?></b></td>
<td><?php    echo $start_date         ?></td>
   </tr>
   <tr>
    <td><b><?php echo get_vocab("duration")            ?></b></td>
    <td><?php    echo $duration . " " . $dur_units ?></td>
   </tr>
   <tr>
    <td><b><?php echo get_vocab("end_date") ?></b></td>
    <td><?php    echo $end_date         ?></td>
   </tr>
   <?php
   echo "<tr><td><b>".get_vocab("type").get_vocab("deux_points")."</b></td>\n";
   $type_name = grr_sql_query1("select type_name from ".TABLE_PREFIX."_type_area where type_letter='".$type."'");
   if ($type_name == -1) $type_name = "?$type?";
   echo "<td>".$type_name."</td></tr>";
   if ($beneficiaire != $create_by) {
   ?>
   <tr>
    <td><b><?php echo get_vocab("reservation au nom de").get_vocab("deux_points") ?></b></td>
    <td><?php    echo affiche_nom_prenom_email($beneficiaire,$beneficiaire_ext,$option_affiche_nom_prenom_email);         ?></td>
   </tr>
   <?php
   }
   ?>

   <tr>
    <td><b><?php echo get_vocab("created_by").get_vocab("deux_points") ?></b></td>
    <td><?php    echo affiche_nom_prenom_email($create_by,"",$option_affiche_nom_prenom_email);
    if ($active_ressource_empruntee == 'y') {
        $id_resa = grr_sql_query1("select id from ".TABLE_PREFIX."_entry where room_id = '".$room_id."' and statut_entry='y'");
        if ($id_resa ==$id)
           echo " <span class='avertissement'>&nbsp;(".get_vocab("reservation_en_cours").") <img src=\"img_grr/buzy_big.png\" align=middle alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" border=\"0\" width=\"30\" height=\"30\" class=\"print_image\"  /></span>";

    }
    ?>
    </td>
   </tr>

   <tr>
    <td><b><?php echo get_vocab("lastupdate").get_vocab("deux_points") ?></b></td>
    <td><?php    echo $updated            ?></td>
   </tr>
   <?php

// Option de réservation
if (($delais_option_reservation > 0) and ($option_reservation!=-1))
{
  echo "<tr bgcolor=\"#FF6955\"><td><b>".get_vocab("reservation_a_confirmer_au_plus_tard_le")."<b></td>\n";
  echo "<td><b>".time_date_string_jma($option_reservation,$dformat)."</b>\n";
  echo "</td></tr>\n";
}

if ($moderate == 1) {
    // En attente de modération
    echo "<tr><td><b>".get_vocab("moderation").get_vocab("deux_points")."</b></td>"; tdcell("avertissement"); echo "<strong>".get_vocab("en_attente_moderation")."</strong></td></tr>";
 } elseif ($moderate == 2) {
    // Modération acceptée
    // recupération des infos de moderation
    $sql = "select motivation_moderation, login_moderateur from ".TABLE_PREFIX."_entry_moderate where id=".$id;
    $res = grr_sql_query($sql);
    if (! $res) fatal_error(0, grr_sql_error());
    $row2 = grr_sql_row($res, 0); $description = $row2[0];
    // recuperation du nom du moderateur
    $sql ="select nom, prenom from ".TABLE_PREFIX."_utilisateurs where login = '".$row2[1]."'";
    $res = grr_sql_query($sql);
    if (! $res) fatal_error(0, grr_sql_error());
    $row3 = grr_sql_row($res, 0); $nom_modo = $row3[1]. ' '. $row3[0];
    if (authGetUserLevel(getUserName(),-1) > 1) { // les visiteurs n'ont pas accès à cette information
      echo '<tr><td><b>'.get_vocab("moderation").get_vocab("deux_points").'</b></td><td><strong>'.get_vocab("moderation_acceptee_par").'&nbsp;'.$nom_modo.'</strong>';
      if ($description != "") echo ' : <br />('.$description.')';
      echo "</td></tr>";
    }

 } elseif ($moderate == 3) {
    // Modération refusée
    // recupération des infos de moderation
    $sql = "select motivation_moderation, login_moderateur from ".TABLE_PREFIX."_entry_moderate where id=".$id;
    $res = grr_sql_query($sql);
    if (! $res) fatal_error(0, grr_sql_error());
    $row4 = grr_sql_row($res, 0); $description = $row4[0];
    // recuperation du nom du moderateur
    $sql ="select nom, prenom from ".TABLE_PREFIX."_utilisateurs where login = '".$row4[1]."'";
    $res = grr_sql_query($sql);
    if (! $res) fatal_error(0, grr_sql_error());
    $row5 = grr_sql_row($res, 0); $nom_modo = $row5[1]. ' '. $row5[0];
    if (authGetUserLevel(getUserName(),-1) > 1) { // les visiteurs n'ont pas accès à cette information
        echo '<tr><td><b>'.get_vocab("moderation").get_vocab("deux_points").'</b></td>'; tdcell("avertissement"); echo '<strong>'.get_vocab("moderation_refusee").'</strong> par '.$nom_modo;
        if ($description != "") echo ' : <br />('.$description.')';
        echo "</td></tr>";
    }
 }
if ((getWritable($beneficiaire, getUserName(),$id)) and verif_booking_date(getUserName(), $id, $room_id, -1, $date_now, $enable_periods) and verif_delais_min_resa_room(getUserName(), $room_id, $row[10]) and (!$was_del)) { ?>
    <tr>
    <td colspan="2">
    <?php
    echo "<a href=\"edit_entry.php?id=$id&amp;day=$day&amp;month=$month&amp;year=$year&amp;page=$page\">".get_vocab("editentry")."</a>";

echo " - <a href=\"edit_entry.php?id=$id&amp;day=$day&amp;month=$month&amp;year=$year&amp;page=$page&amp;copy\">".get_vocab("copyentry")."</a>";

    if  ($can_delete_or_create=="y") {
    $message_confirmation = str_replace ( "'"  , "\\'"  , get_vocab("confirmdel").get_vocab("deleteentry"));
    ?>
     - <a href="del_entry.php?id=<?php echo $id ?>&amp;series=0&amp;page=<?php echo $page; ?>" onclick="return confirm('<?php echo $message_confirmation ?>');"><?php echo get_vocab("deleteentry") ?></a></td>
    <?php
    }
    echo "</tr>";
}
echo "</table>";
echo "</fieldset>\n";

if($repeat_id != 0) {
    $res = grr_sql_query("select rep_type, end_date, rep_opt, rep_num_weeks, start_time, end_time from ".TABLE_PREFIX."_repeat where id=$repeat_id");
    if (! $res) fatal_error(0, grr_sql_error());

    if (grr_sql_count($res) == 1)
    {
        $row6 = grr_sql_row($res, 0);
        $rep_type     = $row6[0];
        $rep_end_date = utf8_strftime($dformat,$row6[1]);
        $rep_opt      = $row6[2];
        $rep_num_weeks = $row6[3];
        $start_time =  $row6[4];
        $end_time =  $row6[5];
        $duration = $row6[5] - $row6[4];
    }
    grr_sql_free($res);

    if($enable_periods=='y') list( $start_period, $start_date) =  period_date_string($start_time);
        else $start_date = time_date_string($start_time,$dformat);
    if ($enable_periods=='y') toPeriodString($start_period, $duration, $dur_units);
        else toTimeString($duration, $dur_units);

    $weeklist = array("unused","every week","week 1/2","week 1/3","week 1/4","week 1/5");
    if ($rep_type == 2)
        $affiche_period = get_vocab($weeklist[$rep_num_weeks]);
    else
        $affiche_period = get_vocab('rep_type_'.$rep_type);

    echo '<fieldset><legend style="font-weight:bold">'.get_vocab('periodicite_associe').grr_help("aide_grr_periodicite","fonctionnement")."</legend>\n";
    echo '<table cellpadding="1">';
    echo '<tr><td><b>'.get_vocab("rep_type").'</b></td><td>'.$affiche_period.'</td></tr>';
    if($rep_type != 0) {
    // cas d'une periodicité "une semaine sur n", on affiche les jours de périodicité
      if ($rep_type == 2) {
        $opt = "";
        $nb = 0;
        # Display day names according to language and preferred weekday start.
        for ($i = 0; $i < 7; $i++)
        {
            $daynum = ($i + $weekstarts) % 7;
            if ($rep_opt[$daynum]) {
                if ($opt != '') $opt .=', ';
                $opt .= day_name($daynum);
                $nb++;
             }
        }
        if($opt)
            if ($nb == 1)
                echo "<tr><td><b>".get_vocab("rep_rep_day")."</b></td><td>$opt</td></tr>\n";
            else
                echo "<tr><td><b>".get_vocab("rep_rep_days")."</b></td><td>$opt</td></tr>\n";

      }
      // cas d'une periodicité "Jour Cycle", on affiche le numéro du jour cycle
      if ($rep_type == 6) {
        if (getSettingValue("jours_cycles_actif") == "Oui" and intval($jour_cycle)>-1)
            echo "<tr><td><b>".get_vocab("rep_rep_day")."</b></td><td>".get_vocab('jour_cycle').' '.$jour_cycle."</td></tr>\n";
      }
      echo '<tr><td><b>'.get_vocab("date").get_vocab("deux_points").'</b></td><td>'.$start_date.'</td></tr>';
      echo '<tr><td><b>'.get_vocab("duration").'</b></td><td>'.$duration .' '. $dur_units.'</td></tr>';
      echo '<tr><td><b>'.get_vocab('rep_end_date').'</b></td><td>'.$rep_end_date.'</td></tr>';
    }
    if ((getWritable($beneficiaire, getUserName(),$id)) and verif_booking_date(getUserName(), $id, $room_id, -1, $date_now, $enable_periods) and verif_delais_min_resa_room(getUserName(), $room_id, $row[10]) and (!$was_del)) {
        $message_confirmation = str_replace ( "'"  , "\\'"  , get_vocab("confirmdel").get_vocab("deleteseries"));
        echo "<tr><td colspan = \"2\"><a href=\"edit_entry.php?id=$id&amp;edit_type=series&amp;day=$day&amp;month=$month&amp;year=$year&amp;page=$page\">".get_vocab("editseries")."</a></td></tr>";
        echo "<tr><td colspan = \"2\"><a href=\"del_entry.php?id=$id&amp;series=1&amp;day=$day&amp;month=$month&amp;year=$year&amp;page=$page\" onclick=\"return confirm('".$message_confirmation."');\">".get_vocab("deleteseries")."</a></td></tr>";
    }
    echo "</table></fieldset>";
}


?>
	<!--<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
	</form> -->

	<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : '/uploadify/uploadify.swf',
				'uploader' : '/uploadify/uploadify.php'
			});
		});
	</script>

<?


// ANTHONY ARCHAMBEAU Génération d'un fichier pdf sous forme de lien 


if ((authGetUserLevel(getUserName(),$area_id,"area") >1) or (authGetUserLevel(getUserName(),$room) >=4)) {
     echo"<a href=\"javascript:generationpdf()\" class=\"button\">Générer un PDF</a> "; }



//  ANTHONY ARCHAMBEAU UPLOAD DE FICHIERS SUR LE SERVEUR 

// Si la table n'existe pas grr_files , on la crée .

//$CREATION = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."_files` (
//  `id` INT NOT NULL AUTO_INCREMENT ,
//  `nom` VARCHAR(45) NULL ,
// `identry` VARCHAR(45) NULL ,
// PRIMARY KEY (`id`) 
//) ENGINE=InnoDB  DEFAULT CHARSET=utf8";

//grr_sql_command($CREATION);


// On créer une div file afin de permettre la suppression et le réaffichage de son contenu. ->
?>
<div id="file"> 
<?

// Requête pour récuperer le nom du/des fichier(s) correspondant(s) à la réservation ouverte. 
// identry correspond à l'id de la réservation au moment de l'insertion  dans la base de donnée, de l'upload , 
// et $id correspond à l'id de la reservation ouverte actuellement . 
 
//$res = grr_sql_query("SELECT nom FROM ".TABLE_PREFIX."_files WHERE identry = '".$id."' ");
//$nbresult = mysql_num_rows($res); // compte le nombre de lignes retournées 

//$monUrl = "http://".$_SERVER['HTTP_HOST']."/uploadify/files/"; // lien vers le répertoir d'upload
//if ($nbresult != 0) { // Si on a un fichier correspondant à la réservation ouverte 
	
	//echo"<br /> <br /> ";
	//echo"Fichier(s) lié(s) à cette réservation : <br /> ";
	//echo"<TABLE border = 1 '>";
    //for ($i = 0; ($row777 = grr_sql_row($res, $i)); $i++){ 
          // // pour chaques tuples renvoyés dans  $res 
		//$nom = $row777[0]; // on attribut à la variable nom , la valeur du champs nom (0)  à l'indice $i
						   // de la boucle
		//echo"<tr>";
		//echo"<TD><a href='".$monUrl."".$nom."' class=\"button\">'".$nom."'</a>  <br /></TD>";
							// on affiche le liens correspondant à notre fichié uploadé en concatainant
							// le chemin du repertoire d'upload avec notre niom complet de fichier 
		
		//if ( (getUserName()!='') and (authGetUserLevel(getUserName(),$room_id) >= 3) ) {
		// On autorise seulement le gestionnaire / l'admin a supprimer le fichier  
		//echo"<TD><a href=".$nom."  class=\"deletefile\" value=".$id." > <img src=\"uploadify/uploadify-cancel.png\"</a> </TD>";
		//}
		
		//echo"</tr>";
		
		//}
		//echo"</TABLE>";
//}
//echo "<br />";

?>
</div>
<?


// Sous forme de bouton

// echo"<input type=\"button\" onclick=\"javascript:demoFromHTML()\" value=\"Generer en pdf \">";



// Si l'utilisateur est gestionnaire de la ressource, possibilité de modérer la réservation
if ( (getUserName()!='') and (authGetUserLevel(getUserName(),$room_id) >= 3) and ($moderate == 1)) {
  echo "<form action=\"view_entry.php\" method=\"get\">\n";
  echo "<input type=\"hidden\" name=\"action_moderate\" value=\"y\" />\n";
  echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />\n";
  if (isset($_GET['page']))
      echo "<input type=\"hidden\" name=\"page\" value=\"".$_GET['page']."\" />\n";
  echo "<fieldset><legend style=\"font-weight:bold\">".get_vocab("moderate_entry").grr_help("aide_grr_moderation")."</legend>\n";
  echo "<p>";
  echo "<input type=\"radio\" name=\"moderate\" value=\"1\" checked=\"checked\" />".get_vocab("accepter_resa");
  echo "<br /><input type=\"radio\" name=\"moderate\" value=\"0\" />".get_vocab("refuser_resa");
  if($repeat_id) {
     echo "<br /><input type=\"radio\" name=\"moderate\" value=\"S1\" />".get_vocab("accepter_resa_serie");
     echo "<br /><input type=\"radio\" name=\"moderate\" value=\"S0\" />".get_vocab("refuser_resa_serie");
  }
  echo "</p><p>";
  echo "<label for=\"description\">".get_vocab("justifier_decision_moderation").get_vocab("deux_points")."</label>\n";
  echo "<textarea name=\"description\" id=\"description\" cols=\"40\" rows=\"3\"></textarea>";
  echo "</p>";
  echo "<br /><div style=\"text-align:center;\"><input type=\"submit\" name=\"commit\" value=\"".get_vocab("save")."\" /></div>\n";
  echo "</fieldset></form>\n";
}

// Si l'utilisateur est administrateur, possibilité de modifier le statut de la réservation (en cours / libérée)
if ($active_ressource_empruntee == 'y') {
  if ((!$was_del) and ($moderate != 1) and (getUserName()!='') and (authGetUserLevel(getUserName(),$room_id) >= 3))          {
    echo "<form action=\"view_entry.php\" method=\"get\">";
    echo "<fieldset><legend style=\"font-weight:bold\">".get_vocab("reservation_en_cours").grr_help("aide_grr_ressource_empruntee")."</legend>\n";
    echo "<span class=\"larger\">".get_vocab("signaler_reservation_en_cours")."</span>".get_vocab("deux_points");
    echo "<br />".get_vocab("explications_signaler_reservation_en_cours");

    affiche_ressource_empruntee($room_id, "texte");
    echo "<br /><input type=\"radio\" name=\"statut_id\" value=\"-\" ";
    if ($statut_id=='-') {
        // La ressource est-elle empruntée ?
        if (!affiche_ressource_empruntee($room_id,"autre")=='yes')
        echo " checked=\"checked\" ";
    }
    echo " />".get_vocab("signaler_reservation_en_cours_option_0");
    echo "<br /><br /><input type=\"radio\" name=\"statut_id\" value=\"y\" ";
    if ($statut_id=='y') echo " checked=\"checked\" ";
    echo " />".get_vocab("signaler_reservation_en_cours_option_1");
    echo "<br /><br /><input type=\"radio\" name=\"statut_id\" value=\"e\" ";
    if ($statut_id=='e') echo " checked=\"checked\" ";
    if ((!(getSettingValue("automatic_mail") == 'yes')) or ($mail_exist == ""))
        echo " disabled ";
    echo " />".get_vocab("signaler_reservation_en_cours_option_2");
    if ((!(getSettingValue("automatic_mail") == 'yes')) or ($mail_exist == ""))
        echo "<br /><i>(".get_vocab("necessite fonction mail automatique").")</i>";



    if (getSettingValue("automatic_mail") == 'yes') {
        echo "<br /><br /><input type=\"checkbox\" name=\"envoyer_mail\" value=\"y\" ";
        if ($mail_exist == "") echo " disabled ";
        echo " />".get_vocab("envoyer maintenant mail retard");
        echo "<input type=\"hidden\" name=\"mail_exist\" value=\"".$mail_exist."\" />";
    }
    if ((!(getSettingValue("automatic_mail") == 'yes')) or ($mail_exist == ""))
        echo "<br /><i>(".get_vocab("necessite fonction mail automatique").")</i>";


    echo "<br /><div style=\"text-align:center;\"><input type=\"submit\" name=\"ok\" value=\"".get_vocab("save")."\" /></div>
    </fieldset>\n";
    echo "<div><input type=\"hidden\" name=\"day\" value=\"".$day."\" />";
    echo "<input type=\"hidden\" name=\"month\" value=\"".$month."\" />";
    echo "<input type=\"hidden\" name=\"year\" value=\"".$year."\" />";
    echo "<input type=\"hidden\" name=\"page\" value=\"".$page."\" />";
    echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\" />";
    echo "<input type=\"hidden\" name=\"back\" value=\"".$back."\" /></div>";
    echo "</form>";
  }
}
include_once('include/trailer.inc.php');
echo"</div>";
?>
