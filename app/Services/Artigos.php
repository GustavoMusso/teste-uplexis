<?php

namespace App\Services;

use App\Artigo;

class Artigos
{
    private $model;

    public function __construct()
    {
        $this->model = new Artigo();
    }

    public function buscarTudo()
    {
        return $this->model->get();
    }

    public function buscar(string $parametro)
    {
        return $this->model->where('id', $parametro)->get();
    }

    public function paginar()
    {
        return $this->model->paginate();
    }

    public function buscarPor($campo, $valor, $colunas = ['*'])
    {
        return $this->model->where($campo, $valor)->get($colunas);
    }

    public function filtrar($busca)
    {
        return $this->model->where('titulo', 'LIKE', '%' . $busca . '%')->paginate();
    }

    public function inserir(array $dados)
    {
        return $this->model->create($dados);
    }

    public function atualizar(array $dados, $id)
    {
        $instance = $this->model->find($id);
        $instance->fill($dados);
        return $instance->save();
    }

    public function atualizarPor(array $dados, $id, $parametro = 'id')
    {
        return $this->model->where($parametro, $id)->update($dados);
    }

    public function deletar($id)
    {
        return $this->model->destroy($id);
    }
}