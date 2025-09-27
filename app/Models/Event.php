<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

// app/Models/Event.php
protected $fillable = [
    'title',
    'description',
    'start_time',
    'end_time',
    'capacity',
    'location',
    'fee', // 🔽 この行があるか確認
    'user_id'
];

        // 🔽 このプロパティを追加
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }    

  public function joinedUsers()
{
    return $this->belongsToMany(User::class)->withTimestamps();
}
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

}
