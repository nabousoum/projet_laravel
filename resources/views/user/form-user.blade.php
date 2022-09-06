<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <br>
    @if ($user == '' )
         <h1 class="text-center mb-2 text-2xl uppercase text-indigo-800 bold">Ajouter un utilisateur</h1>
    @endif
    @if ($user !== '' )
        <h1 class="text-center mb-2 text-2xl uppercase text-indigo-800 bold">Modifier un utilisateur</h1>
    @endif
    <div>
        <form method="POST" action="{{ $user=='' ? route('users.store') : route('users.update')}}">
            @csrf
            @if($user!=='')
                <input type="hidden" name="id" value="{{ $user->id }}" />
            @endif
            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user=='' ? old('name') : $user->name }}" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user=='' ? old('email') : $user->email }}" required />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                @if ($user == '' )
                    <x-jet-button class="ml-4">
                         Enregistrer
                    </x-jet-button>
                @endif
                @if ($user !== '' )
                    <x-jet-button class="ml-4">
                        Modifier
                    </x-jet-button>
                @endif
                
            </div>
        </form>    
    </div>
       
</x-app-layout>
@if (session()->has('swal_msg'))
    <script>
        notification = @json(session()->pull("swal_msg"));
        swal(notification.title, notification.message, notification.type);
<!-- 
    To prevent showing the notification when on browser back
    we can do: 
-->
       @php 
          session()->forget('swal_msg'); 
       @endphp
    </script>
@endif