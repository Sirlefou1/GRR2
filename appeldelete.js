
// SCRIPTE JS/AJAX PERMETTANT D'APPELER LES SCRIPTS PHP SUPRIMANT ET REAFFICHANT LES FICHIERS LIES A 
// UNE RESERVATION 

    $(document).ready(function() {
        $(".deletefile").live('click',function(){
            var link = $(this).attr("href"); // On recupère le nom du fichier 
            var id = $(this).attr("value"); // On récupère l'id de la réservation	 	
            var answer = confirm("Voulez-vous reellement retirer "+link+"?")
            if (answer){
                $.ajax({
                    url: "deletefiles.php", // scripte de suppression 
                    type: "POST",
                    data: {
                        link:link // On envoie le nom du fichier au scripte php qui le suprimera 
                    },
                    success: function(data) {
                        if (data == "deleted") {
                            jQuery.ajax({
							type: 'GET', // pour recevoir du contenu html on utilise GET. 
							url: 'uploadify/affichagefile.php', // On utilise un fichier php pour réafficher 
							data: { 							// les fichiers liés. 
									 id: id // On transmet l'ID pour pouvoir faire notre reqête sql. 
								},
									success: function(returnData){
							$("#file").html(returnData); // On réaffiche nos fichiers lié dans la view_entry 
							},							// Le fichier supprimé a donc disparût de l'affichage 
							error: function(data){
							alert('Erreur lors de l execution de la commande AJAX pour le edit_entry_champs_add.php ');
							}
						});
                            return false; // Retourne faux pour ne pas que la redirection du lien se fasse
                        } else{
                            alert("Une erreur est survenue, veuillez réessayer");
                            return false;
                        }
                    }
                });
            }

            return false;
        });
    });

