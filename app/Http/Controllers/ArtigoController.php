<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Artigos;

class ArtigoController extends Controller
{
    public function __construct(Artigos $artigo)
    {
        $this->artigo = $artigo;
    }

    public function index(Request $request)
    {
        $parametros = $request->all();
        $artigos = $this->artigo->filtrar($parametros);

        return view('artigos', compact('artigos', 'parametros'));
    }

    public function delete(Request $id)
    {
        $this->artigo->deletar($id);
    }
}
