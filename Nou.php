<?php

require_once('Connexio.php');
require_once('Header.php');

/**
 * Nou
 * Clase con 2 métodos.
 * mostrarFormulari, se ocupa de generar un formulario HTML.
 * nouProducte, lleva a cabo la tarea de añadir el producto a la BBDD.
 */
class Nou
{
    public function mostrarFormulari()
    {
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Consulta para obtener la información del producto
        $consulta = "SELECT nom 
                     FROM categories";
        $resultado = $conexion->query($consulta);

        if ($resultado && $resultado->num_rows > 0) {
            $categoria = $resultado->fetch_assoc();
            echo '<!DOCTYPE html>
                  <html lang="es">
                  <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <title>Insertar producte</title>
                    <!-- Enlace a Bootstrap desde su repositorio remoto -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                  </head>
                  <body>
                    <div class="container mt-5" style="margin-bottom: 200px">
                        <h2>Insertar producte</h2>
                        <hr>
                        <!-- <form action="Actualitzar.php" method="POST"> -->
                        <form method="POST">
                            <!-- Campos del formulario con la información actual del producto -->
                            <!-- <input type="hidden" name="id"> -->

                            <div class="mb-3">
                                <label for="nom" class="form-label">Nombre:</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">Descripción:</label>
                                <input type="text" name="descripcio" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="preu" class="form-label">Precio:</label>
                                <input type="number" name="preu" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría:</label>
                                <select name="categoria" class="form-select" required>
                                    <!-- Opciones del selector de categorías con la opción seleccionada según la información actual -->
                                    <option value="1" ' . ($categoria['nom'] == 1 ? 'selected' : '') . '>Electrónicos</option>
                                    <option value="2" ' . ($categoria['nom'] == 2 ? 'selected' : '') . '>Roba</option>
                                    <!-- Agrega más opciones según sea necesario -->
                                </select>
                            </div>

                            <!-- Agrega más campos según sea necesario -->

                            <hr>
                            <!-- Botones de guardar y cancelar -->
                            <input type="submit" value="Guardar" class="btn btn-primary">
                            <a href="Principal.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>';

            // Incluye el pie de página
            require_once('Footer.php');
        }
    }
    public function nouProducte()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
            $descripcio = isset($_POST['descripcio']) ? $_POST['descripcio'] : null;
            $preu = isset($_POST['preu']) ? $_POST['preu'] : null;
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
        }

        if (!isset($nom) || !isset($descripcio) || !isset($preu) || !isset($categoria)) {
            echo '<p>Se requieren todos los campos para insertar el producto.</p>';
            return;
        }

        // Crea una instancia de la clase de conexión
        $conexionObj = new Connexio();
        // Obtiene la conexión a la base de datos
        $conexion = $conexionObj->obtenirConnexio();

        // Escapa las variables para prevenir SQL injection
        $nom = $conexion->real_escape_string($nom);
        $descripcio = $conexion->real_escape_string($descripcio);
        $preu = $conexion->real_escape_string($preu);
        $categoria = $conexion->real_escape_string($categoria);

        // Construye la consulta SQL de actualización
        $consulta = "INSERT INTO productes (nom, descripció, preu, categoria_id)
                     VALUES ('$nom', '$descripcio', '$preu', '$categoria')";

        // Ejecuta la consulta y redirige a la página principal si tiene éxito
        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            // Muestra un mensaje de error si la consulta falla
            echo '<p>Error al insertar el producto: ' . $conexion->error . '</p>';
        }
    }
}

// Creem una instància de la classe Formulari
$formulari = new Nou();

// Mostrem el formulari
$formulari->mostrarFormulari();

// Agafem les dades enviades pel formulari
$formulari->nouProducte();