<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use PHPUnit\Framework\Assert as Assertions;

require_once(dirname(__FILE__) . "/../../src/blog/database/Database.php");
require_once(dirname(__FILE__) . "/../../src/blog/database/DBConfig.php");

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $response;
    private $html;
    private $client;

    private $multipart = [];

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => 'http://localhost:3210/']);
    }

    /**
     * @Given El servidor esta levantado
     */
    public function elServidorEstaLevantado()
    {
        $response = $this->client->request('GET', '/');

        Assertions::assertEquals('200', $response->getStatusCode());

    }

    /**
     * @When Accedor a \/blog
     */
    public function accedorABlog()
    {

        $this->response = $this->client->request('GET', '/blog');


        Assertions::assertEquals('200', $this->response->getStatusCode());

    }

    /**
     * @Then Obtengo una cadena con html
     */
    public function obtengoUnaCadenaConHtml()
    {
        $this->html = (string) $this->response->getBody();
    }

    /**
     * @Then Hay una etiqeuta h1 con el texto Blog
     */
    public function hayUnaEtiqeutaHConElTextoBlog()
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($this->html);

        $h1 = $dom->getElementsByTagName('h1')[0];

        Assertions::assertNotNull($h1);
        Assertions::assertEquals('Blog', $h1->nodeValue);
    }


    /**
     * @Given Tengo una o mas entradas en la url \/blog
     */
    public function tengoUnaOMasEntradasEnLaUrlBlog()
    {
        $this->response = $this->client->request('GET', '/blog');

        $this->html = (string) $this->response->getBody();

        $dom = new DOMDocument();
        @$dom->loadHTML($this->html);

        $entradas = $dom->getElementsByTagName('a');

        Assertions::assertGreaterThan(1, $entradas->count());

    }


    /**
     * @When Hago click en una de ellas
     */
    public function hagoClickEnUnaDeEllas()
    {
        $this->response = $this->client->request('GET', '/blog/view/1');

        $this->html = (string) $this->response->getBody();

        Assertions::assertIsString($this->html);

    }

    /**
     * @Then Me redirige a la vista de entrada para el id de la entrada clicada
     */
    public function meRedirigeALaVistaDeEntradaParaElIdDeLaEntradaClicada()
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($this->html);

        $main = $dom->getElementsByTagName('main')[0];

        Assertions::assertNotNull($main);

        Assertions::assertStringContainsString("entrymain", $main->getAttribute("class"));
    }


    /**
     * @Given Estoy en la url \/blog\/new
     */
    public function estoyEnLaUrlBlogNew()
    {
        $this->response = $this->client->request('GET', '/blog/new');

        Assertions::assertEquals('200', $this->response->getStatusCode());
    }

    /**
     * @When Inserto datos y una imagen inferior a 5MB
     */
    public function insertoDatosYUnaImagenInferiorAMb()
    {
        // Creamos el array con los campos
        $this->multipart[] = ['name' => 'titulo', 'contents' => 'Behat'];
        $this->multipart[] = ['name' => 'contenido', 'contents' => 'Behat generated content'];
        $this->multipart[] = ['name' => 'imagen', 'contents' => fopen(dirname(__FILE__) . "/../../src/imagenes/imagen04.jpg", 'r')];

        Assertions::assertIsArray($this->multipart);
    }

    /**
     * @When Hago click en el boton etiquetado con Guardar
     */
    public function hagoClickEnElBotonEtiquetadoConGuardar()
    {
        $this->response = $this->client->request('POST', '/blog/new', [
            'multipart' => $this->multipart
        ]);

        $this->html = (string) $this->response->getBody();

        $dom = new DOMDocument();
        @$dom->loadHTML($this->html);

        $h3 = $dom->getElementById('errores');

        Assertions::assertNull($h3);

        Assertions::assertEquals($this->response->getStatusCode(), '200');
    }

    /**
     * @Then Me redirige a la url \/blog
     */
    public function meRedirigeALaUrlBlog()
    {
        $this->html = (string) $this->response->getBody();

        $dom = new DOMDocument();
        @$dom->loadHTML($this->html);

        $h1 = $dom->getElementsByTagName('h1')[0];

        Assertions::assertNotNull($h1);
        Assertions::assertEquals('Blog', $h1->nodeValue);

    }

    /**
     * @Then Existe en la tabla blog de la base de datos un registro con los datos introducidos
     */
    public function existeEnLaTablaBlogDeLaBaseDeDatosUnRegistroConLosDatosIntroducidos()
    {
        $dbconfig = new DBConfig(dirname(__FILE__) . "/../../src/config/config.json");

        $db = new Database($dbconfig);

        try {
            $sql = "SELECT * FROM BLOG WHERE titulo = 'Behat'";

            $result = $db->query($sql);

            Assertions::assertGreaterThan(0, count($result));
        }
        catch(PDOException $ex) {
            throw $ex;
        }
    }
}
