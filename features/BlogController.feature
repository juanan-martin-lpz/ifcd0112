Feature: Controlador de Blog
  Para poder operar con el blog
  Como usuario
  Necesito poder acceder a la url del blog

  Scenario: Acceder a la url /blog
    Given El servidor esta levantado
    When Accedor a /blog
    Then Obtengo una cadena con html
    And Hay una etiqeuta h1 con el texto Blog

  Scenario: Acceder al detalle de la entrada al hacer click en una de ellas
    Given Tengo una o mas entradas en la url /blog
    When Hago click en una de ellas
    Then Me redirige a la vista de entrada para el id de la entrada clicada

  Scenario: Guardar los datos del form de Nueva entrada
    Given Estoy en la url /blog/new
    When Inserto datos y una imagen inferior a 5MB
    And Hago click en el boton etiquetado con Guardar
    Then Me redirige a la url /blog
    And Existe en la tabla blog de la base de datos un registro con los datos introducidos
