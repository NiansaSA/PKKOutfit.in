<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    protected $table="pembeli";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama_pembeli', 'alamat', 'telp', 'username', 'foto'
    ];
}
