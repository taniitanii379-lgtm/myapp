<?php

use App\Models\User;
use App\Models\Event; // TweetをEventに変更
use App\Models\Comment;

// ===================================
// 1. コメント作成フォームの表示テスト
// ===================================
it('displays the comment creation form', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  // イベントを作成
  $event = Event::factory()->create();

  // コメント作成フォームにアクセス
  $response = $this->get(route('events.comments.create', $event)); // ルート名を変更
  
  $response->assertStatus(200);
  $response->assertViewIs('events.comments.create'); // ビューのパスを変更
  $response->assertViewHas('event', $event); // 変数名を変更
});

// ===================================
// 2. コメント作成処理のテスト (Store)
// ===================================
it('allows authenticated users to create a comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  // イベントを作成
  $event = Event::factory()->create();
  $commentData = ['comment' => 'store test comment'];

  // POSTリクエストでコメントを送信
  $response = $this->post(route('events.comments.store', $event), $commentData); // ルート名を変更
  
  $response->assertRedirect(route('events.show', $event)); // リダイレクト先を変更
  
  // データベースにコメントが保存されたことを確認
  $this->assertDatabaseHas('comments', [
    'comment' => $commentData['comment'],
    'event_id' => $event->id, // tweet_idをevent_idに変更
    'user_id' => $user->id,
  ]);
});

// ===================================
// 3. コメント詳細画面の表示テスト (Show)
// ===================================
it('displays a comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $event = Event::factory()->create();
  $comment = Comment::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]); // event_idを設定

  // GETリクエストでコメント詳細にアクセス
  $response = $this->get(route('events.comments.show', [$event, $comment])); // ルート名とパラメータを変更
  
  $response->assertStatus(200);
  $response->assertViewIs('events.comments.show'); // ビューのパスを変更
  $response->assertViewHas('event', $event); // 変数名を変更
  $response->assertViewHas('comment', $comment);
});

// ===================================
// 4. コメント編集画面の表示テスト (Edit)
// ===================================
it('displays the edit comment page', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $event = Event::factory()->create();
  $comment = Comment::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);

  // 編集画面にアクセス
  $response = $this->get(route('events.comments.edit', [$event, $comment])); // ルート名とパラメータを変更

  $response->assertStatus(200);
  $response->assertViewIs('events.comments.edit'); // ビューのパスを変更
  $response->assertViewHas('event', $event);
  $response->assertViewHas('comment', $comment);
});

// ===================================
// 5. コメント更新処理のテスト (Update)
// ===================================
it('allows a user to update their comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $event = Event::factory()->create();
  $comment = Comment::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);
  $updatedData = ['comment' => 'update test comment'];

  // PUTリクエストで更新
  $response = $this->put(route('events.comments.update', [$event, $comment]), $updatedData); // ルート名とパラメータを変更
  
  $response->assertRedirect(route('events.comments.show', [$event, $comment])); // リダイレクト先を変更
  
  // データベースが更新されたことを確認
  $this->assertDatabaseHas('comments', [
    'id' => $comment->id,
    'comment' => $updatedData['comment'],
  ]);
});

// ===================================
// 6. コメント削除処理のテスト (Destroy)
// ===================================
it('allows a user to delete their comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $event = Event::factory()->create();
  $comment = Comment::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);

  // DELETEリクエストで削除
  $response = $this->delete(route('events.comments.destroy', [$event, $comment])); // ルート名とパラメータを変更
  
  $response->assertRedirect(route('events.show', $event)); // リダイレクト先を変更
  
  // データベースから削除されたことを確認
  $this->assertDatabaseMissing('comments', [
    'id' => $comment->id,
  ]);
});
