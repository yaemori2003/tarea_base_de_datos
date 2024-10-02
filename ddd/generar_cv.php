<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $fecha_nacimiento =$_POST['fecha_nacimiento'];
    $ocupacion = $_POST['ocupacion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $nacionalidad = $_POST['nacionalidad'];
    $nivel_ingles = $_POST['nivel_ingles'];
    $lenguajes_programacion = $_POST['lenguajes_programacion'];
    $aptitudes = $_POST['aptitudes'];
    $seccion_habilidades = $_POST['seccion_habilidades'];
    $experiencia_laboral = $_POST['experiencia_laboral'];
    $formacion = $_POST['formacion'];
    $perfil = $_POST['perfil'];

    $sql = "INSERT INTO usuarios (nombre_apellidos, fecha_nacimiento, ocupacion, telefono, email, nacionalidad,  nivel_ingles, lenguajes_programacion, seccion_habilidades, perfil) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssssssss", $nombre, $fecha_nacimiento, $ocupacion, $telefono, $email, $nacionalidad, $nivel_ingles, $lenguajes_programacion, $seccion_habilidades, $perfil);

    if ($stmt->execute()) {
        echo " ";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $sql = "INSERT INTO aptitudes (aptitud) 
        VALUES (?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $aptitudes);

    if ($stmt->execute()) {
        echo " ";
    } else {
        echo "Error: " . $stmt->error;
    }

    $sql = "INSERT INTO experiencia (texto) 
        VALUES (?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $experiencia_laboral);

    if ($stmt->execute()) {
        echo " ";
    } else {
        echo "Error: " . $stmt->error;
    }

    $sql = "INSERT INTO formacion (texto) 
        VALUES (?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $formacion);

    if ($stmt->execute()) {
        echo " ";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<?php
require_once 'conexion.php';

$formaciones = [];
$experiencias = [];
$aptitudes = [];

$sql = "SELECT * FROM usuarios ORDER BY id DESC LIMIT 1";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No se encontraron datos.";
    exit;
}

$sql = "SELECT * FROM formacion ORDER BY id DESC";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
  while ($form_row = $result->fetch_assoc()) {
      $formaciones[] = $form_row;
  }
}

$sql = "SELECT * FROM experiencia ORDER BY id DESC";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
  while ($expe_row = $result->fetch_assoc()) {
    $experiencias[] = $expe_row;
  }
}

$sql = "SELECT * FROM aptitudes ORDER BY id DESC";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
  while ($apt_row = $result->fetch_assoc()) {
    $aptitudes[] = $apt_row;
  }
} 

$conexion->close();
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <link rel="stylesheet" type="text/css" href="styles2.css">
    <div class="contenedor">
        <div class="encabezado">
            <img src="imagenes/traje.png" alt="foto del perfil" class="foto-perfil">
            <div class="texto-encabezado">
                <h1><?php echo $row['nombre_apellidos']; ?></h1>
                <p><?php echo $row['ocupacion']; ?></p>
            </div>
        </div>
        
        <div class="contenido-principal">
            <div class="columna-izquierda">
                <section class="contacto">
                    <h2>Contacto</h2>   
                    <p><img src="imagenes/telefono.png" alt="Teléfono" class="icono"> <?php echo $row['telefono']; ?></p>
                    <p><img src="imagenes/carta.png" alt="Correo" class="icono"> <?php echo $row['email']; ?></p>
                    <p><img src="imagenes/ubicacion.png" alt="Ubicación" class="icono"> <?php echo $row['nacionalidad']; ?></p>
                </section>

                <section class="idiomas">
                    <h2>Idiomas</h2>
                    <ul>
                        <li>Español: Nativo</li>
                        <li>Inglés: <?php echo $row['nivel_ingles']; ?></li>
                    </ul>
                </section>

                <section class="aptitudes">
                    <h2>Aptitudes</h2>
                    <?php foreach ($aptitudes as $apti): ?>
                        <p><?php echo $apti['aptitud']; ?></p>
                    <?php endforeach; ?>
                </section>

                <section class="habilidades">
                    <h2>Habilidades</h2>
                    <li><?php echo $row['seccion_habilidades']; ?></li>
                </section>

                <section class="lenguajes">
                    <h2>Lenguajes de programación</h2>
                    <li><?php echo $row['lenguajes_programacion']; ?></li>
                </section>
            </div>

            <div class="columna-derecha">
                <section class="experiencia_laboral">
                    <h2>Experiencia Laboral</h2>
                    <?php foreach ($experiencias as $exp): ?>
                        <p><?php echo $exp['texto']; ?></p>
                    <?php endforeach; ?>
                </section>

                <section class="formacion">
                    <h2>Formación</h2>
                    <?php foreach ($formaciones as $form): ?>
                        <p><?php echo $form['texto']; ?></p>
                    <?php endforeach; ?>
                </section>

                <section class="perfil">
                    <h2>Perfil</h2>
                    <p><?php echo $row['perfil']; ?></p>
                </section>

            </div>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
