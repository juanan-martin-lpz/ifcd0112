<?php

/**
 * Modelo de datos
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class BlogEntryModel
{

	private $id;
	private $fecha;
	private $titulo;
	private $contenido;
	private $imagen;


    /**
     * Getters
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

	public function getfecha()
	{
		return $this->fecha;
	}

    public function getid()
	{
		return $this->id;
	}

    public function getcontenido()
	{
		return $this->contenido;
	}

    public function gettitulo()
	{
		return $this->titulo;
	}

    public function getimagen()
	{
		return $this->imagen;
	}

    /**
     * Setters
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

	public function setfecha($newVal)
	{
		$this->fecha = $newVal;
	}


	public function setid($newVal)
	{
		$this->id = $newVal;
	}


	public function setcontenido($newVal)
	{
		$this->contenido = $newVal;
	}


	public function settitulo($newVal)
	{
		$this->titulo = $newVal;
	}


	public function setimagen($newVal)
	{
		$this->imagen = $newVal;
	}

}
?>
