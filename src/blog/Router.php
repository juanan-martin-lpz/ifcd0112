<?php

require_once(dirname(__FILE__) . "/controladores/BlogEntriesListController.php");
require_once(dirname(__FILE__) . "/controladores/BlogEntryController.php");
require_once(dirname(__FILE__) . "/controladores/BlogNewEntryController.php");


/**
 * Clase encargada de enrutar las peticiones a los controladores del blog
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class Router
{

	private $routes;

    private $list;
    private $entry;
    private $newentry;

    /**
     * Construye la clase
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

	function __construct()
	{
        // Creamos los controladores
        $this->list = new BlogEntriesListController();
        $this->entry = new BlogEntryController();
        $this->newentry = new BlogNewEntryController();

        // Creamos las rutas de la aplicacion
        $this->routes['/blog'] = $this->list;
        $this->routes['/blog/view'] = $this->entry;
        $this->routes['/blog/new'] = $this->newentry;

	}


    /**
     * Enruta al controlador necesario a partir de la URL
     *
     * Compara la ruta pasada con las almacenadas en la variable $routes y realiza la llamada oportuna al
     * controlador asignado, metodo doGet si la peticion es GET, doPost en caso contrario.
     * La comparacion la puede realizar de forma parcial, es decir, si la url no se encuentra en la
     * tabla de rutas, puede enrutar a una ruta que comience por el mismo valor, pasando el exceso de ruta
     * como parametros al controlador via body
     *
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
	 * @param array request La peticion http
     *
     * @api
     */

	public function route($request)
	{
        // Estrategia:
        // Si la ruta existe completa -> ejecutar el controlador
        // Si no existe completa buscar una clave que comience con la ruta
        // y si la hay llamar a dicho controlador.
        // La ruta que se incluira en la request sera de / para el match
        // y el resto de la ruta para el parcial

        $controller = null;

        // Si existe una ruta completa....
        $controller = @$this->routes[$request['url']];

        // Ruta parcial
        if (!$controller) {

            // Recorremos las rutas y miramos a ver si hay alguna que nos sirva
            foreach($this->routes as $route => $control) {

                if (str_starts_with($request['url'], $route)) {
                    // Match, habemus controlador
                    $controller = $control;
                    // La ruta esta al inicio, el resto es parametros
                    // Los separamos con split
                    $base = explode('/', $route);
                    $requested = explode('/',$request['url']);

                    $paramarray = [];

                    for($i = count($base); $i <= count($requested) -1; $i++) {
                        $paramarray[] = $requested[$i];
                    }

                    $request['params'] =  $paramarray; //substr($request['url'], strlen($route));
                }
            }

            // Si no ha encontrado nada, 404
            if (!$controller) {
                return "404";
            }
        }

        // Si llegados aqui no hay controller enviamos 404
        if (!$controller) {
            return  "404";
        }

        // Segun el metodo, llamamos al metodo controlador oportuno
        switch (strtoupper($request['method'])) {
        case 'GET':
            return $controller->doGet($request);
        case 'POST':
            return $controller->doPost($request);
        }

	}

}
?>
