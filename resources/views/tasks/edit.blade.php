<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="block p-6 rounded-lg">
                        <form action="{{ route('tasks.update',$task->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group mb-6">
                                <input type="text"
                                    class="form-control block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="exampleInput90" placeholder="Title" name="title" value="{{ $task->title }}">
                            </div>
                            <div class="form-group mb-6">
                                <select
                                    class="form-select appearance-none
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    aria-label="Default select example" name="status">
                                    <option selected>Select Task Status</option>
                                    <option @selected($task->status =='inprogress') value="inprogress">INPROGRESS</option>
                                    <option @selected($task->status =='completed') value="completed">COMPLETED</option>
                                    <option @selected($task->status =='hold') value="hold">HOLD</option>
                                    <option @selected($task->status =='cancelled') value="cancelled">CANCELLED</option>
                                </select>
                            </div>
                            <div class="form-group mb-6">
                                <textarea
                                    name="description"class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    placeholder="Description">{{ $task->description }}</textarea>

                            </div>

                            <button type="submit"
                                class="

      px-6
      py-2.5
      bg-blue-600
      text-white
      font-medium
      text-xs
      leading-tight
      uppercase
      rounded
      shadow-md
      hover:bg-blue-700 hover:shadow-lg
      focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
      active:bg-blue-800 active:shadow-lg
      transition
      duration-150
      ease-in-out">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
