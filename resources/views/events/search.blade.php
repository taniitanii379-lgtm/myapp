<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('イベント検索') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

<!-- 検索フォーム -->
<form action="{{ route('events.search') }}" method="GET" class="mb-6">
  <div class="flex items-center space-x-4">
    <input type="text" name="keyword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="イベント名、場所、内容で検索..." value="{{ request('keyword') }}">
    <button type="submit" class="shrink-0 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 font-bold">
      検索
    </button>
  </div>
</form>

          <!-- ページネーションと検索結果表示 -->
          @if ($events->count())

          <h3 class="text-lg font-semibold mb-4">{{ $events->total() }} 件のイベントが見つかりました</h3>

          <!-- ページネーションリンク -->
          <div class="mb-4">
            {{ $events->appends(request()->input())->links() }}
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
              <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
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
                
                <div class="h-4"></div>
                <p class="text-sm">
                  <span class="font-semibold">内容:</span>
                </p>
                <p class="text-sm">{{ $event->description }}</p>

                {{-- 🔽 詳細を見るボタン --}}
                <div class="mt-4">
                  <a href="{{ route('events.show', $event) }}" class="text-blue-500 hover:text-blue-700 font-semibold">詳細を見る</a>
                </div>
              </div>
            @endforeach
          </div>

          <!-- ページネーションリンク -->
          <div class="mt-4">
            {{ $events->appends(request()->input())->links() }}
          </div>

          @else
          <p>キーワードに一致するイベントは見つかりませんでした。</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
