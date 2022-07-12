<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletCharging extends Model
{

    protected $table = 'charging_wallets';
    public $timestamps = false;

    protected $fillable = [
        'charging_value',
        'date_of_charging',
        'charging_type',
        'visa_code',
        'wallet-id',

    ];
    public function wallets(){
        return $this->belongsTo(Wallets::class,'charging_wallet_id');
    }
}
