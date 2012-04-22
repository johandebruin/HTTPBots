<?php
	
	class InsertarONLINEDOCUMENTALES_COM extends InsertarDocumental
	{		
		//Funcion que determina la naturaleza de este insertador
		protected function getProveedor()
		{
			return "www.onlinedocumentales.com";
		}
		
		protected function getTitulo()
		{
			$matriz = array();
			preg_match('~Documentales Online</a> &raquo; <a href="http://www.onlinedocumentales.com/\w+/">.*</a> &raquo; (.*)</span></li>~', $this->HTML, $matriz);
			return $matriz[1];
		}
		
		protected function getTexto()
		{
			$matriz = array();
			preg_match('~news-id-.*\'><p>(.*)<br /><br />~', $this->HTML, $matriz);
			return $matriz[1];
		}
		
		protected function getImagen()
		{
			$matriz = array();
			preg_match_all('/<img[^>]+>/i', $this->HTML, $matriz);
			preg_match_all('/src="(.*)" title="Documental /', $matriz[0][1], $matriz);

			return $matriz[1][0];
		}
		
		protected function getCategorias()
		{
			$matriz = array();
			preg_match('~Documentales Online</a> &raquo; <a href="http://www.onlinedocumentales.com/\w+/">(.*)</a>~', $this->HTML, $matriz);
			return $matriz[1];
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