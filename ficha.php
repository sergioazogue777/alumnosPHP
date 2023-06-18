<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img{
            width:100px;
            height:100px;
        }
        td{
            width:200px;
            text-align:center;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        require 'usuario.php';
        $conec=new mysqli("127.0.0.1","root","","proyecto1eval");
        if($conec->connect_errno==0 && isset($_GET['id'])){
            $sql="select * from alumnos where id_alumno=".$_GET['id'];
            $sentencia=$conec->prepare($sql);
            $sentencia->execute();
            $resultado=$sentencia->get_result();
            if($datos=$resultado->fetch_assoc()){
                $id=$datos['id_alumno'];
                $dni=$datos['dni_alumno'];
                $nombre=$datos['nombre_alumno'];
                $direccion=$datos['direccion_alumno'];
                $poblacion=$datos['poblacion_alumno'];
                $creador=$datos['created_by'];
                $fecha=$datos['created_date'];
            }else{
                $id="";
                $dni="";
                $nombre="";
                $direccion="";
                $poblacion="";
                $creador="";
                $fecha="";
            }
        }else{
            $id="";
            $dni="";
            $nombre="";
            $direccion="";
            $poblacion="";
            $creador="";
            $fecha="";
        }
    ?>
    <form method="POST" enctype="multipart/form-data">
        <label>DNI:</label>
        <input type="text" name="dni" value="<?php echo $dni; ?>">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>">
        <br>
        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $direccion; ?>">
        <label>Población:</label>
        <input type="text" name="poblacion" value="<?php echo $poblacion; ?>">
        <br>
        <label>Foto:</label>
        <input type="file" name="foto">
        <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Dni</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Población</th>
            <th>Created by</th>
            <th>Created date</th>
            <th>Foto</th>
        </tr>
        <?php
            
            if(isset($_SESSION['usuario'])){
                if($conec->connect_errno==0){
                    if(isset($_GET['id'])){
                        echo '<input type="submit" name="accion" value="Grabar"> &nbsp<input type="submit" name="accion" value="Borrar"></form>';
                        echo '<tr><td>'.$id.'</td><td>'.$dni.'</td><td>'.$nombre.'</td><td>'.$direccion.'</td><td>'.$poblacion.'</td><td>'.$creador.'</td><td>'.$fecha.'</td><td><img src="http://localhost/azogue/proyecto1eval/fotos/'.$id.'.jpg"></td>';
                    }else{
                        echo '<input type="submit" name="accion" value="Crear"></form>';
                    }
                    if(isset($_POST['accion'])){
                        $sql="";
                       
                        if($_POST['accion']=='Grabar'){
                            $sql="update alumnos set dni_alumno='".$_POST['dni']."', nombre_alumno='".$_POST['nombre']."', direccion_alumno='".$_POST['direccion']."',poblacion_alumno='".$_POST['poblacion']."' where id_alumno=".$id;
                            $sentencia=$conec->prepare($sql);
                            $sentencia->execute();
                            if($_FILES){
                                move_uploaded_file($_FILES['foto']['tmp_name'],"./fotos/$id.jpg");
                            }
                        }
                        if($_POST['accion']=='Borrar'){
                            $sql="delete from alumnos where id_alumno=".$_GET['id'];
                            $sentencia=$conec->prepare($sql);
                            $sentencia->execute();
                        }
                        if($_POST['accion']=='Crear'){
                            $sql="insert into alumnos(dni_alumno,nombre_alumno,direccion_alumno,poblacion_alumno,created_by,created_date) values ('".$_POST['dni']."','".$_POST['nombre']."','".$_POST['direccion']."','".$_POST['poblacion']."','".$_SESSION['usuario']."','".date('Y-m-d')."')";
                            $sentencia=$conec->prepare($sql);
                            $sentencia->execute();
                            if($_FILES){
                                move_uploaded_file($_FILES['foto']['tmp_name'],"./fotos/$conec->insert_id.jpg");
                            }
                        }
                        header('Location: listado.php');
                    }
                }
            }else{
                header('Location: login.php');
            }
        ?>  
    </table>  
</body>
</html>