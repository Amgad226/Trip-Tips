<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{
    protected $table = 'app_reviews';

    protected $fillable = [
        'comment',
        'user_id',
    ];
    public $timestamps = false;

    public function  user()
    {
        return $this->belongsTo(User::class);
    }
}
