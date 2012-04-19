<?php
function Subcadena($cadena,$antes,$despues,$cuenta)
{
	if(!$cuenta)
		return false;
	
	$localizacion1 = $localizacion2 = 0;
	do
	{
		$localizacion1 = strpos($cadena,$antes,$localizacion1 + 1);
		if($localizacion1 == false)
			return false;
			
		$cuenta--;
	} while ($cuenta > 0);
	$localizacion2 = strpos($cadena, $despues, $localizacion1 + 1);
	if ($localizacion2 == false)
		return false;
	$localizacion1 += strlen($antes);
	return substr($cadena,$localizacion1,$localizacion2 - $localizacion1);
}
?>