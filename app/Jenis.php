<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table="jenis";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama_jenis', 'harga', 'stok'
    ];
}
