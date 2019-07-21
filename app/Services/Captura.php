<?php

namespace App\Services;

use App\Artigo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Captura
{
    private $artigo;
    private $guzzleClient;

    public function __construct()
    {
        $this->artigo = new Artigo();
        $this->guzzleClient = new Client();
    }

    public function index()
    {
        return $this->artigo->paginate();
    }

    public function insereArtigo($dados)
    {
        $this->artigo->create($dados);
    }

    public function delete($id)
    {
        $this->artigo->destroy($id);
    }

    public function buscaArtigos(string $parametro)
    {
        try {
            $matches = [];

            $url = 'https://www.uplexis.com.br/blog/';

            if (!empty($parametro)) {
                $parametro = preg_replace('/\s+/i', '+', $parametro);
                $url = sprintf('https://www.uplexis.com.br/blog/?s=%s', $parametro);
            }

            $conteudoPagina = $this->guzzleClient->request('GET', $url);
            $conteudoPagina = $conteudoPagina->getBody()->getContents();

            preg_match_all('/col-12 post"[\w\W]+?Continue Lendo|col-12"[\w\W]+?Continue Lendo/i', $conteudoPagina, $matches);

            if ($matches[0] == null) {
                return [
                    'msg' => 'Não existem artigos para essa busca!',
                    'type' => 'danger',
                ];
            }

            foreach ($matches[0] as $artigoPagina) {
                $titulos = [];
                preg_match_all('/(class="title">|class="col-md-6 title">)([\w\W]+?)<\/div>/i', $artigoPagina, $titulos);
                $titulo = trim($titulos[2][0]);

                $links = [];
                preg_match_all('/href="([\w\W]+?)"/i', $artigoPagina, $links);
                $link = trim($links[1][0]);

                $dados = [
                    'titulo' => $titulo,
                    'link' => $link,
                    'id_usuario' => Auth::user()->id,
                ];

                $this->insereArtigo($dados);
            }

            return [
                'msg' => 'Artigo(s) inserido(s) com sucesso!',
                'type' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'msg' => 'Algo deu errado: '.$e->getMessage(),
                'type' => 'danger',
            ];
        }
    }
}