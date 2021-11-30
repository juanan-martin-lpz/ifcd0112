<?php

require_once (dirname(__FILE__) . '/../modelos/BlogEntryModel.php');

/**
 * Clase vista para el visualizador de entradas de blog
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class BlogEntryView
{
    private $dom;

    /**
     * Contruye la instancia
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

    public function __construct() {

        // Cargamos la vista y creamos el dom
        $html = file_get_contents(dirname(__FILE__) . "/html/BlogEntry.html");

        $this->dom = new \DOMDocument();
        @$this->dom->loadHTML($html);
    }

    /**
     * Muestra el visualizador de entradas de blog
     *
     * @param BlogEntryModel $entry Los datos a mostrar
     *
     * @return string El html de la vista
     *
     * @api
     */

	public function showEntry($entry)
	{
        @$titulo = &$this->dom->getElementById("titulo");
        @$imagen = &$this->dom->getElementById("imagen");
        @$contenido = &$this->dom->getElementById("contenido");

        $titulo->textContent = $entry->gettitulo();
        $contenido->textContent = $entry->getcontenido();
        $imagen->setAttribute("src", "../../imagenes/" . $entry->getimagen());

        return $this->dom->saveHTML();
    }

}
?>
