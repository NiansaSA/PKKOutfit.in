<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table="barang";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'id_jenis', 'merk', 'ukuran', 'foto', 'keterangan'
    ];
}
