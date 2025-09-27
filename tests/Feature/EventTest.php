<?php

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str; // 🔽 Strクラスを追加

// ===================================
// 1. 一覧表示のテスト (Read - index)
// ===================================
it('displays the list of events', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $event = Event::factory()->create();

    $response = $this->get('/events');

    $response->assertStatus(200);
    // 🔽 Blade側が大文字なので、テストも大文字でチェック
    $response->assertSee(Str::upper($event->title));
    $response->assertSee($event->user->name);
});

// ... (他のPASSしたテストは省略)

// ===================================
// 3. 作成処理のテスト (Create - store)
// ===================================
it('allows authenticated users to create an event', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // 🔽 feeを文字列 (string) で定義
    $eventData = [
        'title' => 'テストイベント',
        'description' => 'これはテスト用の内容です。',
        'start_time' => '2025-10-01 10:00:00',
        'end_time' => '2025-10-01 12:00:00',
        'capacity' => '無制限',
        'location' => 'オンライン',
        'fee' => '1000', // ◀️ ここを文字列に修正
        'user_id' => $user->id,
    ];

    $response = $this->post('/events', $eventData);

    $this->assertDatabaseHas('events', [
        'title' => 'テストイベント',
        'capacity' => '無制限',
        'fee' => '1000', // ◀️ ここを文字列に修正
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/events');
});

// ... (他のPASSしたテストは省略)

// ===================================
// 6. 更新処理のテスト (Update - update)
// ===================================
it('allows a user to update their event', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $event = Event::factory()->create(['user_id' => $user->id]);

    // 更新データ
    $updatedData = [
        'title' => 'タイトルを更新しました',
        'description' => $event->description,
        'start_time' => $event->start_time->format('Y-m-d H:i:s'),
        'end_time' => $event->end_time->format('Y-m-d H:i:s'),
        'capacity' => $event->capacity,
        'location' => '新しい会場',
        'fee' => '500', // ◀️ ここを文字列に修正
    ];

    $response = $this->put("/events/{$event->id}", $updatedData);

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'title' => 'タイトルを更新しました',
        'location' => '新しい会場',
        'fee' => '500', // ◀️ ここを文字列に修正
    ]);

    $response->assertStatus(302);
    $response->assertRedirect("/events/{$event->id}");
});

it('can search events by content keyword', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // キーワード「テスト」を含むイベントをタイトルに作成
    Event::factory()->create([
        'title' => 'このイベントはテスト用です',
        'location' => '東京会場',
        'user_id' => $user->id,
    ]);

    // キーワードを含まないイベントを作成
    Event::factory()->create([
        'title' => 'ただの別のイベント',
        'user_id' => $user->id,
    ]);

    // キーワード "テスト" で検索
    $response = $this->get(route('events.search', ['keyword' => 'テスト']));

    $response->assertStatus(200);
    // 検索結果に、キーワードを含むイベントが表示されていることを確認
    $response->assertSee('このイベントはテスト用です');
    // 検索結果に、キーワードを含まないイベントが表示されていないことを確認
    $response->assertDontSee('ただの別のイベント');
});

it('shows no events if no match found', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Event::factory()->create([
        'title' => 'これは表示されるべきではありません',
        'user_id' => $user->id,
    ]);

    // 存在しないキーワードで検索
    $response = $this->get(route('events.search', ['keyword' => '存在しないキーワード']));

    $response->assertStatus(200);
    $response->assertDontSee('これは表示されるべきではありません');
    // 検索結果がない場合のメッセージが表示されていることを確認
    $response->assertSee('キーワードに一致するイベントは見つかりませんでした。');
});
