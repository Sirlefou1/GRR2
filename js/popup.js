$(document).ready(function()
{
	$('a.poplight[href^=#]').on('click', function()
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
	$('body').on('click', 'a.closepop, #fade', function()
	{
		$('#fade , .popup_block').fadeOut(function()
		{
			$('#fade, a.closepop').remove();
		});
		return false;
	});
	$('body').on('click', 'input.closepop, #fade', function()
	{
		$('#fade , .popup_block').fadeOut(function()
		{
			$('#fade, input.closepop').remove();
		});
		return false;
	});
});
function request(id,day,month,year,currentPage,callback)
{
	document.getElementById('popup_name').innerHTML="";
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
	xhr.overrideMimeType('text/html; charset=UTF-8');
	xhr.open("GET","view_entry.php?id="+Id+"&day="+Day+"&month="+Month+"&year="+Year+"&page="+Page+"", true);
	xhr.send(null);
}
function readData(sData)
{
	document.getElementById('popup_name').innerHTML +='<a class=\"closepop\" href=\"#\" title=\"Fermeture\" ><img class=\"btn_close\" src=\"images/croix.jpeg\"/></a>'+sData + '<input class=\"closepop btn btn-primary\" type=\"button\" onclick=\"location.href=\'#\'\" title=\"Fermeture\" value=\"Fermer\" ></div> ';
}
