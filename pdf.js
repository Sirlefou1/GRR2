/*
 *Fichier permettant l'ouverture d'un PopUP de la page view entry.php
 */



function generationpdf() {
         var doc = new jsPDF('p', 'in', 'letter');
         var source = document.getElementById('popup_name');
         var specialElementHandlers = {
             '#bypassme': function(element, renderer) {
                 return true;
                 alert("c'est instancié ! "); 
             }
         };

         doc.fromHTML(
             source, // HTML string or DOM elem ref.
             0.5,    // x coord
             0.5,    // y coord
             {
                 'width': 7.5, // max width of content on PDF
                 'elementHandlers': specialElementHandlers
             });
		 doc.output('dataurl');
        
    }





