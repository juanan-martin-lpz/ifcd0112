<?php

/**
 * Clase para almacenar los datos de conexion
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class DBConfig {

    private $host;
    private $user;
    private $password;
    private $database;

    /**
     * Construye la clase a partir de un fichero json
     *
     *
     * @param string $json El fichero donde esta la configuracion
     *
     * @api
     */

    public function __construct($json) {
        $json = json_decode(file_get_contents($json));

        $this->host = $json->host;
        $this->user = $json->user;
        $this->password = $json->password;
        $this->database = $json->database;
    }

    /**
     * Devuelve el host
     *
     * @return string Retorna el host
     *
     * @api
     */

    public function getHost() {
        return $this->host;
    }

    /**
     * Devuelve el usuario
     *
     * @return string Retorna el usuario
     *
     * @api
     */

    public function getUser() {
        return $this->user;
    }

    /**
     * Devuelve el password
     *
     * @return string Retorna el password
     *
     * @api
     */

    public function getPassword() {
        return $this->password;
    }

    /**
     * Devuelve el nombre de la base de datos
     *
     * @return string Retorna el nombre de la base de datos
     *
     * @api
     */

    public function getDatabase() {
        return $this->database;
    }

}
?>
