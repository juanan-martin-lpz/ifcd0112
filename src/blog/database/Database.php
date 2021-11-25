<?php


/**
 * Clase para acceder a la base de datos via PDO
 *
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category class
 *
 *
 */

class Database {

    private $connection;    // Almacena la conexion

    /**
     * Construye la clase con la configuracion pasada
     *
     *
     * @param DBConfig $config Configuracion de la conexion
     *
     * @api
     */

    public function __construct(DBConfig $config) {

        $dsn = "mysql:dbname=" . $config->getDatabase() . ";host=" . $config->getHost();

        $this->connection = new PDO($dsn, $config->getUser(), $config->getPassword());

        if ($this->connection){
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        else {
            die ("Error al conectar a la base de datos");
        }
    }

    /**
     * Realiza una consulta a la base de datos
     *
     * Esta funcion se usar principalmente para consultas. Si se usa para otras sentencias DML, aunque ejecutar la sentencia, los resultados
     * seran incongruentes. Se aconseja para ello usar execute.
     *
     * @param string $sql La consulta a realizar
     * @param array $params Los parametros para la consulta
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category function
     *
     * @return array Retorna un array de objetos con los registros encontrados.
     *
     * @api
     */

    public function query($sql, $params = null) {

        // Si la conexion es invalida lanzamos una excepcion

        if ($this->connection == null) {
            throw new Exception("Conexion invalida");
        }

        // Si no hay sentencia SQLOA lanzamos una excepcion

        if ($sql == "") {
            throw new Exception("Consulta SQL invalida");
        }

        // Ejecutamos via prepare

        try {
            $stmt = $this->connection->prepare($sql);

            if ($params != null) {
                foreach($params as $k => $v) {
                    $stmt->bindParam($k, $v[0], $v[1]);
                }
            }

            $result = [];

            if ($stmt->execute()) {
                while($obj = $stmt->fetchObject())
                    array_push($result, $obj);
            }

            return $result;
        }
        catch (PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Realiza una sentencia DML contra la base de datos
     *
     * Esta funcion se usa principalmente para DML que no sean SELECT. Si se usa para SELECT esta funcion no retorna un dataset.
     * Se recomienda para ello usar la funcion query.
     *
     * @param string $sql La consulta a realizar
     * @param array $params Los parametros para la consulta
     *
     * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
     * @category function
     *
     * @return bool Retorna true si ha habido exito y false en caso contrario .
     *
     * @api
     */

    public function execute($sql, $params = null) {

        try {
            $stmt = $this->connection->prepare($sql);

            if ($params != null) {
                foreach($params as $k => $v) {
                    $stmt->bindParam($k, $v[0], $v[1]);
                }
            }

            if ($stmt->execute()) {
                return true;
            }
            else {
                return false;
            }

        }
        catch (PDOException $ex) {
            throw $ex;
        }
    }

}
?>
