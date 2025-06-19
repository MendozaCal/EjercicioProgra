<?php
header("Content-Type: application/json");
$mysqli = new mysqli("localhost","root","","Sem13Ejer1");
if($mysqli->connect_error)
{
    echo "error";
}
else
{
    $name=$_POST["nombre"];
    $score = $_POST["puntaje"];
    echo "Usuario: " . $name . "\n";
    echo "Puntaje: ". $score . "\n";
    $sql="SELECT idUsuario FROM Usuarios WHERE nombre = ?;";
    $query = $mysqli->prepare($sql);
    $query->bind_param("s",$name);
    $query->execute();
    $result=$query->get_result();
    if($result->num_rows>0)
    {
        $user_id=$result->fetch_assoc()["idUsuario"];
        $sql="UPDATE Usuarios set puntaje = ? WHERE idUsuario = ?;";
        $query = $mysqli->prepare($sql);
        $query->bind_param("ii",$user_id,$score);
        if($query->execute())
        {
            echo "Se actualizó con éxito \n";
            echo "Ranking Actual: \n";
            $sql="SELECT nombre,puntaje FROM Usuarios Order By puntaje DESC;";
            $query = $mysqli->prepare($sql);
            $query->execute();
            $result=$query->get_result();
            if($result->num_rows>0)
            {
                echo json_encode([
                    "data"=>$result->fetch_all(MYSQLI_ASSOC)
                ]);
            }       
        }
        else
        {
            echo "Error al insertar";
        }
    }
    else
    {
        $sql="INSERT INTO Usuarios(idUsuario,nombre,puntaje) VALUES(NULL,?,?);";
        $query = $mysqli->prepare($sql);
        $name=$_POST["nombre"];
        $puntaje=$_POST["puntaje"];
        $query->bind_param("si",$name,$puntaje);
        if($query->execute())
        {
            echo "Se insertó con éxito\n";
            
        }
        else
        {
            echo "Error al insertar";
        }    
    }
}
?>