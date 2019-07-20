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

            $artigosPagina = preg_match_all('//i', $conteudoPagina);

            foreach ($artigosPagina[0] as $artigoPagina) {
                $titulo = preg_match_all('//i', $artigoPagina);

                $link = preg_match_all('//i', $artigoPagina);

                $dados = [
                    'titulo' => $titulo,
                    'link' => $link,
                    'id_usuario' => Auth::user()->id,
                ];

                $this->insereArtigo($dados);
            }

        } catch (\Exception $e) {
            return 'Algo deu errado: '.$e->getMessage();
        }
    }

    public function insereArtigo($dados)
    {
        $this->servicoArtigos->inserir($dados);
        return 'Artigo encontrado!';
    }
}