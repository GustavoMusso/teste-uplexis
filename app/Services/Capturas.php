<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Capturas
{
    private $servicoArtigos;
    private $guzzleClient;

    public function __construct()
    {
        $this->servicoArtigos = new Artigos();
        $this->guzzleClient = new Client();
    }

    public function buscaArtigos(array $parametro)
    {
        try {
            $url = 'https://www.uplexis.com.br/blog/?s='.$parametro;

            $conteudoPagina = $this->guzzleClient->request('GET', $url);
            $conteudoPagina = $conteudoPagina->getBody()->getContents();

            $artigosPagina = preg_match_all('/col-12 post"[\w\W]+?Continue Lendo|col-12"[\w\W]+?Continue Lendo/i', $conteudoPagina);

            if ($artigosPagina[0] == null) {
                return [
                    'msg' => 'Não existem artigos para essa busca!',
                    'type' => 'danger',
                ];
            }

            foreach ($artigosPagina[0] as $artigoPagina) {
                $titulo = preg_match_all('/class="title">([\w\W]+?)<\/div>|class="col-md-6 title">([\w\W]+?)<\/div>/i', $artigoPagina);
                $titulo = trim($titulo[1][0]);

                $link = preg_match_all('/href="([\w\W]+?)"/i', $artigoPagina);
                $link = trim($link[1][0]);

                $dados = [
                    'titulo' => $titulo,
                    'link' => $link,
                    'id_usuario' => Auth::user()->id,
                ];

                $return = $this->insereArtigo($dados);

                return $return;
            }

        } catch (\Exception $e) {
            return [
                'msg' => 'Algo deu errado: '.$e->getMessage(),
                'type' => 'danger',
            ];
        }
    }

    public function insereArtigo($dados)
    {
        $this->servicoArtigos->inserir($dados);
        return [
            'msg' => 'Artigo encontrado!',
            'type' => 'success',
        ];
    }
}