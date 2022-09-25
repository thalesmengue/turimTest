<?php

class PessoaDAO implements PessoaDAOInterface
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function buildPessoa($data)
    {
        $pessoa = new Pessoa();

        $pessoa->id = $data['id'];
        $pessoa->name = $data['name'];

        return $pessoa;
    }

    public function createPessoa(Pessoa $pessoa)
    {
        $statement = $this->conn->prepare("INSERT INTO pessoas(
          id, name
        ) VALUES (
          :id, :name
        )");

        $statement->bindParam(":id", $pessoa->id);
        $statement->bindParam(":name", $pessoa->name);

        $statement->execute();
    }

    public function getPessoas()
    {
        $statement = $this->conn->prepare("SELECT * FROM pessoas");

        $statement->execute();
    }

    public function deletePessoa($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM pessoas WHERE id = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }
}