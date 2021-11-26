<?php

//require "DatabaseProcedures.php";
//require "DBConfig.php";

/**
 * Recupera todos los trabajos segun la sql pasada
 *
 * La query viene montada de la vista al tener un elemento de filtron vinculado a la vista
 *
 * @param string $sql La query a ejecutar
 * @param array $params Los parametros de la busqueda
 *
 * @return array Retorna un array con los registros encontrados
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category function
 *
 * @api
 */

function seleccionarTrabajos($sql, $params) {

    // Configuramos el acceso a datos
    $config = new DBConfig( dirname(__FILE__) . '/config/config.json');

    $conexion = connect($config);

    try {
        return query($conexion, $sql, $params);
    }
    catch(PDOException $ex) {
        throw $ex;
    }

}

/**
 * Recupera todas las especialidades
 *
 * @return array Retorna un array con las especialidades encontradas
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category function
 *
 * @api
 */

function seleccionarEspecialidades() {

    // Configuramos el acceso a datos
    $config = new DBConfig( dirname(__FILE__) . '/config/config.json');

    $conexion = connect($config);

    return query($conexion, "SELECT * FROM ESPECIALIDADES");
}


/**
 * Inserta un trabajo en la tabla
 *
 *
 * @param int $anno Año
 * @param int $especialidad Especialidad
 * @param string $empresa Empresa
 * @param string $tareas Tareas
 * @param string $meritos Meritos
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category function
 *
 * @return int Retorna el resultado de la ejecucion
 *
 * @api
 */

function insertarTrabajo($anno, $especialidad, $empresa, $tareas, $meritos) {

    // Configuramos el acceso a datos
    $config = new DBConfig( dirname(__FILE__) . '/config/config.json');

    $conexion = connect($config);


    $sql = "INSERT INTO TRABAJOS (idespecialidad, anno, empresa, tareas, meritos) VALUES (:especialidad, :anno, :empresa, :tareas, :meritos)";

    $params[':especialidad'] = [$especialidad, PDO::PARAM_INT];
    $params[':anno'] = [$anno, PDO::PARAM_INT];
    $params[':empresa'] = [$empresa, PDO::PARAM_STR];
    $params[':tareas'] = [$tareas, PDO::PARAM_STR];
    $params['meritos'] = [$meritos, PDO::PARAM_STR];

    try {
        return execute($conexion, $sql, $params);
    }
    catch(PDOException $ex) {
        throw $ex;
    }

}
?>
