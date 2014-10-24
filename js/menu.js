$(document).ready(function()
{
	$("#open").click(function ()
	{
		var closed = $("div#panel").is(":hidden");
        if (closed)
            $("div#panel").show("slow");
        else
            $("div#panel").hide("slow");

        setCookie("open", closed, 365);
	});
	var openToggle = getCookie("open");
	if (openToggle == "true")
	{
		$("div#panel").show();
	}
	else
	{
		$("div#panel").hide();
	}
});


function setCookie(c_name, value, exdays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
	document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
	var i, x, y, ARRcookies = document.cookie.split(";");
	for (i = 0; i < ARRcookies.length; i++) {
		x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
		y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
		x = x.replace(/^\s+|\s+$/g, "");
		if (x == c_name) {
			return unescape(y);
		}
	}
}