<?php
date_default_timezone_set('Europe/Madrid');

class WordpressBot 
{
	public $titulo;
	public $contenido;
	public $fecha;
	public $comprobarTitulo = true;
	
	//Campos especiales
	private $tags;
	private $categorias;
	private $camposPersonalizados;
	
	function __construct($titulo, $contenido)
	{
		$this->titulo = $titulo;
		$this->contenido = $contenido;
		$this->categorias = array();
		$this->camposPersonalizados = array();
	}
	
	/**
		La funcion definitiva para publicar!
	*/
	public function publicar()
	{
		global $wpdb;
		
		//Comprobaciones
		if($this->fecha == null)
			$this->fecha = date('Y-m-d H:i:s');
		$post = array(
		  	'post_title' => $this->titulo,
		  	'post_content' => $this->contenido,
		  	'post_date' => $this->fecha,
		  	'post_status' => 'publish'
		);
		if($this->categorias != null)
			$post['post_category'] = $this->categorias;
		if($this->tags != null)
			$post['tags_input'] = $this->tags;
		//if( !$comprobarTitulo || !is_numeric(obtenerIDEntrada($this->titulo)) )
		echo "id: ".$id = wp_insert_post($post);
		//Ahora anadimos los campos personalizados
		foreach($this->camposPersonalizados as $value) {
			$datos = array(
				'meta_id' => null,
				'post_id' => $id,
				'meta_key' => $value[0],
				'meta_value' => $value[1]
			);
			$wpdb->insert('wp_postmeta', $datos);
		}
	}
	
	public function addCampoPersonalizado($nombre, $valor)
	{
		$this->camposPersonalizados[] = array($nombre, $valor);
	}
	
	public function addTag($etiqueta)
	{
		if($this->tags == null)
			$this->tags = $etiqueta;
		else
			$this->tags .= ",".$etiqueta;
	}
	
	public function addCategoria($categoria)
	{
		if(!is_numeric($categoria)) {
			$id = $this->obtenerIDCategoria($categoria);
			if($id == null)
				$categoria = $this->crearCategoria($categoria);
		}
		$this->categorias[] = $categoria;	
	}
	
	public function obtenerIDCategoria($categoria)
	{
		 get_term_by('name', $categoria, 'term_id');
	}
	
	public function crearCategoria($categoria)
	{
		return wp_create_category($categoria);
	}
	
	public function obtenerIDEntrada($titulo)
	{
		global $wpdb;
		return  $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '" . $titulo . "'" );
	}
	
};
?>