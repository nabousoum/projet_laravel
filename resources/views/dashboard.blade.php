<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <br>
    <h1 class="text-center mb-2 text-2xl uppercase ">Liste des utilisateurs</h1>
    <button class="flex mr-0 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded btn-left">
      Ajouter
    </button><br>
  <div class="overflow-x-auto relative">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
          <tr>
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
                  <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded btn-left">
                    modifier
                  </button>
                  <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded btn-left">
                    supprimer
                  </button>
                </td>
            </tr>
            @endforeach  
        </tbody>
      </table>
  </div>
</x-app-layout>
