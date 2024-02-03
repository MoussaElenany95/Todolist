<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold texttext-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-2"
                    id="alert-message"role="alert">
                    <strong class="font-bold">Success</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- create button and table for tasks --}}
                    <div class="flex justify-between">
                        <h1 class="text-3xl font-bold">Tasks</h1>
                        <a href="{{ route('tasks.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Task</a>
                    </div>
                    {{-- create button and table for tasks --}}
                </div>
            </div>
            {{-- create task in cards --}}
            <div class="grid md:grid-cols-2	gap-2 mt-3">
                @foreach ($tasks as $task)
                    <div class="bg-white mb-2 p-2 " id="task-{{$task->id}}">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="font-bold">{{ $task->title }}</h3>
                            </div>

                            <div class="card-body">
                                <p class="text-ellipsis overflow-hidden text-nowrap	">{{ $task->desc }}</p>
                                {{-- Status --}}
                                <p class="text-sm text-gray-500 {{ $task->status_label }} status">
                                    {{ __($task->status_label) }}</p>
                                <p class="text-sm text-gray-500">{{ $task->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="card-footer flex">
                                {{-- create button to view modal --}}
                                <button onclick="openModal({{ $task }})"
                                    class="text-blue-500 mr-2" id="view-btn-{{$task->id}}">View</button>
                                {{-- create button to view modal --}}
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-500 mr-2">Edit</a>
                                <form id="delete-form-{{ $task->id }}"
                                    onsubmit="return confirmDelete({{ $task->id }});"
                                    action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- pagination --}}
            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
    {{-- Create modal for view task --}}
    <div
        class="modal overflow-auto opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Task</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg onclick="closeModal('modal')" class="fill-current text-3xl text-red-500"
                            xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 18 18">
                            <path
                                d="M6.469 6l-1.78-1.78a1 1 0 1 1 1.414-1.414L7.88 4.586 9.657 2.81a1 1 0 1 1 1.414 1.414L9.88 6l1.78 1.78a1 1 0 1 1-1.414 1.414L8.47 7.414 6.693 9.192a1 1 0 1 1-1.414-1.414L6.47 6z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="">
                    <p class="font-bold">Title</p>
                    <p class="text" id="title"></p>
                </div>
                <div class="">
                    <p class="font-bold">Description</p>
                    <p class="text-bold" id="desc"></p>
                </div>
                <div class="">
                    <p class="font-bold">Status</p>
                    <p class="text-bold status" id="status"></p>
                </div>
                <div class="">
                    <p class="font-bold">Created At</p>
                    <p class="text" id="created_at"></p>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete modal --}}
    <div
        class="delete-modal overflow-auto opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Delete Task</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg onclick="closeModal('delete-modal')"
                            class="fill-current text-3xl text-red-500"
                            xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 18 18">
                            <path
                                d="M6.469 6l-1.78-1.78a1 1 0 1 1 1.414-1.414L7.88 4.586 9.657 2.81a1 1 0 1 1 1.414 1.414L9.88 6l1.78 1.78a1 1 0 1 1-1.414 1.414L8.47 7.414 6.693 9.192a1 1 0 1 1-1.414-1.414L6.47 6z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="">
                    <p class="font-bold">Are you sure you want to delete this task?</p>
                </div>
                <div class="flex justify-end">
                    <button onclick="closeModal('delete-modal')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</button>
                    <button type="button" id="delete-btn"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete modal --}}
    {{-- Create modal for view task --}}
    {{-- create script for open modal --}}
    <script>
        function openModal($data) {
            document.querySelector('.modal').classList.remove('opacity-0');
            document.querySelector('.modal').classList.remove('pointer-events-none');
            document.querySelector('.modal').classList.add('opacity-100');
            document.querySelector('.modal').classList.add('pointer-events-auto');
            document.getElementById('title').innerHTML = $data.title;
            document.getElementById('desc').innerHTML = $data.desc;
            document.getElementById('status').innerHTML = $data.translated_status;
            document.getElementById('status').classList.add($data.status_label);
            var taskDate = new Date($data.created_at);
            document.getElementById('created_at').innerHTML = taskDate.toLocaleString();
        }

        function closeModal(modal) {
            document.querySelector('.' + modal).classList.remove('opacity-100');
            document.querySelector('.' + modal).classList.remove('pointer-events-auto');
            document.querySelector('.' + modal).classList.add('opacity-0');
            document.querySelector('.' + modal).classList.add('pointer-events-none');
        }

        function confirmDelete(item) {
            document.querySelector('.delete-modal').classList.remove('opacity-0');
            document.querySelector('.delete-modal').classList.remove('pointer-events-none');
            document.querySelector('.delete-modal').classList.add('opacity-100');
            document.querySelector('.delete-modal').classList.add('pointer-events-auto');
            document.getElementById('delete-btn').addEventListener('click', function() {
                document.getElementById('delete-form-' + item).submit();
            });
            return false;
        }
        var alertMessage = document.getElementById('alert-message');
        if (alertMessage) {
            setTimeout(() => {
                document.getElementById('alert-message').remove();
            }, 5000);
        }
    </script>
    <script type="module">
        // listen to tasks event
        Echo.private('user.{{ auth()->user()->id }}.tasks')
            .listen('TaskCreated', (e) => {
                // create card
                var card = document.createElement('div');
                card.classList.add('bg-white', 'mb-2', 'p-2');
                card.innerHTML = `
                    <div class="card mb-4" id="task-${e.task.id}">
                        <div class="card-header">
                            <h3 class="font-bold">${e.task.title}</h3>
                        </div>

                        <div class="card-body">
                            <p class="text-ellipsis overflow-hidden text-nowrap	">${e.task.desc}</p>
                            <p class="text-sm text-gray-500 ${e.task.status_label} status">
                                ${e.task.translated_status}</p>
                            <p class="text-sm text-gray-500">${e.task.created_at}</p>
                        </div>

                        <div class="card-footer flex">
                            <button onclick="openModal(${JSON.stringify(e.task).replace(/"/g, '&quot;')})"
                                class="text-blue-500 mr-2">View</button>
                            <a href="/tasks/${e.task.id}/edit" class="text-gray-500 mr-2">Edit</a>
                            <form id="delete-form-${e.task.id}"
                                onsubmit="return confirmDelete(${e.task.id});"
                                action="/tasks/${e.task.id}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </div>
                    </div>
                `;
                // append card to grid
                document.querySelector('.grid').prepend(card);
            }).listen('TaskDeleted', (e) => {
                // remove card
                document.getElementById('task-' + e.task_id).remove();
            }).listen('TaskUpdated', (e) => {
                // update card
                var card = document.getElementById('task-' + e.task.id);
                card.querySelector('.card-header h3').innerHTML = e.task.title;
                card.querySelector('.card-body p').innerHTML = e.task.desc;
                card.querySelector('.status').innerHTML = e.task.translated_status;
                card.querySelector('.status').classList.remove('pending', 'completed', 'in_progress','cancelled');
                card.querySelector('.status').classList.add(e.task.status_label);
                // update modal
                document.getElementById('title').innerHTML = e.task.title;
                document.getElementById('desc').innerHTML = e.task.desc;
                document.getElementById('status').innerHTML = e.task.translated_status;
                document.getElementById('status').classList.remove('pending', 'completed', 'in_progress','cancelled');
                document.getElementById('status').classList.add(e.task.status_label);
                let task = JSON.stringify(e.task);
                document.getElementById('view-btn-'+e.task.id).setAttribute('onclick', `openModal(${task})`);
            }); 
        // listen to tasks event
    </script>
    {{-- create script for open modal --}}
</x-app-layout>
