<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletPayment extends Model
{
    protected $table = 'payments_wallets';

    public $timestamps = false;
    protected $fillable = [
        'payment',
        'wallet_id',
    ];
    public function wallets(){
        return $this->belongsTo(Wallet::class,'wallet_id');
    }

}
