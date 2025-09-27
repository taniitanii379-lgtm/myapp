<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
  $events = Event::with(['user', 'joinedUsers'])->latest()->get();
  return view('events.index', compact('events'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    // 🔽 追加
    return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🔽 イベントに必要なバリデーションルールに書き換え
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'capacity' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'fee' => 'required|string|max:255',
        ]);

        // 🔽 データベースに保存する項目を、イベントのデータに書き換え
        $request->user()->events()->create($request->only(
            'title',
            'description',
            'start_time',
            'end_time',
            'capacity',
            'location',
            'fee'
        ));

        // 🔽 リダイレクト先をイベント一覧に設定
        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
    return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Event $event)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'capacity' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'fee' => 'required|string|max:255', // ◀️ Change this line
    ]);

    $event->update($request->only(
        'title', 'description', 'start_time', 'end_time', 'capacity', 'location', 'fee'
    ));

    return redirect()->route('events.show', $event);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index');
    }
}
