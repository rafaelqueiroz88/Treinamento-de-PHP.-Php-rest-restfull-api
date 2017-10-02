<?php

    //header("Content-type: application/json");

    $verb = $_SERVER["REQUEST_METHOD"]; //Armazena o método utilizado na variável

    //As variáveis host,user,pass,db e con serão utilizadas somente para conectar e utilizar o bando de dados

    $host = "localhost";

    $user = "root";

    $pass = "root";

    $db = "treinamento";

    $con = mysqli_connect($host, $user, $pass, $db);

    if($verb == "" || $verb == null)
    {

        echo "Bem vindo! <br/> Informe um método qualquer e faça a requisição necessária!";
        
    }
    //Se o método recebido pela variável for um método POST ele entrará na seguinte função
    //Casos de uso: salvar alguma informação no bando de dados
    else if($verb == "POST")
    {

        $inputJSON = file_get_contents('php://input');

        $input = json_decode($inputJSON, true);

        $nome = $input["ar_primeiro_nome"];
        
        $sobrenome = $input["ar_sobrenome"];

        if(mysqli_query($con, "INSERT INTO ar_clientes (ar_primeiro_nome, ar_sobrenome) VALUES ('$nome', '$sobrenome')"))
        {

            echo "Cadastro efetuado com sucesso!";

        }

    }
    //Se o método recebido pela variável for um método GET ele entrará na seguinte função.
    //Casos de uso: fazer listagem de algo ou abrir os resultados de algo específico
    //Obs: se o objetivo for utilizar este método para abrir um objeto específico do BD, lembre-se de informar a ID do objeto solicitado
    else if($verb == "GET")
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

            $i = 0;
            
            echo json_encode($json);

        }

    }
    //Se o método recebido pela variável for um método PUT ele entrará na seguinte função
    //Casos de uso: use para atualizar objetos já cadastrados no bando de dados
    //Obs: o uso deste método exige que uma ID ou algum meio identificador seja informado como parâmetro
    else if($verb == "PUT")
    {
        $inputJSON = file_get_contents('php://input');
        
        $input = json_decode($inputJSON, true);

        $nome = $input["ar_primeiro_nome"];

        $sobrenome = $input["ar_sobrenome"];

        $id = $_GET["ID"];

        if(mysqli_query($con, "UPDATE ar_clientes SET ar_primeiro_nome = '$nome' AND ar_sobrenome = '$sobrenome' WHERE ar_id = $id"))
        {

            echo "Cadastro atualizado com sucesso!";

        }

    }    
    //Se o método recebido pela variável for um método DELETE ele entrará na seguinte função
    //Casos de uso: apagar coisas do banco de dados
    else if($verb = "DELETE")
    {

        $inputJSON = file_get_contents('php://input');

        $input = json_decode($inputJSON, true);

        $nome = $input["ar_primeiro_nome"];
        
        $sobrenome = $input["ar_sobrenome"];

        if(mysqli_query($con, "DELETE FROM ar_clientes WHERE ar_primeiro_nome = '$nome' AND ar_sobrenome = '$sobrenome'"))
        {

            echo "Usuário removido com sucesso!";

        }

    }

?>