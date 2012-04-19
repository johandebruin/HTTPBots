<?php
date_default_timezone_set('Europe/Madrid');

class WordpressBot 
{
	public $titulo;
	public $contenido;
	public $fecha;
	
	//Campos especiales
	private $tags;
	private $categorias;
	private $camposPersonalizados;
	
	function _construct($titulo, $contenido)
	{
		$this->titulo = $titulo;
		$this->contenido = $contenido;
		$this->categorias = array();
		$this->camposPersonalizados = array();
	}
	
	public function publicar()
	{
		//Comprobaciones
		if($this->fecha == null)
			$this->fecha = date('Y-m-d H:i:s');

		$post = array(
		  'post_category' => $this->categorias,
		  'post_content' => $this->contenido,
		  'post_date' => $this->fecha,
		  'post_status' => 'publish',
		  'post_title' => $this->titulo,
		  'tags_input' => $this->tags,
		);
		$id = wp_insert_post($post);
		
		//Ahora anadimos los campos personalizados
		foreach($camposPersonalizados as $value) {
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
		$this->categorias[] = $categoria;	
	}
	
	public static function obtenerIDCategoria($categoria)
	{
		 get_term_by('name', $categoria, 'term_id');
	}
	
	public static function insertarCategoria($categoria)
	{
		$my_cat = array('cat_name' => $categoria,
		 'category_description' => $categoria,
		 'category_nicename' => sanitize_title($categoria),
		 'category_parent' => '');

		// Create the category
		return wp_insert_category($my_cat);
	}
	
};
?>