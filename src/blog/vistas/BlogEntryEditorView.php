<?php

require_once(dirname(__FILE__) . "/../modelos/BlogEntryModel.php");

/**
 * Clase vista para el editor de entradas de blog
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class BlogEntryEditorView
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
        $html = file_get_contents(dirname(__FILE__) . "/html/BlogNew.html");

        $this->dom = new \DOMDocument();
        @$this->dom->loadHTML($html);
    }


    /**
     * Muestra el editor de entradas de blog
     *
     *
     * @return string El html de la vista
     *
     * @api
     */

	public function showEditor()
	{
        return $this->dom->saveHTML();
	}

    /**
     * Muestra el editor de entradas de blog con errores y los datos
     *
     * Este metodo se usa para enviar de vuelta al usuario el form, con los errores encontrados y los valores introducidos
     *
     *
     * @return string El html de la vista
     *
     * @api
     */

	public function showEditorWithErrors($errors, $content)
	{
        // Insertamos los errores
        @$errores = &$this->dom->getElementById('errores');

        foreach($errors as $error) {
            $h3 = $this->dom->createElement('h3');
            $texto = $this->dom->createTextNode($error);
            $h3->appendChild($texto);

            $errores->appendChild($h3);

        }

        // Insertamos el contenido
        $titulo = $this->dom->getElementById('titulo');
        $contenido = $this->dom->getElementById('contenido');

        $titulo->setAttribute("value", $content['titulo']);
        $contenido->nodeValue = $content['contenido'];

        return $this->dom->saveHTML();
	}

}
?>
