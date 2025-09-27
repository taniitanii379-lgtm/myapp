<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('コメント詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <a href="{{ route('events.show', $event) }}" class="text-blue-500 hover:text-blue-700 mr-2">イベント詳細に戻る</a>
          
          <p class="text-gray-600 dark:text-gray-400 text-sm mt-4">対象イベント: {{ $event->title }} by {{ $event->user->name }}</p>
          <h4 class="text-xl font-bold mt-2 mb-4">{{ $comment->comment }}</h4>
          
          <div class="text-gray-600 dark:text-gray-400 text-sm">
            <p>コメント投稿者: {{ $comment->user->name }}</p>
            <p>作成日時: {{ $comment->created_at->format('Y-m-d H:i') }}</p>
            <p>更新日時: {{ $comment->updated_at->format('Y-m-d H:i') }}</p>
          </div>
          
          @if (auth()->id() === $comment->user_id)
          <div class="flex mt-4">
            <a href="{{ route('events.comments.edit', [$event, $comment]) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
            <form action="{{ route('events.comments.destroy', [$event, $comment]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
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
