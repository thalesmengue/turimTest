<?php

class Pessoa
{
    public int $id;
    public string $name;
}

interface PessoaDAOInterface
{
    public function buildPessoa($data);

    public function createPessoa(Pessoa $pessoa);

    public function getPessoas();

    public function deletePessoa($id);
}