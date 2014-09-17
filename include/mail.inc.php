<?php
/**
 * mail.inc.php
 * Configuration de phpmailer
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2008-11-16 22:00:59 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: mail.inc.php,v 1.2 2008-11-16 22:00:59 grr Exp $
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
 * $Log: mail.inc.php,v $
 * Revision 1.2  2008-11-16 22:00:59  grr
 * *** empty log message ***
 *
 *
 */

error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING);
	// Appel de la classe phpmailer
require 'phpmailer/PHPMailerAutoload.php';
define("GRR_FROM",getSettingValue("grr_mail_from"));
define("GRR_FROMNAME",getSettingValue("grr_mail_fromname"));

class my_phpmailer extends phpmailer
	{
		// Set default variables for all new objects

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = getSettingValue("grr_mail_smtp");
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username =  getSettingValue("grr_mail_Username");
//Password to use for SMTP authentication
$mail->Password = getSettingValue("grr_mail_Password");
//Set who the message is to be sent from
$mail->setFrom(GRR_FROM, GRR_FROMNAME);
}
?>