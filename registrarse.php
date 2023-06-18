<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Registro</h2>
    <form method="POST">
        <label>Correo:</label>
        <input type="email" name="email">
        <label>Nombre:</label>
        <input type="text" name="nombre">
        <label>Contraseña:</label>
        <input type="password" name="contra">
        <input type="submit" value="Registrarse">
    </form>
    <?php  
        if($_POST){ 
            $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $nombre=filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
            $contra=password_hash(filter_var($_POST['contra'],FILTER_SANITIZE_STRING),PASSWORD_DEFAULT);
            $conec=new mysqli("127.0.0.1","root","","proyecto1eval");
            if($conec->connect_errno==0){
                $sql="insert into usuario(correo_usuario,nombre_usuario,contrasenya_usuario) values ('$email','$nombre','$contra')";
                if($conec->query($sql)){
                    echo "Registrado con exito.";
                }else{
                    echo "Error.";
                }
            } 
        }
    ?>
</body>
</html>