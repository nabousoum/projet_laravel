<x-app-layout>
    <br>
    <h1 class="text-center mb-2 text-2xl uppercase text-indigo-800 bold">Liste des utilisateurs</h1>
    <div class="flex justify-center">
      <form class="flex justify-around" method="post" action="{{route('users.export')}}">
        @csrf
        <div class="flex  mt-10">
          <label for="start_date">date debut</label>
           <input type="datetime-local" name="start_date" class="h-10 ml-10" id="start_date" placeholder="Start Date" >  
        </div>
        <div class="flex  mt-10 ml-20">
          <label for="end_date">date fin</label>
          <input type="datetime-local" name="end_date" class="h-10 ml-10" id="end_date" placeholder="End Date" >
        </div>
      <a href="{{ route('users.export')}}">
        <button type="submit" class="h-10 mt-10 ml-20 justify-content-end  bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded btn-left"><i class="fa fa-copy mr-1"></i>Export</button>
      </a>
    </form>
  </div>
    <div class="flex justify-around mt-5">
      <label for="my-modal" class="btn modal-button ml-10 mt-10 bg-indigo-500 c:bg-indigo-700 text-white font-bold py-2 px-4 rounded btn-left"><i class="fa fa-plus mr-2"></i> Ajouter</label>
      <form class="ml-10 mt-10" action="{{route('users.storeCsv')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <input type="file" name="file" class="input input-bordered ">
          <button type="submit" class="ml-10 d-flex justify-content-end  bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded btn-left"><i class="fa fa-copy"></i>  Import</button>
        </div>
      </form>
    </div>  
     <br><br>
  <div class="overflow-x-auto relative">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="bg-gray-50 border-b-2 border-gray-200">
          <tr class="bg-gray-200 text-indigo-800">
            <th class="p-3 text-sm font-semibold tracking-wide text-left">Prenoms et Nom</th>
            <th class="p-3 text-sm font-semibold tracking-wide text-left">Email</th>
            <th class="p-3 text-sm font-semibold tracking-wide text-left">Date de creation</th>
            <th class="p-3 text-sm font-semibold tracking-wide text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="bg-gray-50 border">
                <td> {{ $user->name}} </td>
                <td> {{ $user->email}} </td>
                <td> {{ $user->created_at->format('d/m/Y') }} </td>
                <td class="flex">
                    @if($user->isDelete=="no")
                      <label for="my-modal" class=" modal-button btn-outline btn-warning text-white hover:text-white font-bold py-2 px-4 rounded btn-left ">
                        <i class="fa fa-pen"></i> modifier
                      </label>
                    @endif
                    @if($user->isDelete=="yes")
                    <button  class="invisible btn-outline  btn-ghost text-white font-bold py-2 px-4 rounded btn-left">
                      <i class="fa fa-pen"></i> modifier
                    </button>
                    @endif
                    <form  action="{{route('user.delete')}}"  method="post">
                      @if($user->isDelete=="no")
                        <button  class="btn-outline btn-secondary text-white font-bold py-2 px-4 rounded btn-left">
                          <i class="fa fa-trash"></i>  archiver
                        </button>
                      @endif
                      @if($user->isDelete=="yes") 
                      
                        <button  class="btn-outline btn-info text-white font-bold py-2 px-4 rounded btn-left ">
                          <i class="fa fa-save"></i>   restaurer
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
        <div class="modal-action">
          <label for="my-modal" class="btn btn-ghost">x</label>
        </div>
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