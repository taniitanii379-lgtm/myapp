<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('イベント詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <a href="{{ route('events.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>

          {{-- イベント情報ブロック (一覧画面のデザインに統一) --}}
          <div class="mt-4 bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
            {{-- タイトルを大文字で表示 --}}
            <h3 class="text-xl font-bold mb-2">{{ Str::upper($event->title) }}</h3>
            
            <p class="text-sm">
              <span class="font-semibold">開催者:</span> {{ $event->user->name }}
            </p>
            <p class="text-sm">
              <span class="font-semibold">開催場所:</span> {{ $event->location }}
            </p>
            <p class="text-sm">
              <span class="font-semibold">開始日時:</span> {{ $event->start_time->format('Y-m-d H:i') }}
            </p>
            <p class="text-sm">
              <span class="font-semibold">終了日時:</span> {{ $event->end_time->format('Y-m-d H:i') }}
            </p>
            <p class="text-sm">
              <span class="font-semibold">定員:</span> {{ $event->capacity }}
            </p>
            <p class="text-sm">
              <span class="font-semibold">参加費:</span> {{ $event->fee }}
            </p>
            
            {{-- 内容の表示形式を一覧画面に合わせる --}}
            <div class="h-4"></div>
            <p class="text-sm">
              <span class="font-semibold">内容:</span>
            </p>
            <p class="text-sm">{{ $event->description }}</p>

            {{-- 編集・削除ボタン (投稿者のみ) --}}
            @if (auth()->id() == $event->user_id)
            <div class="flex mt-4 space-x-2">
              <a href="{{ route('events.edit', $event) }}" class="text-blue-500 hover:text-blue-700 font-semibold">編集</a>
              <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">削除</button>
              </form>
            </div>
            @endif

            {{-- 参加ボタン --}}
            <div class="flex mt-4">
              @if ($event->joinedUsers->contains(auth()->id()))
              <form action="{{ route('events.unjoin', $event) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">参加中 ({{$event->joinedUsers->count()}})</button>
              </form>
              @else
              <form action="{{ route('events.join', $event) }}" method="POST">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700 font-semibold">参加する ({{$event->joinedUsers->count()}})</button>
              </form>
              @endif
            </div>

          </div>
          {{-- イベント情報ブロック 終了 --}}


          {{-- コメント機能のエリア (既存のコードを維持) --}}
          <div class="mt-8 border-t border-gray-200 dark:border-gray-600 pt-4">
            <h4 class="text-lg font-semibold mb-2">コメント ({{ $event->comments->count() }})</h4>
            <a href="{{ route('events.comments.create', $event) }}" class="text-blue-500 hover:text-blue-700 mr-2">コメントする</a>
            
            <div class="mt-4 space-y-3">
              @foreach ($event->comments as $comment)
              <div class="p-3 bg-white dark:bg-gray-700 rounded-lg shadow-sm">
                <a href="{{ route('events.comments.show', [$event, $comment]) }}" class="block hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md">
                    <p class="text-gray-800 dark:text-gray-200">{{ $comment->comment }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                        投稿者: {{ $comment->user->name }} - {{ $comment->created_at->format('Y-m-d H:i') }}
                    </p>
                </a>
              </div>
              @endforeach
            </div>
          </div>
          {{-- コメント機能のエリア 終了 --}}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
