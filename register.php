<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoIdentificacion = htmlspecialchars($_POST['tipoIdentificacion']);
    $numeroIdentificacion = htmlspecialchars($_POST['numeroIdentificacion']);
    $nombres = htmlspecialchars($_POST['nombres']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $celular = htmlspecialchars($_POST['celular']);

    $errores = [];

    if (empty($tipoIdentificacion)) $errores[] = "El tipo de identificación es obligatorio.";
    if (!is_numeric($numeroIdentificacion)) $errores[] = "El número de identificación debe ser numérico.";
    if (empty($nombres)) $errores[] = "Los nombres son obligatorios.";
    if (empty($apellidos)) $errores[] = "Los apellidos son obligatorios.";
    if (!$email) $errores[] = "Ingrese un correo electrónico válido.";
    if (!is_numeric($celular)) $errores[] = "El número de celular debe ser numérico.";

    if (count($errores) > 0) {
        foreach ($errores as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        // Insertar datos en la base de datos
        $sql = "INSERT INTO personas (tipo_identificacion, numero_identificacion, nombres, apellidos, email, celular) 
                VALUES (:tipoIdentificacion, :numeroIdentificacion, :nombres, :apellidos, :email, :celular)";
        
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([
                ':tipoIdentificacion' => $tipoIdentificacion,
                ':numeroIdentificacion' => $numeroIdentificacion,
                ':nombres' => $nombres,
                ':apellidos' => $apellidos,
                ':email' => $email,
                ':celular' => $celular
            ]);
            echo "<p style='color: green;'>Registro exitoso.</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Error al registrar: " . $e->getMessage() . "</p>";
        }
    }
}
?>
