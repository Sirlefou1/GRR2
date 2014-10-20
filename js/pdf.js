/*
 *Fichier permettant l'ouverture d'un PopUP de la page view entry.php
 */
 function generationpdf()
 {
   var doc = new jsPDF('p', 'in', 'letter');
   var source = document.getElementById('popup_name');
   var specialElementHandlers = {
       '#bypassme': function(element, renderer)
       {
           return true;
           alert("c'est instancié ! ");
       }
   };
   doc.fromHTML(
       source,
       0.5,
       0.5,
       {
           'width': 7.5,
           'elementHandlers': specialElementHandlers
       });
   doc.output('dataurl');
}
