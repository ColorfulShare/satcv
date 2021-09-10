<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-2" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            @if ( request()->referred_id != null )
                <input type="hidden" name="referred_id" value="{{request()->referred_id}}">
            @else    
                <input type="hidden" name="referred_id">  
            @endif

            <div>
                <x-jet-label for="name" value="{{ __('Nombre') }}" />
                <x-jet-input id="name" class="block mt-1 w-full border-primary" type="text" name="name" :value="old('name')" required autofocus autocomplete="Nombre" />
            </div>

            <div class="mt-2">
                <x-jet-label for="email" value="{{ __('Correo') }}" />
                <x-jet-input id="email" class="block mt-1 w-full border-primary" type="email" name="email" :value="old('Correo')" required />
            </div>

            <div class="mt-2">
                <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                <x-jet-input id="password" class="block mt-1 w-full border-primary" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-2">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full border-primary " type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-3">
                    <x-jet-label for="terms">
                        <div class="flex items-center ">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2 ">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-green-600 hover:text-gray-900 ">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-green-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

               <div class="d-grid gap-2 col-6 mx-auto">
                   <button class="btn btn-primary w-100 mt-2" type="submit" tabindex="4"> {{ __('REGÍSTRAR') }}</button>
               </div>
             
                <p class="text-center mt-2"><a
                  href="{{ route('login') }}"><span class="underline text-green-600">{{ __('¿Ya Tienes Cuenta?') }}</span></a>
               </p>  

            </form>
    </x-jet-authentication-card>
</x-guest-layout>
