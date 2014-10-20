/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
/*-----MAJ Loïs THOMAS  --> Fichier permettant d'empêcher la selection pour un visiteur -----*/ 


function disableselect(e){
return false
}

function reEnable(){
return true
}
function selection(){
        //if IE4+
        document.onselectstart=new Function ("return false")

        //if NS6
        if (window.sidebar){
        document.onmousedown=disableselect
        document.onclick=reEnable
       } 
}     