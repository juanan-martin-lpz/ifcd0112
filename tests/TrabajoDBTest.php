<?php

use PHPUnit\Framework\TestCase;

require(dirname(__FILE__) . "/../src/trabajosdb.php");

class TrabajoDBTest extends TestCase
{


    /** @test */
    public function testSeleccionarTrabajosValid()
    {
        $sql = "SELECT * FROM TRABAJOS WHERE idespecialidad = :espec";
        $params[':espec'] = [1, PDO::PARAM_INT];

        $result = seleccionarTrabajos($sql, $params);

        $this->assertIsArray($result);
    }

    /** @test */
    public function testSeleccionarTrabajosInvalid()
    {
        $sql = "SELECT * FROM TRABAJOS WHERE idespecialidad = :espec";
        $params = null;

        try {
            $result = seleccionarTrabajos($sql, $params);
        }
        catch (Exception $ex) {
            $this->assertIsObject($ex);
        }
    }

    /** @test */
    public function testSeleccionarEspcialidadesValid()
    {
        $result = seleccionarEspecialidades();

        $this->assertIsArray($result);
    }

}
