<?php

require_once ('Database.php');
require_once ('DBConfig.php');
require_once (dirname(__FILE__) . '/../modelos/BlogEntryModel.php');


/**
 * Clase para acceder a los datos del blog
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */


class DAOBlogEntry extends Database
{
    private Database $db;
    private DBConfig $dbconfig;
    /**
     * Construimos el DAO
     *
     * @api
     */

    function __construct()
    {
        $this->dbconfig = new DBConfig(dirname(__FILE__) . '/../../config/config.json');
        $this->db = new Database($this->dbconfig);
    }

    /**
     * Crea un nuevo registro a partir del objeto pasado
     *
     * @param BlogEntryModel entry La entrada de blog a insertar
     *
     * @return bool true si tiene exito, false en caso contrario
     *
     * @api
     */

    public function create(BlogEntryModel $entry)
    {
        try {
            // Preparamos la DML
            $sql = "INSERT INTO BLOG (fecha, titulo, contenido, imagen ) VALUES (CURRENT_DATE(), :titulo, :contenido, :imagen)";

            $params[':titulo'] = [$entry->gettitulo(), PDO::PARAM_STR];
            $params[':contenido'] = [$entry->getcontenido(), PDO::PARAM_STR];
            $params[':imagen'] = [$entry->getimagen(), PDO::PARAM_STR];

            if (!$this->db->execute($sql, $params)) {
                throw new Exception("Error al actualizar la base de datos");
            }
        }
        catch( PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Recupera todos los regstros de la tabla
     *
     * @return array Array de BlogEntryModel con los registros
     *
     * @api
     */

    public function findAll()
    {
        $sql = "SELECT * FROM BLOG ORDER BY fecha DESC";

        $dataset = $this->db->query($sql);
        $result = [];

        foreach($dataset as $entry) {
            $entrymodel = new BlogEntryModel();
            $entrymodel->setid($entry->idblog);
            $entrymodel->setfecha($entry->fecha);
            $entrymodel->settitulo($entry->titulo);
            $entrymodel->setcontenido($entry->contenido);
            $entrymodel->setimagen($entry->imagen);

            $result[] = $entrymodel;
        }

        return $result;
    }

    /**
     * Recupera un determinado registro por idOB
     *
     * @param int id El id a buscar
     *
     * @return BlogEntryMode Un objeto del tipo BlogEntryModel o null
     *
     * @api
     */

    public function findById(int $id)
    {
        $sql = "SELECT * FROM BLOG WHERE idblog = $id";

        $dataset = $this->db->query($sql);
        $result = null;

        foreach($dataset as $entry) {
            $entrymodel = new BlogEntryModel();
            $entrymodel->setid($entry->idblog);
            $entrymodel->setfecha($entry->fecha);
            $entrymodel->settitulo($entry->titulo);
            $entrymodel->setcontenido($entry->contenido);
            $entrymodel->setimagen($entry->imagen);

            $result = $entrymodel;
        }

        return $result;

    }

}
?>
