<?php

use App\Models\Event;
use App\Models\User;

// ===================================
// 1. 参加処理のテスト (Attach)
// ===================================
it('allows a user to join an event', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    // POSTリクエスト (参加処理)
    $this->actingAs($user)
        ->post(route('events.join', ['event' => $event->id]))
        ->assertStatus(302); // リダイレクトを確認

    // 中間テーブル 'event_user' にデータが追加されたことを確認
    $this->assertDatabaseHas('event_user', [
        'user_id' => $user->id,
        'event_id' => $event->id
    ]);
});

// ===================================
// 2. 不参加処理のテスト (Detach)
// ===================================
it('allows a user to unjoin an event', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    // 最初にユーザーをイベントに参加させる (中間テーブルにデータを作成)
    $user->joins()->attach($event);

    // DELETEリクエスト (不参加処理)
    $this->actingAs($user)
        ->delete(route('events.unjoin', ['event' => $event->id]))
        ->assertStatus(302); // リダイレクトを確認

    // 中間テーブル 'event_user' からデータが削除されたことを確認
    $this->assertDatabaseMissing('event_user', [
        'user_id' => $user->id,
        'event_id' => $event->id
    ]);
});