<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // 🔽 設定できるカラム
    protected $fillable = ['comment', 'event_id', 'user_id'];
    
    // 🔽 イベントとの多対1の関係
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    // 🔽 ユーザーとの多対1の関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
