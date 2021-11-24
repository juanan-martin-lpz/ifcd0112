<?php

/**
 * Realiza la conexion con una base de datos
 *
 *
 * @param DBConfig $config La configuracion de la base de datos
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category function
 *
 * @return PDO Retorna la conexion
 *
 * @api
 */

function connect(DBConfig $config) {

        $dsn = "mysql:dbname=" . $config->getDatabase() . ";host=" . $config->getHost();

        $connection = new PDO($dsn, $config->getUser(), $config->getPassword());

        if ($connection){
            $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $connection;
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
 * @param PDO $connection Una conexion con la base de datos
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

function query($connection, $sql, $params = null) {

    // Si la conexion es invalida lanzamos una excepcion

    if ($connection == null) {
        throw new Exception("Conexion invalida");
    }

    if ($sql == "") {
        throw new Exception("Consulta SQL invalida");
    }

    try {
        $stmt = $connection->prepare($sql);

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
 * @param PDO $connection Una conexion con la base de datos
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

function execute($connection, $sql, $params = null) {

    try {
        $stmt = $connection->prepare($sql);

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
?>
