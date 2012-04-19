<?php
	
	class InsertarONLINEDOCUMENTALES_COM extends InsertarDocumental
	{
		const PRE_TITULO = '</a>';
		const POST_TITULO = '</span></li></h1>';
		
		const PRE_TEXTO = '<div id="news-id-';
		const POST_TEXTO = '<br><br></p>';
		
		const PRE_IMAGEN = '<img style="background: none repeat scroll 0pt 0pt rgb(204, 204, 204); margin: 1px; padding: 2px;" src="';
		const POST_IMAGEN = '" title="Documental online "';
		
		const PRE_CATEGORIA = '<span style="font-weight: bold;">Categoria: </span>';
		const POST_CATEGORIA = '<span style="font-weight: bold;">Autor:';
		
		//Funcion que determina la naturaleza de este insertador
		protected function getProveedor()
		{
			return "onlinedocumentales.com";
		}
		
		protected function getTitulo()
		{
			$matriz = array();
			preg_match('~Documentales Online</a> &raquo; <a href="http://www.onlinedocumentales.com/\w+/">.*</a> &raquo; (.*)</span></li>~',$this->HTML,$matriz);
			return $matriz[1];
		}
		
		protected function getTexto()
		{
			return Subcadena($this->HTML, PRE_TEXTO, POST_TEXTO, 0);
		}
		
		protected function getImagen()
		{
			return Subcadena($this->HTML, PRE_IMAGEN, POST_IMAGEN, 0);
		}
		
		protected function getCategorias()
		{
			$matrizCategorias = preg_split('[,]', Subcadena($this->HTML, PRE_CATEGORIA, POST_CATEGORIA, 0));
			foreach($matrizCategorias as $value) {
				$this->categorias[] = $value;	
			}
		}
		
		protected function getTags()
		{
			return null;	
		}
		
		protected function getServidor()
		{
			return null;	
		}
	}
?>