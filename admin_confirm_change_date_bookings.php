
<?php
/**
 * admin_confirm_change_date_bookings.php
 * interface de confirmation des changements de date de début et de fin de réservation
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2009-06-04 15:30:17 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_confirm_change_date_bookings.php,v 1.8 2009-06-04 15:30:17 grr Exp $
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
 * $Log: admin_confirm_change_date_bookings.php,v $
 * Revision 1.8  2009-06-04 15:30:17  grr
 * *** empty log message ***
 *
 * Revision 1.7  2009-04-14 12:59:17  grr
 * *** empty log message ***
 *
 * Revision 1.6  2009-02-27 13:28:19  grr
 * *** empty log message ***
 *
 * Revision 1.5  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 *
 */

include "include/admin.inc.php";
$grr_script_name = "admin_confirm_change_date_bookings.php";
$back = '';
if (isset($_SERVER['HTTP_REFERER']))
	$back = htmlspecialchars($_SERVER['HTTP_REFERER']);
unset($display);
$display = isset($_GET["display"]) ? $_GET["display"] : NULL;
if (authGetUserLevel(getUserName(), -1) < 6)
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
	showAccessDenied($day, $month, $year, '', $back);
	exit();
}
if (isset($_GET['valid']) && ($_GET['valid'] == "yes"))
{
	if (!saveSetting("begin_bookings", $_GET['begin_bookings']))
		echo "Erreur lors de l'enregistrement de begin_bookings !<br />";
	else
	{
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_entry WHERE (end_time < ".getSettingValue('begin_bookings').")");
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_repeat WHERE end_date < ".getSettingValue("begin_bookings"));
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_entry_moderate WHERE (end_time < ".getSettingValue('begin_bookings').")");
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_calendar WHERE DAY < ".getSettingValue("begin_bookings"));
	}
	if (!saveSetting("end_bookings", $_GET['end_bookings']))
		echo "Erreur lors de l'enregistrement de end_bookings !<br />";
	else
	{
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_entry WHERE start_time > ".getSettingValue("end_bookings"));
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_repeat WHERE start_time > ".getSettingValue("end_bookings"));
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_entry_moderate WHERE (start_time > ".getSettingValue('end_bookings').")");
		$del = grr_sql_query("DELETE FROM ".TABLE_PREFIX."_calendar WHERE DAY > ".getSettingValue("end_bookings"));
	}
	header("Location: ./admin_config.php");

}
else if (isset($_GET['valid']) && ($_GET['valid'] == "no"))
	header("Location: ./admin_config.php");
# print the page header
print_header("", "", "", "", $type = "with_session", $page = "admin");
echo "<h2>".get_vocab('admin_confirm_change_date_bookings.php')."</h2>";
echo "<p>".get_vocab("msg_del_bookings")."</p>";
?>
<form action="admin_confirm_change_date_bookings.php" method='get'>
	<div>
		<input type="submit" value="<?php echo get_vocab("save");?>" />
		<input type="hidden" name="valid" value="yes" />
		<input type="hidden" name="begin_bookings" value=" <?php echo $_GET['begin_bookings']; ?>" />
		<input type="hidden" name="end_bookings" value=" <?php echo $_GET['end_bookings']; ?>" />
	</div>
</form>

<form action="admin_confirm_change_date_bookings.php" method='get'>
	<div>
		<input type="submit" value="<?php echo get_vocab("cancel");?>" />
		<input type="hidden" name="valid" value="no" />
	</div>
</form>
</body>
</html>
