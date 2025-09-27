<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    // 🔽 モデルを Event に設定
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 🔽 イベントに必要なダミーデータを生成
        $startTime = $this->faker->dateTimeBetween('now', '+1 week');
        $endTime = $this->faker->dateTimeBetween($startTime, $startTime->format('Y-m-d H:i:s') . ' +8 hours');

        return [
            'user_id' => User::factory(), // UserモデルのFactoryを使用してユーザーを生成
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'capacity' => $this->faker->randomElement(['無制限', '10', '50']), // 文字列も許容
            'location' => $this->faker->city,
            'fee' => $this->faker->numberBetween(0, 5000), // 参加費
        ];
    }
}
