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
          
          <h3 class="font-bold text-xl mt-4">{{ $event->title }}</h3>
          <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $event->description }}</p>
          
          <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <p><strong>開催者:</strong> {{ $event->user->name }}</p>
            <p><strong>開催場所:</strong> {{ $event->location }}</p>
            <p><strong>開始日時:</strong> {{ $event->start_time->format('Y-m-d H:i') }}</p>
            <p><strong>終了日時:</strong> {{ $event->end_time->format('Y-m-d H:i') }}</p>
            <p><strong>定員:</strong> {{ $event->capacity }}</p>
            <p><strong>参加費:</strong> {{ $event->fee }}</p>
            <p><strong>作成日時:</strong> {{ $event->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>更新日時:</strong> {{ $event->updated_at->format('Y-m-d H:i:s') }}</p>
          </div>
          
          @if (auth()->id() == $event->user_id)
          <div class="flex mt-4">
            <a href="{{ route('events.edit', $event) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
            <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
            </form>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>