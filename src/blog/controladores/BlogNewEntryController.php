<?php

require_once("IController.php");

require_once(dirname(__FILE__) . "/../database/DAOBlogEntry.php");
require_once(dirname(__FILE__) . "/../modelos/BlogEntryModel.php");
require_once(dirname(__FILE__) . "/../vistas/BlogEntryEditorView.php");

/**
 * Controlador para la creacion de entradas de blog
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class BlogNewEntryController implements IController
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

    public function __construct()
    {
        // Obtenemos una referencia al DAO
        $this->dao = new DAOBlogEntry();
    }


    /**
     * Muestra la vista de edicion
     *
     * @param id
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

    private function showEditor()
    {
        $this->view = new BlogEntryEditorView();

        return $this->view->showEditor();
    }

        /**
     * Muestra la vista de edicion con errores
     *
     * @param array errors Array con los errores a mostrar
     * @param array contents Array con el contenido del form
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category class
     *
     * @api
     */

    private function showFormWithErrors($errors, $contents)
    {
        $this->view = new BlogEntryEditorView();

        return $this->view->showEditorWithErrors($errors, $contents);
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
        return $this->showEditor();
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
        $errors = [];

        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];

        // Obtenemos el estado de la subida
        $status = $_FILES['imagen']['error'];

        // Si tenemos un error, volvemos a mostrar el form con los errores encontrados

        // Hacemos un backup de lo que ha enviado el usuario por si hay que retornarlo a la vista
        $content['titulo'] = $titulo;
        $content['contenido'] = $contenido;
        $content['imagen'] = $_FILES['imagen']['name'];

        switch ($status) {
           case UPLOAD_ERR_INI_SIZE:
               $errors[] = "Tamaño de imagen excedido";
               return $this->showFormWithErrors($errors, $content);
           case UPLOAD_ERR_NO_FILE:
               $errors[] = "Debe dar una imagen";
               return $this->showFormWithErrors($errors, $content);
           case UPLOAD_ERR_CANT_WRITE:
               $errors[] = "Error en el servidor: No se puede almacenar la imagen";
               return $this->showFormWithErrors($errors, $content);
        }

        $size = intval($_FILES['imagen']['size']);

        // No permitimos imagenes mayores de 5MB (Megabytes)
        if ($size > 5242880 ) {
               $errors[] = "La imagen no debe exceder los 5MB";
               return $this->showFormWithErrors($errors, $content);
        }

        // Hasta aqui no hay mayor problema
        // Obtenemos el hash md5 del fichero para usarlo como nombre unico
        $filehash =  hash("md5", file_get_contents($_FILES['imagen']['tmp_name']));
        @$extension = end(explode('.', $_FILES['imagen']['name']));
        $filename = $filehash . "." . $extension;

        // Si no existe la imagen la movemos a la carpeta
        if (!file_exists("../imagenes/" . $filename)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], dirname(__FILE__) . "/../../imagenes/" . $filename);
        }

        // Hasta aqui todo OK, guardamos el registro y retornamos a la vista de lista
        $entry = new BlogEntryModel();

        $entry->settitulo($titulo);
        $entry->setcontenido($contenido);
        $entry->setimagen($filename);

        try {
            $this->dao->create($entry);
            header("Location: ../blog");
        }
        catch (Exception $ex) {
            // Mostramos errores
            $errores[] = $ex->getMessage();
            $this->showFormWithErrors($errors, $content);
        }
    }

}
?>
