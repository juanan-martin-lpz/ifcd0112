<?php

require_once (dirname(__FILE__) . '/../modelos/BlogEntryModel.php');

/**
 * Clase vista para el visualizador de lista de entradas de blog
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class BlogEntriesListView
{

    private $dataset;
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
        $html = file_get_contents(dirname(__FILE__) . "/html/BlogEntriesList.html");

        $this->dom = new \DOMDocument();
        @$this->dom->loadHTML($html);
    }

    /**
     * Muestra la vista de lista de entradas del blog
     *
     * @param Array entries Array con las entradas de blog con tipo BlogEntryModel
     *
     * @return string El html de la vista
     *
     * @api
     */

	public function showList($entries)
	{
        @$body = &$this->dom->getElementById("lista");

        foreach($entries as $entry) {

            // Creamos una tag p
            $p = $this->dom->createElement("p");

            $dots = "";

            if (strlen($entry->getcontenido()) > 500 ) {
                $dots = "......";
            }

            $contenido = $this->dom->createTextNode(substr($entry->getcontenido(), 0, 100) . $dots);
            $p->appendChild($contenido);

            $pfecha = $this->dom->createElement("p");

            $f = new DateTime($entry->getfecha());

            $fecha= $this->dom->createTextNode("Fecha : " . $f->format('d/m/Y'));
            $fecha->appendChild($fecha);
            $pfecha->appendChild($fecha);

            $per1 = $this->dom->createElement("div");
            $per2 = $this->dom->createElement("div");

            $per1->setAttribute("class", "persiana");
            $per2->setAttribute("class", "persiana2");

            $per2->appendChild($p);
            $per1->appendChild($pfecha);
 
            // Creamos una tag h3
            $h3 = $this->dom->createElement("h3");
            $titulo = $this->dom->createTextNode($entry->gettitulo());

            // Creamos un img
            //$img = $this->dom->createElement("img");

            //$img->setAttribute("class", "thumbnail");
            //$img->setAttribute("src", "/imagenes/" . $entry->getimagen());


            $h3->appendChild($titulo);

            // Creamos una tag div. Se le añade una class="card"
            $div = $this->dom->createElement("article");
            $div->setAttribute("class", "card blog-contenedor");
            $div->setAttribute("style", "background-image: url('/imagenes/" . $entry->getimagen() .  "'); background-cover: cover; background-repeat: no-repeat; background-position: center center");

            //$div->appendChild($img);
            $div->appendChild($h3);
            //$div->appendChild($p);
            $div->appendChild($per1);
            $div->appendChild($per2);

            // Creamos una tag a. El href es /blog/view/<id>
            $a = $this->dom->createElement("a");
            $a->setAttribute("href", "/blog/view/" . $entry->getid());

            $a->appendChild($div);

            // Lo añadimos donde corresponda
            $body->appendChild($a);
        }

        $html = $this->dom->saveHTML();

        return $html;
	}

}
?>
