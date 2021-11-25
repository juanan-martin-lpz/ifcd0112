<?php

require_once("IController.php");
require_once(dirname(__FILE__) . "/../database/DAOBlogEntry.php");
require_once(dirname(__FILE__) . "/../modelos/BlogEntryModel.php");
require_once(dirname(__FILE__) . "/../vistas/BlogEntriesListView.php");

/**
 * Controlador para todas la entradas de blog como lista
 *
 * Aporta una vista que mostrara todos los registros del blog
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class BlogEntriesListController implements IController
{
    private $dataset;
    private $dao;
    private $view;

    /**
     * Contruye la instancia
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

    public function __construct() {

        // Obtenemos una referencia al DAO
        $this->dao = new DAOBlogEntry();

    }

    /**
     * Muestra la vista de lista de entradas
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

    private function showList()
    {
        $this->view = new BlogEntriesListView($this->dataset);

        return $this->view->showList($this->dataset);
    }

    /**
     * Procesa las peticiones GET
     *
     * Segun el valor del parametro $request['params'] muestra una vista u otra
     *
	 * @param request
     *
     * @return string El html con la vista montada
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

    public function doGet($request)
    {
        // Obtener los datos de la base de datos
        $this->dataset = $this->dao->findAll();

        // retornar el dom
        return $this->showList();
    }

    /**
     * Procesa las peticiones POST
     *
     * Segun el valor del parametro $request['params'] muestra una vista u otra
     *
	 * @param request
     *
     * @return string El html de la vista ya montada
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

    public function doPost($request)
    {
    }

}
?>
