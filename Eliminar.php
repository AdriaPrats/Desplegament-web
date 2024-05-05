<?php

require_once('Connexio.php');
class Eliminar
{
    public function eliminarProducte($id)
    {
        // Verifica si el ID del producto es válido
        if (!isset($id) || !is_numeric($id)) {
            echo '<p>ID de producto no válido.</p>';
            return;
        }

        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Consulta para obtener la información del producto
        $consulta = "DELETE FROM productes
                     WHERE id = " . $id;

        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            // Muestra un mensaje de error si la consulta falla
            echo '<p>Error al eliminar el producto: ' . $conexion->error . '</p>';
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
    }
}

// Obtiene el ID del producto de la variable GET
$idProducto = isset($_GET['id']) ? $_GET['id'] : null;

// Crea una instancia de la clase Modificar y llama al método mostrarFormulari
$eliminarProducto = new Eliminar();
$eliminarProducto->eliminarProducte($idProducto);