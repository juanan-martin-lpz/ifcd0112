<?php

// require_once(dirname(__FILE__) . "../src/blog/controladores/BlogEntriesListController.php");

use PHPUnit\Framework\TestCase;

class BlogEntriesListControllerTest extends TestCase
{
    /** @test */
    public function testRouteValid()
    {

        $controller = new BlogEntriesListController();


        $this->assertEquals($controller->doGet(null), 'Hola desde el controlador');

    }
}
?>
