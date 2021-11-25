<?php

/**
 * Interface de soporte para los controladores
 *
 * Expone dos metodos, uno para el proceso de peticiones GET o otro para las peticiones POST
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

interface IController
{

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

	public function doGet(object $request);

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

	public function doPost(object $request);

}
?>
