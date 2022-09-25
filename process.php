<?php

include_once('database.php');

$jsonObj = json_decode($_POST['peoples']);

if (!empty($jsonObj)) {

    foreach ($jsonObj as $people) {
        $name = $people->name;

        $query = "INSERT INTO pessoas (name) VALUES (:name)";

        $statement = $conn->prepare($query);

        $statement->bindParam(":name", $name);

        try {

            $statement->execute();
            $id_pessoa = $conn->lastInsertId();

            foreach ($people->children as $son) {
                $sonName = $son->name;

                $query = "INSERT INTO filhos (id_pessoa, name) VALUES (:id_pessoa, :name)";

                $statement = $conn->prepare($query);

                $statement->bindParam(":id_pessoa", $id_pessoa);
                $statement->bindParam(":name", $sonName);

                $statement->execute();
            }


        } catch (PDOException $e) {

            $error = $e->getMessage();
            echo "Erro: $error";

        }
    }
}

if ($_GET["ler"] == "true") {
     $people = [];
     $children = [];

     $query = "SELECT * FROM pessoas";

     $statement = $conn->prepare($query);

     $statement->execute();

     $people = $statement->fetchAll();

     $query = "SELECT * FROM filhos";

     $statement = $conn->prepare($query);

     $statement->execute();

     $children = $statement->fetchAll();

}

