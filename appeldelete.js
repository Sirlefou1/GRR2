
// SCRIPTE JS/AJAX PERMETTANT D'APPELER LES SCRIPTS PHP SUPRIMANT ET REAFFICHANT LES FICHIERS LIES A
// UNE RESERVATION

$(document).ready(function() {
	$(".deletefile").live('click',function()
	{
		var link = $(this).attr("href");
		var id = $(this).attr("value");
		var answer = confirm("Voulez-vous reellement retirer "+link+"?")
		if (answer)
		{
			$.ajax(
			{
				url: "deletefiles.php",
				type: "POST",
				data:
				{
					link:link
				},
				success: function(data)
				{
					if (data == "deleted")
					{
						jQuery.ajax(
						{
						 type: 'GET',
						 url: 'uploadify/affichagefile.php',
						 data:
						 {
						  id: id
					  },
					  success: function(returnData)
					  {
						 $("#file").html(returnData);
					 },
					 error: function(data)
					 {
						 alert('Erreur lors de l execution de la commande AJAX pour le edit_entry_champs_add.php ');
					 }
				 });
						return false;
					}
					else
					{
						alert("Une erreur est survenue, veuillez réessayer");
						return false;
					}
				}
			});
}

return false;
});
});

