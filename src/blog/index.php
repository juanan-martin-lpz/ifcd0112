<?php

require_once("Router.php");

// Instanciamos Router

$router = new Router();


// Preparamos la request


$request['method'] = $_SERVER['REQUEST_METHOD'];
$request['url'] = $_SERVER['REQUEST_URI'] ?? "/";
$request['query'] = $_SERVER['QUERY_STRING'] ?? "";

echo $request['url'];

// Despachamos y mostramos el resultado

echo $router->route($request);


?>
