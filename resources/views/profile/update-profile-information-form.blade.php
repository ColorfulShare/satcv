@push('custom_js')
<script>
    $(document).ready(function() {
        @if($this->user -> photo_dni !== NULL)
            previewPersistedFile("{{asset('storage/'.$this->user->photo_dni)}}", 'photo_preview');
        @endif
        @if($this->user -> photo_document !== NULL)
        previewPersistedFile("{{asset('storage/'.$this->user->photo_document)}}", 'photo_preview2');
        @endif
    });



    function previewFile(input, preview_id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#" + preview_id).attr('src', e.target.result);
                $("#" + preview_id).css('height', '200px');
                $("#" + preview_id).parent().parent().removeClass('d-none');
            }
            $("label[for='" + $(input).attr('id') + "']").text(input.files[0].name);
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewPersistedFile(url, preview_id) {
        $("#" + preview_id).attr('src', url);
        $("#" + preview_id).css('height', '200px');
        $("#" + preview_id).parent().parent().removeClass('d-none');
    }
</script>
<script src="{{asset('assets/app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/app-assets/js/core/app.js')}}"></script>
<script src="{{asset('assets/app-assets/js/scripts/components.js')}}"></script>
@endpush


<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Información de Perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Mantenga la información de su perfil actualizada') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-12 row flex-column align-items-center">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Foto') }}" />

                <!-- Current Profile Photo -->
                @if (Auth::user()->profile_photo_path != NULL)
                <div class="mt-0" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>
                @else
                <div class="mt-0" x-show="! photoPreview">
                    <img src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->username }}"
                        alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>
                @endif

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Seleccione una nueva foto') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif
        {{-- {{dd($this->user)}} --}}
        <!-- username -->
        <div class="row">

            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="name" value="{{ __('Nombre') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            
            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="lastname" value="{{ __('Apellido') }}" />
                <x-jet-input id="lastname" type="text" class="mt-1 block w-full" wire:model.defer="state.lastname" autocomplete="lastname" />
                <x-jet-input-error for="lastname" class="mt-2" />
            </div>
            {{--  --}}
            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="birth" value="{{ __('Fecha de nacimiento') }}" />
                <x-jet-input id="birth" type="date" class="mt-1 block w-full" wire:model.defer="state.birth" autocomplete="birth" />
                <x-jet-input-error for="birth" class="mt-2" />
            </div>
            {{-- Número de documento de identidad o pasaporte --}}
            <div class="col-sm-12 col-md-6 my-1 w-100">
                <x-jet-label for="dni" value="{{ __('Número de documento de identidad o pasaporte') }}" />
                <x-jet-input id="dni" type="text" class="mt-1 block w-full" wire:model.defer="state.dni" autocomplete="dni" />
                <x-jet-input-error for="dni" class="mt-2" />
            </div>

            {{-- Foto de documento de identidad o pasaporte --}}
                <div class="col-sm-12 col-md-6 my-1" class="mt-1">
                    <x-jet-label for="photo_dni" value="{{ __('Foto de documento de identidad o pasaporte') }}" />
                    <img id="photo_preview" class="img-fluid " />
                    <x-jet-input id="photo_dni" type="file" class="mt-1 block w-full" wire:model.defer="state.photo_dni" autocomplete="photo_dni" onchange="previewFile(this, 'photo_preview')" accept="image/*" />
                    <x-jet-input-error for="photo_dni" class="mt-2" />
                </div>
            {{-- Fecha de vencimiento del documento de identidad --}}
            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="dni_expedition" value="{{ __('Fecha de expedicion de documento de identidad o pasaporte') }}" />
                <x-jet-input id="dni_expedition" type="date" class="mt-1 block w-full" wire:model.defer="state.dni_expedition" autocomplete="dni_expedition" />
                <x-jet-input-error for="dni_expedition" class="mt-2" />
            </div>
            {{-- Ciudad de expedición de documento de identidad o pasaporte --}}
            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="city_dni" value="{{ __('Ciudad de expedición de documento de identidad o pasaporte') }}" />
                <x-jet-input id="city_dni" type="text" class="mt-1 block w-full" wire:model.defer="state.city_dni" />
                <x-jet-input-error for="city_dni" class="mt-2" />
            </div>
            {{-- Correo electrónico --}}
            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="email" value="{{ __('Correo electrónico') }}" />
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
            {{-- Teléfono fijo --}}
            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="phone" value="{{ __('Teléfono fijo') }}" />
                <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="state.phone" />
                <x-jet-input-error for="phone" class="mt-2" />
            </div>
            {{-- Teléfono Móvil --}}
            <div class="col-sm-12 col-md-6 my-1">
                <x-jet-label for="mobile_phone" value="{{ __('Teléfono Móvil') }}" />
                <x-jet-input id="mobile_phone" type="text" class="mt-1 block w-full" wire:model.defer="state.mobile_phone" />
                <x-jet-input-error for="mobile_phone" class="mt-2" />
            </div>

            
            {{-- Zona para editar la Información de Vivienda --}}
            <h5 class="mt-3 mb-1 font-bold">Información de Vivienda</h5>
            <div class="row">
                <div class="col-sm-12 col-md-6 my-1">
                    <x-jet-label for="address" value="{{ __('Dirección') }}" />
                    <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="state.address" />
                    <x-jet-input-error for="address" class="mt-2" />
                </div>
    
                <div class="col-sm-12 col-md-6 my-1">
                    <x-jet-label for="district" value="{{ __('Barrio') }}" />
                    <x-jet-input id="district" type="text" class="mt-1 block w-full" wire:model.defer="state.district" />
                    <x-jet-input-error for="district" class="mt-2" />
                </div>
    
                <div class="col-sm-12 col-md-6 my-1">
                    <x-jet-label for="city" value="{{ __('Ciudad') }}" />
                    <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="state.city" />
                    <x-jet-input-error for="city" class="mt-2" />
                </div>
    
                <div class="col-sm-12 col-md-6 my-1">
                    <x-jet-label for="department" value="{{ __('Departamento') }}" />
                    <x-jet-input id="department" type="text" class="mt-1 block w-full" wire:model.defer="state.department" />
                    <x-jet-input-error for="department" class="mt-2" />
                </div>
    
                <div class="col-sm-12 col-md-6 my-1" class="mt-1">
                    <x-jet-label for="photo_document" value="{{ __('Recibo de servicios / Extracto bancario / Recibo de teléfono') }}" />
                    <img id="photo_preview2" class="img-fluid " />
                    <x-jet-input id="photo_document" type="file" class="mt-1 block w-full" wire:model.defer="state.photo_document" onchange="previewFile(this, 'photo_preview2')" accept="image/*" />
                    <x-jet-input-error for="photo_document" class="mt-2" />
                </div>                
            </div>

        
    </div>
        
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Cambios Guardados Exitosamente.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>