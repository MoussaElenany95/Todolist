{{-- Edit task --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- create form for tasks --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4 =">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" placeholder="Title" class="w-full p-2 rounded-lg @error('title') border-red-500 @enderror dark:bg-gray-800" value="{{ $task->title }}">
                            @error('title')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>    
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" >Description</label>
                            <textarea name="desc" id="description" cols="30" rows="4" placeholder="Description" class="w-full p-2 rounded-lg @error('description') border-red-500 @enderror dark:bg-gray-800">{{ $task->desc }}</textarea>
                            @error('desc')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>    
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="status" >Status</label>
                            <select name="status" id="status" class="w-full p-2 rounded-lg @error('status') border-red-500 @enderror dark:bg-gray-800">
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}" {{ $task->status == $key ? 'selected' : '' }}>{{ __($status) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- create form for tasks --}}
    </div>
</x-app-layout>
