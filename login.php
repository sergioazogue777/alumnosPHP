<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <label>E-mail:</label>
        <input type="email" name="email">
        <label>Contraseña:</label>
        <input type="password" name="contra">
        <input type="submit" value="Entrar">
    </form>
    <?php
    session_start();    
        require 'usuario.php';
        $conec=new mysqli("127.0.0.1","root","","proyecto1eval");
        if($conec->connect_errno==0 && $_POST){
            $sql="select * from usuario where correo_usuario='".$_POST['email']."'";
            $sentencia=$conec->prepare($sql);
            $sentencia->execute();
            $resultado=$sentencia->get_result();
            if($dato=$resultado->fetch_assoc()){
                if(password_verify($_POST['contra'],$dato['contrasenya_usuario'])){
                    $_SESSION['usuario']=$dato['nombre_usuario'];
                    header('Location: listado.php');
                }else{
                    echo "<br>Contraseña incorrecta";
                }
            }else{
                echo "Usuario no encontrado";
            } 
        }
    ?>
</body>
</html>