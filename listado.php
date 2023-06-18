<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{border: 1px solid black;}
        td{
            width:100px;
            text-align:center;
        }
    </style>
</head>
<body>
    <table>
    <form method="POST">
        <label>Buscar por nombre de usuario: &nbsp</labeL>
        <input type="text" name="nombre" placeholder="nombre.." <?php if(isset($_POST['nombre'])){echo 'value="'.$_POST['nombre'].'"';}?>>
        <input type="submit" value="Buscar">
        <br>
        <input type='submit' name='pagina' value='Atras'>&nbsp &nbsp
        <input type='submit' name='pagina' value='Siguiente'>
   
    <?php
    session_start();
        require 'usuario.php';
        
       
        if(isset($_SESSION['usuario'])){
            
            echo "<tr><th>DNI</th><th>Nombre</th><th>Ficha</th></tr>";
            $conec=new mysqli("127.0.0.1","root","","proyecto1eval");
                if($conec->connect_errno==0){
                    if(isset($_POST['pto'])){
                        $prim=$_POST['pto'];
                    }else{
                        $prim=0;
                    }
                    if(isset($_POST['pagina'])){
                        if($_POST['pagina']=="Siguiente"){
                            $prim=$prim+10;
                        }else if($_POST['pagina']=="Atras" && $prim-10>=0){
                            $prim=$prim-10;
                        }
                    }
                    if(isset($_POST['nombre']) && $_POST['nombre']!=""){
                        $sql="select * from alumnos where nombre_alumno like '%".$_POST['nombre']."%' limit ".$prim.",".($prim+10);
                    }else{
                        $sql="select * from alumnos limit ".$prim.",".($prim+10);
                    }
                    $sentencia=$conec->prepare($sql);
                    $sentencia->execute();
                    $resultado=$sentencia->get_result();
                    while($dato=$resultado->fetch_assoc()){
                        echo "<tr><td>".$dato['dni_alumno']."</td><td>".$dato['nombre_alumno'].'</td><td><a href="ficha.php?id='.$dato['id_alumno'].'">ficha</a></td></tr>';
                    }
                }
            $sentencia->close();     
        }else{
            header('Location: login.php');
        }
    ?>
     <input type="hidden" name="pto" value="<?php echo $prim;?>">
    </form>
    </table>
</body>
</html>