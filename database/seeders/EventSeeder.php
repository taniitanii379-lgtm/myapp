<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
  $users = User::factory(50)->create();

$genres = [
    '料理教室', 'ビジネス交流会', 'アート展示', '子育てサロン', 'ヨガ体験',
    'プログラミング勉強会', '読書会', '音楽ライブ', '地域清掃活動', '写真ワークショップ'
];

$users->each(function ($user) use ($users, $genres) {
    $eventCount = rand(2, 3);

    for ($i = 0; $i < $eventCount; $i++) {
        $genre = fake()->randomElement($genres);
        $title = "{$genre} - " . fake()->words(rand(1, 3), true);
        $start = now()->addDays(rand(1, 30))->setTime(rand(9, 18), 0);
        $end = (clone $start)->addHours(rand(1, 4));
        $capacity = rand(10, 50) . '名';
        $fee = rand(1, 4) === 1 ? '無料' : rand(500, 5000) . '円';

        $description = match ($genre) {
            '料理教室' => "地元の食材を使った家庭料理を学ぶ教室です。初心者歓迎、調理後はみんなで試食します。",
            'ビジネス交流会' => "異業種の方々と名刺交換・情報交換ができる交流イベント。軽食付き。",
            'アート展示' => "若手アーティストによる作品展示。絵画・写真・立体作品など多彩なジャンルが並びます。",
            '子育てサロン' => "乳幼児を持つ親同士の交流の場。育児相談や絵本読み聞かせもあります。",
            'ヨガ体験' => "初心者向けのリラックスヨガ。呼吸法とストレッチで心身を整えましょう。",
            'プログラミング勉強会' => "Laravelを使ったWeb開発の基礎を学ぶ勉強会。ノートPC持参推奨。",
            '読書会' => "今月の課題本を語り合う読書会。感想や考察を自由にシェアできます。",
            '音楽ライブ' => "地元バンドによるアコースティックライブ。ドリンク片手に音楽を楽しもう。",
            '地域清掃活動' => "公園や駅周辺の清掃活動。軍手・ゴミ袋はこちらで用意します。",
            '写真ワークショップ' => "構図・光の使い方を学ぶ写真講座。スマホでも参加OK。",
            default => "多様な参加者が集う交流イベントです。ぜひご参加ください！"
        };

        $event = Event::create([
            'title' => $title,
            'description' => $description,
            'start_time' => $start,
            'end_time' => $end,
            'capacity' => $capacity,
            'location' => fake()->city(),
            'fee' => $fee,
            'user_id' => $user->id,
        ]);

        $randomUsers = $users->where('id', '!=', $user->id)->random(rand(3, 6));
        $event->joinedUsers()->attach($randomUsers->pluck('id')->toArray());

        $randomUsers->each(function ($commenter) use ($event) {
            Comment::create([
                'comment' => fake()->realText(50),
                'user_id' => $commenter->id,
                'event_id' => $event->id,
            ]);
        });
    }
});

// ランダムフォロー
$users->each(function ($user) use ($users) {
    $targets = $users->where('id', '!=', $user->id)->random(rand(5, 10));
    $user->follows()->attach($targets->pluck('id')->toArray());
});

$hostUserIds = Event::pluck('user_id')->unique();
$hosts = User::whereIn('id', $hostUserIds)->get();

foreach ($hosts as $host) {
    // 自分以外の主催者をランダムに抽出（2〜6人）
    $randomHosts = $hosts->where('id', '!=', $host->id)->random(rand(2, 6));
    $host->follows()->syncWithoutDetaching($randomHosts->pluck('id')->toArray());
}

    }
}