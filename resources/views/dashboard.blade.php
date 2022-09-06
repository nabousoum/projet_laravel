<x-app-layout>
 
    <br>
    <h1 class="text-center mb-2 text-2xl uppercase text-indigo-800 bold">Liste des utilisateurs</h1>
    <a href="{{ route('users.create') }}">
      <button class=" ml-10 d-flex justify-content-end  bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded btn-left">
        Ajouter
      </button>
    </a>
     <br><br>
  <div class="overflow-x-auto relative">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
          <tr class="bg-gray-200 text-indigo-800">
            <th class="p-3 text-sm font-semibold tracking-wide text-left">Prenoms et Nom</th>
            <th class="p-3 text-sm font-semibold tracking-wide text-left">Email</th>
            <th class="p-3 text-sm font-semibold tracking-wide text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="bg-gray-50 border">
                <td> {{ $user->name}} </td>
                <td> {{ $user->email}} </td>
                <td>
                  <a href="">
                    <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded btn-left">
                      modifier
                    </button>
                  </a>
                  <a href="">
                    <button onclick="if(confirm('Are you sure you want to delete this user?')){document.getElementById('form-{{$user->id}}').submit();}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded btn-left">
                      supprimer
                    </button>
                  </a>
                  <form id="form-{{$user->id}}" action="{{route('user.delete', ['user'=>$user->id])}} "  method="post">
                    @csrf
                    <input type="hidden" name="_method" value="delete">
                  </form>
                </td>
            </tr>
            @endforeach  
        </tbody>
      </table>
  </div>
</x-app-layout>
