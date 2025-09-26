<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('イベント一覧') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @if ($events->isEmpty())
            <p>イベントはまだありません。</p>
          @else
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

                  {{-- 🔽 詳細を見るボタンを追加 --}}
                  <div class="mt-4">
                    <a href="{{ route('events.show', $event) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>