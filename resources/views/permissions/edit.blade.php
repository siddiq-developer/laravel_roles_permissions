<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Permissions / Edit
        </h2>
        <!-- <a href="{{ route('permissions.update', $permission->id) }}" class="bg-slate-700 text-sm rounded-md  px-3 py-2 hover:bg-slate-600">
            Back
        </a> -->
        <a href="{{ route('permissions.update', $permission->id) }}" 
   class="text-white text-sm rounded-md px-3 py-2 hover:opacity-90"
   style="background-color:rgb(27, 31, 27);">
    Back
</a>

    </div>
</x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
  <form action="{{ route('permissions.store') }}" method="post">
    @csrf
    <div>
        <label class="text-sm font-medium">Name</label>
        <div class="my-3">
            <input value="{{ old('name', $permission->name) }}" name="name" type="text" placeholder="Enter Name"
                   class="border-gray-300 shadow-sm w-1/2 rounded-lg">
            @error('name')
                <p class="text-red-400 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Right-aligned button with background color --}}
        <div class="flex justify-end ">
            <button class="bg-blue-600 hover:bg-blue-700 text-white  text-sm rounded-md px-5 py-3"  style="background-color:rgb(27, 31, 27);">
                Update
            </button>
        </div>
    </div>
</form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
