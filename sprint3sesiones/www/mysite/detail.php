<?php
$db = mysqli_connect('172.16.0.2', 'root', '1234', 'mysitedb') or die('Fail');
?>
<html>

<body style="text-align: center;">
    <?php
    if (!isset($_GET['id'])) {
        die('No se ha especificado un pelicula');
    }
    $pelicula_id = $_GET['id'];
    $query = 'SELECT * FROM tpelicula WHERE id_pelicula=' . $pelicula_id;
    $result = mysqli_query($db, $query) or die('Query error');
    $only_row = mysqli_fetch_array($result);
    echo '<h1>' . $only_row['nombre'] . '</h1>';
    echo '<img src=" '.$only_row['url_imagen'].'"  width="80" height="120">';
    echo '<h2>' . $only_row['publicaación'] . '</h2>';
    ?>
    <h3>Comentarios:</h3>
    <ul>
        <?php
        $query2 = 'SELECT * FROM tcomentario c join tusuario u on u.id_usuario=c.id_usuario WHERE id_pelicula=' . $pelicula_id;
        $result2 = mysqli_query($db, $query2) or die('Query error');
        while ($row = mysqli_fetch_array($result2)) {
            echo '<li>'.$row['id_usuario'].' : '.$row['comentario'].' '.$row['fecha'].'</li>';
        }
        mysqli_close($db);
        ?>
    </ul>
    <p>Deja un nuevo comentario:</p>
	<form action="/comment.php" method="post">
		<textarea rows="4" cols="50" name="new_comment"></textarea><br>
		<input type="hidden" name="pelicula_id" value="<?php echo $pelicula_id; ?>">
		<input type="submit" value="Comentar">
	</form>
    <a href="/logout.php">Logout</a>
</body>

</html>