<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Event作成') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form method="POST" action="{{ route('events.store') }}">
            @csrf
            
            <div class="mb-4">
              <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">イベント名</label>
              <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('title')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="location" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">開催場所</label>
              <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('location')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">説明</label>
              <textarea name="description" id="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
              @error('description')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="start_time" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">開始日時</label>
              <input type="datetime-local" name="start_time" id="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('start_time')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="end_time" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">終了日時</label>
              <input type="datetime-local" name="end_time" id="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('end_time')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="capacity" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">定員</label>
              <input type="text" name="capacity" id="capacity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('capacity')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="fee" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">参加費</label>
              <input type="text" name="fee" id="fee" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
              @error('capacity')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">作成</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>