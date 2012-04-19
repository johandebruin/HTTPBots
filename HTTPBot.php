<?php
class Curlbot
{
	public $encabezado = array();
 
	public $galleta;
 
	//Cambiar a false en caso de que no se quiera redireccionar
	private $redireccionar;
 
	//Definimos como deben establecerse los atributos
	function __set($name,$value)
	{
		if($name == "galleta")
			if(is_file($value))
				$this->$name = $value;
			else
			{
				fclose(fopen($value,'w'));
				$this->galleta = $value;
			}
		if($name == "encabezado")
			$this->encabezado[] = $value;
	}
 
	public function __construct()
		{ $this->redireccionar = true; }
 
	//Envia una solicitud get y devuelve la pagina obtenida
		///Param{$url}: url de la pagina que queramos obtener
	public function get($url)
	{
		$c = curl_init($url);
		if (count($this->encabezado) > 0)
			curl_setopt($c, CURLOPT_HTTPHEADER, $this->encabezado);
		if ($this->galleta != null)
		{
			curl_setopt($c, CURLOPT_COOKIEJAR, $this->galleta);
			curl_setopt($c, CURLOPT_COOKIEFILE, $this->galleta); 
		}
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, $this->redireccionar);
		//Enviamos la petición
		$respuesta = curl_exec($c);
		curl_close($c);
		return $respuesta;
	}
 
	//Envia una solicitud post y devuelve la pagina obtenida
		//Param{$url}: dirección de la pagina que solicitamos el post
		//Param{$campos}: mensaje del post que queramos enviar, ejemplo:
			//"user=usuario&pass=contraseña"
	public function post($url,$campos)
	{
		$c = curl_init($url);
		if (count($this->encabezado) > 0)
			curl_setopt($c, CURLOPT_HTTPHEADER, $this->encabezado);
		if ($this->galleta != null)
		{
			curl_setopt($c, CURLOPT_COOKIEJAR, $this->galleta);
			curl_setopt($c, CURLOPT_COOKIEFILE, $this->galleta); 
		}
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $campos);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, $this->redireccionar);
		//Enviamos la petición
		$respuesta = curl_exec($c);
		curl_close($c);
		return $respuesta;
	}
};
?>