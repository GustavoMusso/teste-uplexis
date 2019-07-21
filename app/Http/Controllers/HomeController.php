<?php

namespace App\Http\Controllers;

use App\Services\Captura;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $captura;

    public function __construct(Captura $captura)
    {
        $this->captura = $captura;
    }

    public function index()
    {
        $artigos = $this->captura->index();

        return view('home', compact('artigos'));
    }

    public function create()
    {
        return view('captura');
    }

    public function store(Request $request)
    {
        $pesquisa = $request->get('pesquisa') ?? '';

        $this->captura->buscaArtigos($pesquisa);

        return redirect(route('home.index'));
    }

    public function delete($id)
    {
        $this->captura->delete($id);
    }
}
