<x-app-layout>
 
    <br>
    <h1 class="text-center mb-2 text-2xl uppercase text-indigo-800 bold">Liste des utilisateurs</h1>
      <label for="my-modal" class="btn modal-button ml-10  bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded btn-left">Ajouter</label>
      <form class="ml-10 mt-10" action="{{route('users.storeCsv')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <input type="file" name="file" >
          <button type="submit" class="ml-10 d-flex justify-content-end  bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded btn-left">Import</button>
        </div>
      </form>
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
                <td class="flex">
                    <button class="showModal btn-outline btn-warning text-white font-bold py-2 px-4 rounded btn-left mr-2">
                      modifier
                    </button>
                  
                    <form  action="{{route('user.delete')}}"  method="post">
                      @if($user->isDelete=="no")
                        <button  class="btn-outline btn-secondary text-white font-bold py-2 px-4 rounded btn-left">
                          supprimer
                        </button>
                      @endif
                      @if($user->isDelete=="yes")
                        <button  class="btn-outline btn-info text-white font-bold py-2 px-4 rounded btn-left ">
                          restaurer
                        </button>
                      @endif
                      @csrf
                      <input type="hidden" name="id" value="{{$user->id}}">
                    </form>
                </td>
            </tr>
            @endforeach  
        </tbody>
      </table>
    {{ $users->links() }}
  </div>
  <!-- Main modal -->
  <input type="checkbox" id="my-modal" class="modal-toggle" />
  <div class="modal">
    <div class="modal-box">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
            <svg aria-hidden="true" class="w-5 h-5 close-modal" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
        </button>
        <div class="py-6 px-6 lg:px-8">
        
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un utilisateur</h3>
      
            <form method="post" class="space-y-6" action="{{ route('users.store')}}">
              @csrf
              <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Prenom et Nom</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="firstname lastname" required>
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                    <input type="text" placeholder="name@company.com" name="email" id="email"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"   required>
                </div>
                <div class="modal-action">
                  <button type="submit" class="btn w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
                </div>
                
            </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
  <script>

    const modal = document.querySelector('.modal');
    const showModal = document.querySelector('.showModal');
    const closeModal = document.querySelector('.close-modal');

    showModal.addEventListener('click', function(){
      modal.classList.remove('hidden');
    })

    closeModal.addEventListener('click', function(){
      modal.classList.add('hidden');
    })
  </script>