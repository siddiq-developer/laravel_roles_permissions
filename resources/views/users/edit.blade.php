<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users / Edit
        </h2>
        <a href="{{ route('users.index') }}" 
           class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-800 transition">
            Back
        </a>
    </div>
</x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
      <form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
 


                        <div>
                            <label class="text-sm font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{ old('name', $user->name) }}" name="name" type="text"
                                       placeholder="Enter Name"
                                       class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            
                          <div>
    <label class="text-sm font-medium">Email</label>
    <div class="my-3">
        <input value="{{ old('email', $user->email) }}" name="email" type="text"
               placeholder="Enter email"
               class="border-gray-300 shadow-sm w-1/2 rounded-lg">
        @error('email')
            <p class="text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>
</div>


                            <div class="flex flex-wrap gap-4 mt-4">
                                @if($roles->isNotEmpty())
                                   
  
@foreach($roles as $role)
    <input {{ in_array($role->id, $userRole) ? 'checked' : '' }}
           type="checkbox"
           id="role-{{ $role->id }}"
           name="role[]"
           value="{{ $role->id }}">
    <label for="role-{{ $role->id }}">
        {{ $role->name }}
    </label>
@endforeach


                                @else
                                    <p class="text-gray-500">No users available</p>
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
