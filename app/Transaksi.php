<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table="transaksi";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'id_petugas', 'id_pembeli', 'tgl_transaksi'
    ];
}
