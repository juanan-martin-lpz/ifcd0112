USE `CURSO`;


CREATE TABLE `ESPECIALIDADES` (
       `idespecialidad` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
       `descripcion` VARCHAR(25) NOT NULL
);


CREATE TABLE `TRABAJOS` (
       `idtrabajo` SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
       `idespecialidad` SMALLINT UNSIGNED NOT NULL,
       `anno` YEAR NOT NULL,
       `empresa` VARCHAR(25) NOT NULL,
       `tareas` VARCHAR(100) NOT NULL,
       `meritos` VARCHAR(100) NOT NULL,
       CONSTRAINT `fk_trabajos_especialidades` FOREIGN KEY (`idespecialidad`) REFERENCES `ESPECIALIDADES` (`idespecialidad`)
);


CREATE TABLE `BLOG` (
       `idblog` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
       `fecha` DATE NOT NULL,
       `titulo` VARCHAR(50) NOT NULL,
       `contenido` TEXT NOT NULL,
       `imagen` VARCHAR(255) NOT NULL
);


CREATE TABLE `COMENTARIOS_BLOG` (
       `idcomentario` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
       `idblog` INT UNSIGNED NOT NULL,
       `fecha` DATE NOT NULL,
       `comentario` TEXT NOT NULL,
       CONSTRAINT `fk_comentarios_blog` FOREIGN KEY (`idblog`) REFERENCES `BLOG` (`idblog`)
);

INSERT INTO ESPECIALIDADES (descripcion) VALUES ("Programacion"),("Diseño de Aplicaciones"),("Gestion de Proyectos");

INSERT INTO TRABAJOS
       (idespecialidad, anno, empresa, tareas, meritos)
VALUES
        (1, 1990, "En la primera", "Era un S34 de IBM", "Sobrevivir"),
        (1, 1992, "En la segunda", "Era un S38 de IBM", "Sobrevivir, juerga, cachondeo y sopa boba"),
        (2, 1994, "En la tercera", "Era para el gobierno", "Por fin senior"),
        (2, 1999, "Casi en casa", "Efecto 2000, Euro", "No haber matado a nadie en el proceso, Jefe de Proyectos"),
        (3, 2001, "Con un colega", "Jefe de Proyectos", "Ninguno, se me escapo vivo");
