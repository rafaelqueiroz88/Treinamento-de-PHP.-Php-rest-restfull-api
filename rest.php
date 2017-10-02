<?php

    //header("Content-type: application/json");

    $verb = $_SERVER["REQUEST_METHOD"];

    $host = "localhost";

    $user = "root";

    $pass = "root";

    $db = "treinamento";

    $con = mysqli_connect($host, $user, $pass, $db);

    if($verb == "GET")
    {

        if(isset($_GET["usuario"]))
        {

            $sql = mysqli_query($con, "SELECT * FROM ar_clientes");

            $json = array();

            $i = 0;

            while($row = mysqli_fetch_array($sql))
            {

                $json[$i] = array("Nome" => $row["ar_primeiro_nome"], "Sobrenome" => $row["ar_sobrenome"]);

                $i++;

            }
            
            echo json_encode($json);

        }
    }
    else if($verb == "POST")
    {

        $inputJSON = file_get_contents('php://input');

        $input = json_decode($inputJSON, true);

        mysqli_query($con, "INSERT INTO ar_clientes (ar_primeiro_nome, ar_sobrenome) VALUES ('".$input["ar_primeiro_nome"]."', '".$input["ar_sobrenome"]."')");

    }
    else if($verb = "DELETE")
    {

        $inputJSON = file_get_contents('php://input');

        $input = json_decode($inputJSON, true);

        if(mysqli_query($con, "DELETE FROM ar_clientes WHERE ar_primeiro_nome = '".$input["nome"]."' AND ar_sobrenome = '".$input["sobrenome"]."'"))
        {

            echo "Usuário removido com sucesso!";

        }

    }
?>