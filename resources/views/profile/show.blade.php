<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('ユーザー詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <a href="{{ route('events.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">イベント一覧に戻る</a>
          
          <h3 class="text-2xl font-bold mt-4">{{ $user->name }}</h3>
          <p class="text-gray-600 dark:text-gray-400 text-sm">アカウント作成日時: {{ $user->created_at->format('Y-m-d H:i') }}</p>

          <!-- 🔽 フォロー/フォロワー数 の修正 -->
          <p class="mt-4">フォロー中: {{$user->follows_count}}</p> 
          <p>フォロワー: {{$user->followers_count}}</p>
          
          <!-- 🔽 フォローボタン -->
          @if ($user->id !== auth()->id())
          <div class="mt-4">
              @if (auth()->user()->follows->contains($user->id))
              <form action="{{ route('follow.destroy', $user) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">アンフォロー</button>
              </form>
              @else
              <form action="{{ route('follow.store', $user) }}" method="POST">
                  @csrf
                  <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">フォロー</button>
              </form>
              @endif
          </div>
          @endif

          <hr class="my-6 border-gray-400 dark:border-gray-600">
          
          <h4 class="text-xl font-semibold mb-4">{{ $user->name }} のイベント</h4>

          <!-- 🔽 イベント一覧の表示（ページネーション付き） -->
          @if ($events->count())

          <div class="mb-4">
            {{ $events->appends(request()->input())->links() }}
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
              <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <h5 class="text-lg font-bold mb-1">{{ Str::upper($event->title) }}</h5>
                <p class="text-sm">開催者: 
                    <a href="{{ route('profile.show', $event->user) }}" class="text-blue-500">
                        {{ $event->user->name }}
                    </a>
                </p>
                <p class="text-sm">開催場所: {{ $event->location }}</p>
                <p class="text-sm">開始日時: {{ $event->start_time->format('Y-m-d H:i') }}</p>
                <div class="mt-2">
                  <a href="{{ route('events.show', $event) }}" class="text-blue-500 hover:text-blue-700 font-semibold">詳細を見る</a>
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-4">
            {{ $events->appends(request()->input())->links() }}
          </div>

          @else
          <p>まだイベントを作成していません。</p>
          @endif
          
        </div>
      </div>
    </div>
  </div>
</x-app-layout>