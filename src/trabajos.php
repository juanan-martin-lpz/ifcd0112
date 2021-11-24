<?php

/**
 * Muestra los trabajos residentes en la base de datos y permite la insercion de nuevos trabajos
 *
 * Para peticiones GET mostramos una tabla con los trabajos existentes, permitiendo su filtro por Especialidades.
 * Las peticiones POST se producen al pulsar el boton de Guardar del formulario de trabajos y provocara que el registro sea validado
 * y guardado en la base de datos, mostrando a continuacion los nuevos datos en la tabla.
 *
 * @author Juan Martin Lopez juanan.martin.lpz@gmail.com
 * @category function
 *
 */


require "trabajosdb.php";
require "DatabaseProcedures.php";
require "DBConfig.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {


    $file = "html/trabajos.html";

    $html = file_get_contents($file);

    // Mostramos la rejilla y el filtro

    @$id = intval($_GET['filtro']);

    // Cargamos el html


    // Obtenemos un DOM
    $dom = new DOMDocument();

    // Lo precedemos de @ porque no queremos que muestre ningun warning
    @$dom->loadHTML($html);

    // Cargamos las especialidades

    $filtro = $dom->getElementById('filtro');
    $especialidad = $dom->getElementById('especialidad');

    fillCombo($filtro, $dom, $id);
    fillCombo($especialidad, $dom, $id);

    // Por defecto nos traemos todos los trabajos

    $tablabody = $dom->getElementById("tablabody");

    $sql = "";
    $params = null;

    // Segun el filtro, asignamos la sql
    if (isset($_GET['filtro']) && $_GET['filtro'] > 0) {

        $params[':id'] = [$id, PDO::PARAM_INT];

        $sql = "SELECT A.idtrabajo, A.anno, B.descripcion, A.empresa, A.tareas, A.meritos FROM TRABAJOS A INNER JOIN ESPECIALIDADES B ON (B.idespecialidad = A.idespecialidad) WHERE B.idespecialidad = :id ORDER BY A.anno";
    }
    else {
        $sql = "SELECT A.idtrabajo, A.anno, B.descripcion, A.empresa, A.tareas, A.meritos FROM TRABAJOS A INNER JOIN ESPECIALIDADES B ON (B.idespecialidad = A.idespecialidad) ORDER BY A.anno";

    }

    $trabajos = seleccionarTrabajos($sql, $params);

    // Iteramos por cada trabajo y creamo una fila
    foreach($trabajos as $trabajo) {
        // creamos un fila
        $tr = $dom->createElement('tr');
        $tr->setAttribute('class', "row");

        // creamos los nodos de cada columna
        $idt = $dom->createElement('td');
        $ida = $dom->createElement('td');
        $esp = $dom->createElement('td');
        $emp = $dom->createElement('td');
        $tas = $dom->createElement('td');
        $mer = $dom->createElement('td');

        // creamos los textos de cada columna
        $idtt = $dom->createTextNode($trabajo->idtrabajo);
        $idat = $dom->createTextNode($trabajo->anno);
        $espt = $dom->createTextNode($trabajo->descripcion);
        $empt = $dom->createTextNode($trabajo->empresa);
        $tast = $dom->createTextNode($trabajo->tareas);
        $mert = $dom->createTextNode($trabajo->meritos);

        // añadimos los textos a cada columna
        $idt->appendChild($idtt);
        $ida->appendChild($idat);
        $esp->appendChild($espt);
        $emp->appendChild($empt);
        $tas->appendChild($tast);
        $mer->appendChild($mert);

        // Añadimos las columnas a la fila
        $tr->appendChild($idt);
        $tr->appendChild($ida);
        $tr->appendChild($esp);
        $tr->appendChild($emp);
        $tr->appendChild($tas);
        $tr->appendChild($mer);

        // Añadimos la fila al body de la tabla
        $tablabody->appendChild($tr);
    }


    // Mostramos el HTML
    echo $dom->saveHTML();
}


// Guardamos los registros
if ($method == "POST") {

    // Obtener los datos del form
    @$anno = intval($_POST['anno']);
    @$especialidad =intval($_POST['especialidad']);
    @$empresa = $_POST['empresa'];
    @$tareas = $_POST['tareas'];
    @$meritos = $_POST['meritos'];



    insertarTrabajo($anno, $especialidad, $empresa, $tareas, $meritos);

    header("Location: trabajos.php");

}



function showError($msges, $msgen) {
    global $lang;
    // Errores
    // Cargar el form de login y añadirle los errores al final via DOM
    $html = file_get_contents("html/register_" . $lang . ".html");

    // Obtenemos un DOM
    $dom = new DOMDocument();

    // Lo precedemos de @ porque no queremos que muestre ningun warning
    @$dom->loadHTML($html);

    // Obtenemos el body
    $body = $dom->getElementsByTagName('body')[0];

    $div = $dom->createElement('div');
    $div->setAttribute('class', "errores");

    $p = null;

    if ($lang = 'es') {
        $p = $dom->createElement('p', $msges);
    }
    else {
        $p = $dom->createElement('p', $msgen);
    }

    $p->setAttribute('class', 'error');

    $div->appendChild($p);
    $body->appendChild($div);

    $html = $dom->saveHTML();

    // Mostrar el dom modificado
    echo $html;

}

function fillCombo($combo, $dom, $id) {

    if ($combo) {

        $espec = seleccionarEspecialidades();

        foreach($espec as $espe) {
            $opt = $dom->createElement('option');
            $opt->setAttribute("value", $espe->idespecialidad);

            if ($espe->idespecialidad == $id) {
                $opt->setAttribute("selected", true);
            }

            $text = $dom->createTextNode($espe->descripcion);
            $opt->appendChild($text);
            $combo->appendChild($opt);
        }
    }
    else {
        die("Algo ha ido mal");
    }

}
?>
