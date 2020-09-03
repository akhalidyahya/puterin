<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['no_pengirim','no_tujuan','fintech_pengirim','fintech_tujuan','nominal','bukti','user_id','kode','status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
