<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeFoto extends Model
{
    use HasFactory;
    protected $table = 'like_foto';
    protected $fillable = [
        'users_id',
        'foto_id',
        'tanggal_like',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

}
