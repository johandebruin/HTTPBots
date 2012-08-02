<?php
	
	class InsertarDOCUMANIATV_COM extends InsertarDocumental
	{		
		//Funcion que determina la naturaleza de este insertador
		protected function getProveedor()
		{
			return "www.documaniatv.com";
		}
		
		protected function getTitulo()
		{
			$matriz = array();
			preg_match('~<h2 class="h2_song">(.*)</h2>~', $this->HTML, $matriz);
			return $matriz[1];
		}
		
		protected function getTexto()
		{
			$matriz = array();
			preg_match('~<meta name="description" content="(.*)" />~', $this->HTML, $matriz);
			return $matriz[1];
		}
		
		protected function getImagen()
		{
			return null;
		}
		
		protected function getCategorias()
		{
			$matriz = array();
			preg_match_all('~<h2 class="h2_artist">Documental de (.*)</h2>~', $this->HTML, $matriz);
			return $matriz[1];
		}
		
		protected function getTags()
		{
			$matriz = array();
			preg_match('~<meta name="keywords" content="(.*)" />~', $this->HTML, $matriz);
			return split(",", $matriz[1]);
		}
		
		protected function getServidor()
		{
			return null;
		}
	}
?>