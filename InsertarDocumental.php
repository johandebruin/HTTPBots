<?php

/***************************************************
	Falta hacer que se suba la imagen al servidor ","
*/
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
		
		//$this->HTML = utf8_encode($bot->get($this->URL));
		$this->HTML = $bot->get($this->URL);
		$this->titulo = $this->getTitulo();
		$this->limpiarTitulo();
		$this->imagen = $this->getImagen();
		$this->texto = $this->getTexto();
		$this->servidor = $this->getServidor();
		$this->tags = $this->getTags();
		$this->categorias = $this->getCategorias();

		//Ahora publicamos el documental <-)
		$wordpress = new WordpressBot($this->titulo,$this->texto);
		$wordpress->addCategoria($this->categorias);
		//El proveedor y la URL seran en todo caso obligatorios ademas del titulo y texto <)
		$wordpress->addCampoPersonalizado("Proveedor", $this->getProveedor());
		$wordpress->addCampoPersonalizado("URL", $this->URL);
		
		if($this->imagen != null) {
			$wordpress->addCampoPersonalizado("Imagen", $this->imagen);
		}
		if($this->servidor != null)
			$wordpress->addCampoPersonalizado("Servidor", $this->imagen);
		//Tags
		if(!empty($this->tags)) {
			foreach($this->tags as $value) {
				if(!$this->tagInvalido($value)) {
					if($value != null) {
						$wordpress->addTag($value);
					}
				}
			}
		}
		//Comprueba primero si ya existe el documental
		if($wordpress->obtenerIDEntrada($this->titulo) == null) {
			$wordpress->publicar();
		}
	}
	
	public function test()
	{
		$this->limpiarTitulo();
		echo "Titulo: " . $this->titulo . "<br />";
		echo "Imagen: " . $this->imagen . "<br />";
		echo "Texto: " . $this->texto . "<br />";
		echo "Categoria: ";
		echo "<pre>";
		print_r($this->categorias);
		print_r($this->tags);
		echo "</pre>";
	}
	
	public function limpiarTitulo() {
		$this->titulo = str_replace(" - Documentales Online","",$this->titulo);
	}
	
	public function tagInvalido($value) {
		$array = array(
			'socumental',
			'documentales gratis',
			'ver documentales',
			'documentales',
			'documental online',
			'documentales gratis',
			'documentales online',
			'ver documentales online',
			'ver documentales');
		if(in_array(strtolower($value),$array)) {
			return true;
		}
		return false;	
	}
}
?>