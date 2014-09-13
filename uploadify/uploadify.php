<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/



// Define a destination
$targetFolder = '/uploadify/files'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	$ext = strrchr($targetFile, '.'); //extension du fichier à uploader (.jpg, .png...)
	$nom = substr_replace($targetFile, '', -strlen($ext), strlen($ext));
	$nom = str_replace(' ','-',$nom); // Remplace les espaces par un tiret 
	$teampfile2 = $_FILES['Filedata']['name'];
	
	// Otenir le nom unique  complet du fichier pour l'envoyer dans la bdd 
	$ext2 = strrchr($teampfile2, '.');
	$nom2 = substr_replace($teampfile2, '', -strlen($ext), strlen($ext));
	$nom2 = str_replace(' ','-',$nom2); // Remplace les espaces par un tiret 
	$rand= rand(0,999); // Random pour rendre le nom de fichier unique , eviter les doublons 
	
	
	$pop=str_replace($_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'],'',$targetFile);
	move_uploaded_file($tempFile,utf8_encode($nom.$rand.$ext));
		
	// Inclusion des fichiers des conexion à la bdd , indispensable pour manipuler / envoyer des données via les fonction grr_sql	
	include "../include/connect.inc.php";
	include "../include/mysql.inc.php";
	include "../include/misc.inc.php";
	$id = $_POST['id'];
		
	$sql = "INSERT INTO ".TABLE_PREFIX."_files(id,nom,identry) VALUES('','".$nom2.$rand.$ext2."','".$id."')";
	grr_sql_command($sql);
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','pdf'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
	
	
	
}
?>
