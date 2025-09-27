<?php

namespace App\Http\Controllers;

use App\Models\Event; // 🔽 Eventモデルを読み込む
use App\Models\Comment; // 🔽 Commentモデルを読み込む
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // indexメソッドは使いません

    // 🔽 コメント作成フォームの表示
    public function create(Event $event)
    {
        return view('events.comments.create', compact('event'));
    }

    // 🔽 コメントの保存
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        // イベントに紐づけてコメントを作成
        $event->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);

        // イベント詳細画面に戻る
        return redirect()->route('events.show', $event);
    }

    // 🔽 コメント詳細の表示
    public function show(Event $event, Comment $comment)
    {
        return view('events.comments.show', compact('event', 'comment'));
    }

    // 🔽 コメント編集フォームの表示
    public function edit(Event $event, Comment $comment)
    {
        return view('events.comments.edit', compact('event', 'comment'));
    }

    // 🔽 コメントの更新
    public function update(Request $request, Event $event, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment->update($request->only('comment'));

        // コメント詳細画面に戻る
        return redirect()->route('events.comments.show', [$event, $comment]);
    }

    // 🔽 コメントの削除
    public function destroy(Event $event, Comment $comment)
    {
        $comment->delete();

        // イベント詳細画面に戻る
        return redirect()->route('events.show', $event);
    }
}
