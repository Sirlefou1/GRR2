<?php

$vacances = simplexml_load_file('http://telechargement.index-education.com/vacances.xml');
$libelle = $vacances->libelles->children();
$node = $vacances->calendrier->children();
$now = '1414662548';
foreach ($node as $key => $value)
{
	if ($value['libelle'] == 'A')
	{
		foreach ($value->vacances as $key => $value)
		{
			$year = date('Y', strtotime($value['debut']));
			if ($year >= '2014')
			{
				if (strtotime($value['debut']) <= $now && $now <= strtotime($value['fin']))
				{
					$nom = (int)$value['libelle'];
					echo '<pre>';
					echo $libelle->libelle[$nom - 1];
					echo '</pre>';
				}

			}
		}
	}
}
?>
