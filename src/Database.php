<?php

class Database {

    private $connection;

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

    // $params es un array asociativo con key = nombre del parametro en la sql y valor el valor a dar
    // El valor es un array con el valor propiamente dicho en el primer elemento y el tipo PDO en el
    // segundo

    public function query($sql, $params = null) {

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
            return false;
        }
    }

    // $params es un array asociativo con key = nombre del parametro en la sql y valor el valor a dar
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
            return false;
        }
    }

}
?>
