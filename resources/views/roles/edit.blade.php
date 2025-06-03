<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Roles / Edit
        </h2>
        <a href="{{ route('roles.index') }}" 
           class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-800 transition">
            Back
        </a>
    </div>
</x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                 <form action="{{ route('roles.update', $role->id) }}" method="post">
    @csrf
    @method('PUT')


                        <div>
                            <label class="text-sm font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{ old('name', $role->name) }}" name="name" type="text"
                                       placeholder="Enter Name"
                                       class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-wrap gap-4 mt-4">
                                @if($permissions->isNotEmpty())
                                    @foreach($permissions as $permission)
                                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded-lg">
                                            <input {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                type="checkbox" 
                                                id="permission-{{ $permission->id }}" 
                                                name="permission[]" 
                                                value="{{ $permission->id }}"
                                                class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                            <label for="permission-{{ $permission->id }}" 
                                                   class="text-sm font-medium text-gray-700">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">No permissions available</p>
                                @endif
                            </div>

                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3 mt-4">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
