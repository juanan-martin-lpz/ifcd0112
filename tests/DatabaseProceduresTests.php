<?php

use PHPUnit\Framework\TestCase;

require("../src/DatabaseProcedures.php");
require("../src/DBConfig.php");

class DatabaseProceduresTests extends TestCase
{
    /** @test */
    public function testConnect()
    {
        $dbConfig = new DBConfig("../src/config.json");

        $conexion = connect($dbConfig);

        $this->assertIsObject($conexion);

    }
}
