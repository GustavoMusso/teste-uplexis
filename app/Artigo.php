<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{
    protected $table = 'artigos';

    protected $fillable = [
        'id_usuario', 'titulo', 'link',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}