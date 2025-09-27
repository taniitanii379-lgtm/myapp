<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Event;
use App\Models\Comment; // 🔽 Comment モデルの読み込みを確認
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class; // 🔽 モデルを指定

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 🔽 コメントの内容を生成するよう修正
            'comment' => $this->faker->sentence, 
            'user_id' => User::factory(),
            'event_id' => Event::factory(), // 🔽 event_id を event に変更
        ];
    }
}