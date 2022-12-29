<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <div class="flex justify-between items-end w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
                <a href="/tasks/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">New
                    Task</a>

            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead class="border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    Title
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    Description
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    Actions
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $task)
                                                <tr class="border-b" id="task-{{ $task->id }}">
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $task->id }}</td>
                                                    <td id="title-{{ $task->id }}"
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $task->title }}
                                                    </td>
                                                    <td id="description-{{ $task->id }}"
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                        {{ $task->description }}
                                                    </td>
                                                    <td id="status-{{ $task->id }}"
                                                        class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap uppercase">
                                                        {{ $task->status }}
                                                    </td>
                                                    <td>
                                                        <div class="flex">
                                                            <a href="{{ route('tasks.edit', $task->id) }}"><svg
                                                                    class="h-5 w-5 text-blue-500" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor"
                                                                    fill="none" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" />
                                                                    <path
                                                                        d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                                                    <path
                                                                        d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                                                    <line x1="16" y1="5" x2="19"
                                                                        y2="8" />
                                                                </svg></a>
                                                            <form id="delete-form-{{ $task->id }}"
                                                                action="{{ route('tasks.destroy', $task->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    title="@lang('general.delete')"
                                                                    onclick="confirmDelete({{ $task->id }})">
                                                                    <svg class="h-5 w-5 text-red-500"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <polyline points="3 6 5 6 21 6" />
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                                        <line x1="10" y1="11"
                                                                            x2="10" y2="17" />
                                                                        <line x1="14" y1="11"
                                                                            x2="14" y2="17" />
                                                                    </svg>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.onload = function() {
        Echo.channel('UpdateTask')
            .listen('UpdateTaskEvent', (e) => {
                let id = e.task.id;
                document.querySelector('#title-' + id).innerHTML = e.task.title
                document.querySelector('#description-' + id).innerHTML = e.task.description
                document.querySelector('#status-' + id).innerHTML = e.task.status

            });

    }
</script>
<script>
    function confirmDelete(item_id) {
        Swal.fire({
            title: "Are you sure?",
            text: `You won"t be able to revert this!`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                document.querySelector('#delete-form-' + item_id).submit();
            } else if (result.dismiss === "cancel") {
                Swal.fire(
                    "Cancelled",
                    "Your imaginary file is safe :)",
                    "error"
                )
            }
        });
    }
</script>
<script>
    window.onload = function() {
        Echo.channel('DeleteTask')
            .listen('DeleteTaskEvent', (e) => {
                document.querySelector('#task-' + e.data).remove();
            });
    }
</script>
