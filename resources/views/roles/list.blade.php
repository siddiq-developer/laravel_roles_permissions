
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            <!-- @can('create roles')
            <a href="{{ route('roles.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-3">
                Create
            </a>
            @endcan -->
             
            <a href="{{ route('roles.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-3">
                Create
            </a>
           
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left" width="60">#</th>
                        <th class="px-6 py-3 text-left" width="400">Name</th>
                        <th class="px-6 py-3 text-left" width="400">Permission</th>
                        <th class="px-6 py-3 text-left" width="400">Created</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($roles->isNotEmpty())
                        @foreach($roles as $role)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">
                                    {{ $role->id }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ $role->name }}
                                </td>
                               <!-- <td class="px-6 py-3 text-left">
    @if($role->permissions->isNotEmpty())
        {{ $role->permissions->pluck('name')->join(', ') }}
    @else
        No Permissions
    @endif
</td> -->

<!-- <td class="px-6 py-3 text-left">
    @if($role->permissions->isNotEmpty())
        {{ $role->permissions->pluck('name')->join(', ') }}
    @else
        No Permissions
    @endif
</td> -->
<td>
    {{$role->permissions->pluck('name')->implode(',')}}
</td>


<!-- <td>
    {{$role->permissions}}
</td> -->



                                <td class="px-6 py-3 text-left">
                                    {{ $role->created_at->format('d M Y') }}
                                </td>

<td class="px-6 py-3">
    <div class="flex justify-center gap-2">
        @can('edit roles')
        <a href="{{ route('roles.edit', $role->id) }}" 
           class="bg-slate-700 text-white text-sm rounded-md px-4 py-2 hover:bg-slate-600">
            Edit
        </a>
        @endcan
        
        <!-- <a href="{{ route('roles.edit', $role->id) }}" 
           class="bg-slate-700 text-white text-sm rounded-md px-4 py-2 hover:bg-slate-600">
            Edit
        </a> -->
   
        
         @can('destroy roles')
        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" 
              onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-600 text-white text-sm rounded-md px-4 py-2 hover:bg-red-700">
                Delete
            </button>
        </form>
        @endcan
    </div>
</td>


                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center px-6 py-4 text-gray-500">
                                No permissions found.
                            </td>
                        </tr>
                    @endif 
                </tbody>
            </table>
            <div class="my-3">
          
            </div>
         
        </div>
    </div>

 

<x-slot name="script">
<script>
function deletePermission(id) {
    if(confirm("Are you sure?")) {
        fetch(`/permissions/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.status) {
                window.location.reload();
            }
        })
        .catch(error => console.error(error));
    }
}
</script>
</x-slot>
       
</x-app-layout>
