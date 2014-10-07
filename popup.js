/*
 *Fichier permettant l'ouverture d'un PopUP de la page view entry.php
 */
//<script src="jquery-1.8.3.min.js"></script>
//<script type="text/javascript" src="/uploadify/jquery.uploadify.js"></script>


//<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

//Création du popup
$(document).ready(function() {
    //Lorsque vous cliquez sur un lien de la classe poplight et que le href commence par #

    $('a.poplight[href^=#]').click(function() {
        var popID = $(this).attr('rel'); //Trouver la pop-up correspondante
        var popURL = $(this).attr('href'); //Retrouver la largeur dans le href

        //Récupérer les variables depuis le lien
        var query= popURL.split('?');
        var dim= query[1].split('&');
        var popWidth = dim[0].split('=')[1]; //La première valeur du lien

        //Faire apparaitre la pop-up et ajouter le bouton de fermeture
        $('#' + popID).fadeIn().css({
            'width': Number(popWidth)
        })
        .prepend('');

        //Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
        var popMargTop = ($('#' + popID).height() + 80) / 2;
        var popMargLeft = ($('#' + popID).width() + 80) / 2;

        //On affecte le margin
        $('#' + popID).css({
            'margin-top' : -popMargTop,
            'margin-left' : -popMargLeft
        });

        //Effet fade-in du fond opaque
        $('body').append(''); //Ajout du fond opaque noir
        //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
        $('#fade').css({
            'filter' : 'alpha(opacity=80)'
        }).fadeIn();

        return false;
    });

    //Fermeture de la pop-up et du fond
    $('a.close, #fade').live('click', function() { //Au clic sur le bouton ou sur le calque...
        $('#fade , .popup_block').fadeOut(function() {
            $('#fade, a.close');  //...ils disparaissent ensemble
        });
        return false;
    });
});


function request(id,day,month,year,currentPage,callback) {
     document.getElementById('popup_name').innerHTML="";
    var Id = id;
    var Day = day;
    var Month = month ;
    var Year = year ;
    var Page = currentPage ;

    var xhr = getXMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };


    xhr.open("GET","view_entry.php?id="+Id+"&day="+Day+"&month="+Month+"&year="+Year+"&page="+Page+"", true);
    xhr.send(null);

}
function readData(sData) {
    document.getElementById('popup_name').innerHTML +='<a class=\"close\" href=\"#\" title=\"Fermeture\" ><img class=\"btn_close\" src=\"images/croix.jpeg\"/></a>'+sData + '<a class=\"close\" href=\"#\" title=\"Fermeture\" >Fermer </a></div> ';
}





