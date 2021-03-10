<?php
$nombres=$_POST['nombres'];
$apellidos=$_POST['apellidos'];
$email=$_POST['email'];
$password=$_POST['password'];
if(!empty($nombres)||!empty($apellidos)||!empty($email)||!empty($password)){
    $host="localhost";
    $dbusername="root";
    $dbpassword="1234";
    $dbname="design-form";
    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
    if(mysqli_connect_error()){
        die('connect error('.mysqli_connect_errno().')'.mysqli_connect_error());
    }else{
        $SELECT="SELECT email from usuario where email = ? limit 1";
        $INSERT="INSERT INTO usuario (nombres,apellidos,email,password) values (?,?,?,?)";

        $stmt = $conn->prepare($SELECT);
        $stmt ->bind_param("s", $email);
        $stmt ->execute();
        $stmt ->bind_result($email);
        $stmt ->store_result(); 
        $rnum = $stmt ->num_rows;
        if($rnum == 0){
            $stmt ->close();
            $stmt = $conn->prepare($INSERT);
            $stmt ->bind_param("ssss", $nombres,$apellidos,$email,$password);
            $stmt ->execute();
            echo "Registro completado.";
        }
        else{
            echo "Ya esta registrado el correo";
        }
        $stmt ->close();
        $conn ->close();
    }
}else{
    echo "todos los datos son obligatorios";
    die();
}


?>