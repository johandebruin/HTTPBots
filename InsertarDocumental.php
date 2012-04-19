<?php

abstract class InsertarDocumental
{
	protected $HTML;
	protected $URL;
	protected $titulo;
	protected $imagen;
	protected $texto;
	protected $servidor;
	protected $tags;
	protected $categorias;
	
	abstract protected function getTitulo();
	abstract protected function getTexto();
	abstract protected function getCategorias();
	abstract protected function getImagen();
	abstract protected function getServidor();
	abstract protected function getProveedor();
	abstract protected function getTags();
	
	function __construct($URL)
	{
		$this->URL = $URL;
		$bot = new Curlbot();
		
		$this->HTML = utf8_encode($bot->get($this->URL));
		$this->titulo = $this->getTitulo();
		$this->imagen = $this->getImagen();
		$this->texto = $this->getImagen();
		$this->servidor = $this->getServidor();
		$this->tags = $this->getTags();
		$this->categorias = $this->getCategorias();
		
		//Ahora publicamos el documental <-)
		$wordpress = new WordpressBot($this->titulo,$this->texto);
		
		//El proveedor y la URL seran en todo caso obligatorios
		$wordpress->addCampoPersonalizado("Proveedor", $this->getProveedor());
		$wordpress->addCampoPersonalizado("URL", $this->URL);
		
		if($this->imagen != null)
			$wordpress->addCampoPersonalizado("Imagen", $this->imagen);
		if($this->servidor != null)
			$wordpress->addCampoPersonalizado("Servidor", $this->imagen);
		//Tags
		if(!empty($this->tags)) {
			foreach($this->tags as $value) {
				$wordpress->addTag($value);
			}
		}
		//Categorias
		
		//$wordpress->publicar();
	}
	
	public function test()
	{
		echo "Titulo: " . $this->titulo . "<br />";
		echo "Imagen: " . $this->imagen . "<br />";
		echo "Texto: " . $this->texto . "<br />";
	}
}

?>