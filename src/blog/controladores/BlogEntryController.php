<?php

require_once("IController.php");
require_once(dirname(__FILE__) . "/../database/DAOBlogEntry.php");
require_once(dirname(__FILE__) . "/../modelos/BlogEntryModel.php");
require_once(dirname(__FILE__) . "/../vistas/BlogEntryView.php");

/**
 * Controlador para una sola entrada de blog
 *
 * Aporta dos vistas segun los parametros pasados via body
 * new: Muestra la vista de edicion del blog
 * view: <valor> Muestra la vista de visualizacion de la entrada de blog identificado con <valor>
 * El resto de parametros son ignorados
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class BlogEntryController implements IController
{
    private $entry;
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

	function __construct()
	{
        // Obtenemos una referencia al DAO
        $this->dao = new DAOBlogEntry();
	}


    /**
     * Muestra la vista de visualizacion
     *
	 * @param id
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

	private function showEntry()
	{
        $this->view = new BlogEntryView();

        return $this->view->showEntry($this->entry);

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
        $id = $request['params'][0];

        // Obtener los datos de la base de datos
        $this->entry = $this->dao->findById($id);

        // retornar el dom
        return $this->showEntry();
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
