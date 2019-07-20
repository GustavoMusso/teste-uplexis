<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Capturas;

class CapturaController extends Controller
{
    public function __construct(Capturas $captura)
    {
        $this->captura = $captura;
    }

    public function index()
    {
        return view('captura.index');
    }

    public function captura(Request $request)
    {
        $parametros = $request->all();

        $mensagem = $this->captura->buscaArtigos($parametros);

        return response()->json($mensagem);
    }
}
