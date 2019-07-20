<?php

namespace App\Services;

use App\Artigo;

class Artigos
{
    public function __construct()
    {
        $this->model = new Artigo();
    }

    public function buscarTudo(array $colunas = ['*'])
    {
        return $this->model->get($colunas);
    }

    public function buscar(array $parametro = ['*'])
    {
        return $this->model->where('id', $parametro)->get();
    }

    public function paginar(int $limite = 15, array $colunas = ['*'])
    {
        return $this->model->paginate($limite, $colunas);
    }

    public function buscarPor($campo, $valor, $colunas = ['*'])
    {
        return $this->model->where($campo, $valor)->get($colunas);
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

    public function deletarPor($campo, $valor)
    {
        return $this->model->where($campo, $valor)->delete();
    }
}