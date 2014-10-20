$(document).ready(function()
{
	$('a.popop[href^=#]').on('click', function()
	{
		var popID = $(this).attr('rel');
		var popURL = $(this).attr('href');
		var query = popURL.split('?');
		var dim = query[1].split('&');
		var popWidth = dim[0].split('=')[1];
		$('#' + popID).fadeIn().css({
			'width': Number(popWidth)
		})
		.prepend('');
		var popMargTop = ($('#' + popID).height() + 80) / 2;
		var popMargLeft = ($('#' + popID).width() + 80) / 2;
		$('#' + popID).css({
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		$('body').append('');
		$('#fade').css({
			'filter' : 'alpha(opacity=80)'
		}).fadeIn();
		return false;
	});
	$('body').on('click', 'a.close, #fade', function()
	{
		$('#fade , .popup_block').fadeOut(function()
		{
			$('#fade, a.close').remove();
		});
		return false;
	});
});
function request(id,day,month,year,currentPage,callback)
{
	document.getElementById('popup_name2').innerHTML="";
	var Id = id;
	var Day = day;
	var Month = month ;
	var Year = year ;
	var Page = currentPage ;
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			callback(xhr.responseText);
	};
	xhr.open("GET","edit_entry.php?id="+Id+"&day="+Day+"&month="+Month+"&year="+Year+"&page="+Page+"", true);
	xhr.send(null);
}
function readData(sData)
{
	document.getElementById('popup_name').innerHTML +='<a class=\"close\" href=\"#\" title=\"Fermeture\" ><img class=\"btn_close\" src=\"images/croix.jpeg\"/></a>'+sData + '<a class=\"close\" href=\"#\" title=\"Fermeture\" >Fermer </a></div> ';
}
