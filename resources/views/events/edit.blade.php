<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('イベント編集') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <a href="{{ route('events.show', $event) }}" class="text-blue-500 hover:text-blue-700 mr-2">詳細に戻る</a>
          <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
              <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">イベント名</label>
              <input type="text" name="title" id="title" value="{{ $event->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('title')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>
            
            <div class="mb-4">
              <label for="location" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">開催場所</label>
              <input type="text" name="location" id="location" value="{{ $event->location }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('location')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">説明</label>
              <textarea name="description" id="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $event->description }}</textarea>
              @error('description')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="start_time" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">開始日時</label>
              <input type="datetime-local" name="start_time" id="start_time" value="{{ $event->start_time->format('Y-m-d\TH:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('start_time')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="end_time" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">終了日時</label>
              <input type="datetime-local" name="end_time" id="end_time" value="{{ $event->end_time->format('Y-m-d\TH:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('end_time')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="capacity" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">定員</label>
              <input type="text" name="capacity" id="capacity" value="{{ $event->capacity }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('capacity')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="fee" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">参加費</label>
              <input type="text" name="fee" id="fee" value="{{ $event->fee }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('fee')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">更新</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>