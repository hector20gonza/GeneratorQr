<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar QR</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Generar QR</h1>
        <form method="POST" action="QrGenerator.php">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" >

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" >

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" >

            <input type="submit" value="Generar QR">
        </form>

        
    </div>
</body>
</html>