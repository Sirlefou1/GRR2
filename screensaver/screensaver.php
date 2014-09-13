<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/2000/svg">
	<head>
	<title>mKiosk - ScreenSaver</title>
	<style>

	</style>
	<script type="text/javascript">
		var clock = {
			strings:null, //Traducao
			r : null,	//Reg
			g : null, 	//Green
			b : null,	//Blue
			rd: null,	//Red Delta
			gd: null,	//Green Delta
			bd: null,	//Blue Delta
			rs:null,	//Red Signal
			gs: null,	//Green Signal
			bs: null,	//Blue Signal
			vmin: null,	//Variacao delta na cor min
			vmax: null,	//Variacao delta na cor max
			dmin: null, //Variacao no delay min
			dmax: null, //Variacao no delay max
			initScreenSaver : function() {
				// window.alert(window.location.search.substring(1));
				//Variacao maxima das cores
				this.vmin = 0; 				this.vmax=3;
				//Variacao no delay de mudanca
				this.dmin = 350;			this.dmax=500;
				//Numeros iniciais para a cor de fundo
				this.r = (0 + Math.floor(Math.random() * (255 - 0 + 1) ));
				this.g = (0 + Math.floor(Math.random() * (255 - 0 + 1) ));
				this.b = (0 + Math.floor(Math.random() * (255 - 0 + 1) ));
				//Numeros iniciais randomicos para incremento ou decremento
				this.rd = (this.vmin + Math.floor(Math.random() * (this.vmax - this.vmin + 1) ));
				this.gd = (this.vmin + Math.floor(Math.random() * (this.vmax - this.vmin + 1) ));
				this.bd = (this.vmin + Math.floor(Math.random() * (this.vmax - this.vmin + 1) ));
				//Sinais iniciais randomicos (sempre tem de ser -1 ou +1). Definido apenas no inicio de cada screensaver
				if (this.rd > Math.floor((this.vmax - this.vmin) / 2)) { this.rs = 1; } else { this.rs = -1; }
				if (this.gd > Math.floor((this.vmax - this.vmin) / 2)) { this.gs = 1; } else { this.gs = -1; }
				if (this.bd > Math.floor((this.vmax - this.vmin) / 2)) { this.bs = 1; } else { this.bs = -1; }
				//Ativa screensaver j!
				clock.clockScreen();
				//Seta intervalo de delay
				setInterval('clock.clockScreen()', (this.dmin + Math.floor(Math.random() * (this.dmax - this.dmin + 1) )));
			},
			clockScreen : function () {
				//document.body.style.backgroundImage = "images/bg640x480.gif";

				//Calculo do novo valor
				this.rd = (this.vmin + Math.floor(Math.random() * (this.vmax - this.vmin + 1) ));		this.r += (this.rd * this.rs);
				this.gd = (this.vmin + Math.floor(Math.random() * (this.vmax - this.vmin + 1) ));		this.g += (this.gd * this.gs);
				this.bd = (this.vmin + Math.floor(Math.random() * (this.vmax - this.vmin + 1) )); 		this.b += (this.bd * this.bs);

				//Limite inferior = 0
				if (this.r > 255) { this.rs = -1; this.r = 255 - (this.r - 255); }
				if (this.g > 255) { this.gs = -1; this.g = 255 - (this.g - 255); }
				if (this.b > 255) { this.bs = -1; this.b = 255 - (this.b - 255); }

				//Limite Superior = 255
				if (this.r < 0)   { this.rs = +1; this.r *= -1; }
				if (this.g < 0)   { this.gs = +1; this.g *= -1; }
				if (this.b < 0)   { this.bs = +1; this.b *= -1; }

				//Inverso
				var f = Math.floor(255 - ((this.r + this.g + this.b) / 3));

				//Mudanca no fundo e cor
				document.getElementById('area').style.color   = ('rgb(' + f.toString() + ',' + f.toString() + ',' + f.toString() + ')');
				document.body.style.backgroundColor 		 = ('rgb(' + this.r.toString() + ',' + this.g.toString() + ',' + this.b.toString() + ')');
			}
		}
	</script>
	</head>
	<body id="screenbody" style="position:absolute; z-index:0; border:0px solid black; top:1px; bottom:1px; left:1px; right:1px; background-color:black;"
		  onLoad="return clock.initScreenSaver();"
	>
		<!-- background-image: -moz-linear-gradient(left, red, orange, yellow, green, blue, indigo, violet); -->
		<div id="border" style="display: table; height: 100%; width:100%; overflow: hidden;">
			<div id="area" style="display: table-cell; vertical-align: middle; color:white;" >
				<marquee behavior="alternate" scrollamount="1" direction="right" width="100%" height="100%">
					<font style="text-decoration:inherit; font-size:200%; font-weight: bold; font-variant:small-caps;">
						<p style="text-shadow: 1px 1px 2px black, 0 0 1em white, 0 0 0.2em white;">
							<?php

							$tab = array();

							$monfichier = 'message.txt';

if (isset($_POST['editeur']))
{
$tab['1'] = $_POST['editeur'];
file_put_contents($monfichier, serialize($tab));
//lecture du fichier
$lecture_fichier = file_get_contents($monfichier);

// récupère la structure du tableau
$tab_recup = unserialize($lecture_fichier);

echo isset($tab_recup['1']) ? $tab_recup['1'] : '';
}

else
{
//lecture du fichier
$lecture_fichier = file_get_contents($monfichier);

// récupère la structure du tableau
$tab_recup = unserialize($lecture_fichier);

echo isset($tab_recup['1']) ? $tab_recup['1'] : '';
}


 ?>
						<script type="text/javascript">
							var strmarquee = unescape(window.location.search.substring(1));
							if (strmarquee == "") strmarquee = "";
							document.write(strmarquee); //window.location.search.substring(1).split("&");
						</script>
						</p>
					</font>
				</marquee>
			</div>
		</div>
	</body>
</html>
