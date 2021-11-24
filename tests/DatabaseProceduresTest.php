<?php

use PHPUnit\Framework\TestCase;

require(dirname(__FILE__) . "/../src/DatabaseProcedures.php");

class DatabaseProceduresTest extends TestCase
{
    /** @test */
    public function testConnect()
    {
        $dbConfig = new DBConfig( dirname(__FILE__) . '/config.json');

        $conexion = connect($dbConfig);

        $this->assertIsObject($conexion);

    }

    /** @test */
    public function testQueryNoConnection()
    {

        $conexion = null;
        $sql = "";

        try {
            query($conexion, $sql);
        }
        catch (Exception $ex) {
            $this->assertIsObject($ex);
        }
    }

    /** @test */
    public function testQueryNoSQL()
    {

        $dbConfig = new DBConfig( dirname(__FILE__) . '/config.json');

        $conexion = connect($dbConfig);

        $sql = "";

        try {
            query($conexion, $sql);
        }
        catch (Exception $ex) {
            $this->assertIsObject($ex);
        }

    }

    /** @test */
    public function testQueryFailed()
    {
        $dbConfig = new DBConfig( dirname(__FILE__) . '/config.json');

        $conexion = connect($dbConfig);

        $sql = "SELECT * FROM TRABAJOS WHERE idespecialidad = :espec";

        try {
            query($conexion, $sql);
        }
        catch (Exception $ex) {
            $this->assertIsObject($ex);
        }

    }

    /** @test */
    public function testQueryValid()
    {
        $dbConfig = new DBConfig( dirname(__FILE__) . '/config.json');

        $conexion = connect($dbConfig);

        $sql = "SELECT * FROM TRABAJOS WHERE idespecialidad = :espec";
        $params[':espec'] = [1, PDO::PARAM_INT];

        $result = query($conexion, $sql, $params);

        $this->assertIsArray($result);
    }
}
