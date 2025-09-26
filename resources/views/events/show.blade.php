<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('イベント詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('events.index') }}">一覧に戻る</a>
                    
                    <h3>{{ $event->title }}</h3>
                    <p>詳細: {{ $event->description }}</p>
                    <p>日時: {{ $event->start_time }} - {{ $event->end_time }}</p>
                    <p>定員: {{ $event->capacity }}</p>
                    <p>投稿者: {{ $event->user->name }}</p>

                    @if (auth()->id() == $event->user_id)
                        <a href="{{ route('events.edit', $event) }}">編集</a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>