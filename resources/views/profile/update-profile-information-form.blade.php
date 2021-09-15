@push('custom_js')
<script>
    $(document).ready(function() {
        
        @if($this->user->photo_dni_front !== NULL)
            previewPersistedFile("{{asset('storage/'.$this->user->photo_dni_front)}}", 'photo_preview_f');
        @endif

        @if($this->user->photo_dni_back !== NULL)
            previewPersistedFile("{{asset('storage/'.$this->user->photo_dni_back)}}", 'photo_preview_b');
        @endif

        @if($this->user->selfie_document !== NULL)
            previewPersistedFile("{{asset('storage/'.$this->user->selfie_document)}}", 'selfie_d');
        @endif

        @if($this->user->photo_document !== NULL)
        previewPersistedFile("{{asset('storage/'.$this->user->photo_document)}}", 'photo_preview2');
        @endif
    });

    function previewFile(input, preview_id) {
        console.log(input)
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

<script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>
@endpush


@php
  $country = \App\Models\Country::all();  
@endphp
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
            {{--
            <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />
            --}}
            <input type="file" class="d-none" id="photo" name="photo" wire:model="photo" x-ref="photo" x-on:change="
            photoName = $refs.photo.files[0].name;
            const reader = new FileReader();
            reader.onload = (e) => {
                photoPreview = e.target.result;
            };
            reader.readAsDataURL($refs.photo.files[0]);
    ">
            

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
            {{--
            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('fdsfsdfsdf una nueva foto') }}
            </x-jet-secondary-button>
            --}}
            <label for="photo" class="mt-2 mr-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">Seleccione una nueva foto</label>

            @if ($this->user->profile_photo_path)
            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-jet-secondary-button>
            @endif

            <x-jet-input-error for="photo" class="mt-2" />
        </div>
        @endif



        <div class="row mt-5">

            {{-- nombre --}}
            <div class="col-4 mb-2">
                <x-jet-label for="name" value="{{ __('Nombres') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                    autocomplete="name" />
                @else
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                    autocomplete="name" readonly />
                @endif
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            {{-- apellido --}}
            <div class="col-4 mb-2">
                <x-jet-label for="lastname" value="{{ __('Apellidos') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="lastname" type="text" class="mt-1 block w-full" wire:model.defer="state.lastname"
                    autocomplete="lastname" />
                @else
                <x-jet-input id="lastname" type="text" class="mt-1 block w-full" wire:model.defer="state.lastname"
                    autocomplete="lastname" readonly />
                @endif
                <x-jet-input-error for="lastname" class="mt-2" />
            </div>
            {{-- nacimiento --}}
            <div class="col-4 mb-2">
                <x-jet-label for="birth" value="{{ __('Fecha de nacimiento') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="birth" type="date" class="mt-1 block w-full" wire:model.defer="state.birth"
                    autocomplete="birth" />
                @else
                <x-jet-input id="birth" type="date" class="mt-1 block w-full" wire:model.defer="state.birth"
                    autocomplete="birth" readonly />
                @endif
                <x-jet-input-error for="birth" class="mt-2" />
            </div>
            {{-- Tipo de documento --}}
            <div class="col-2">
                <x-jet-label for="document_type" value="{{ __('Tipo de documento') }}" />
                @if (Auth::user()->verify == '0')
                <select id="document_type" type="number" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="state.document_type" >
                    <option value="0" @if(Auth::user()->document_type == '0') selected  @endif>DNI</option>
                    <option value="1" @if(Auth::user()->document_type == '1') selected  @endif>Pasaporte</option>
                </select>
                @else
                @if (Auth::user()->document_type == '0')
                <input type="text" readonly class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" value="DNI">
                @else
                <input type="text" readonly class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" value="Pasaporte">
                @endif
            @endif
                <x-jet-input-error for="document_type" class="mt-2" />
            </div>
            {{-- Número del documento --}}
            <div class="col-2 mb-2">
                <x-jet-label for="dni" value="{{ __('N° del documento') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="dni" type="text" class="mt-1 block w-full" wire:model.defer="state.dni"
                    autocomplete="dni" />
                @else
                <x-jet-input id="dni" type="text" class="mt-1 block w-full" wire:model.defer="state.dni"
                    autocomplete="dni" readonly />
                @endif
                <x-jet-input-error for="dni" class="mt-2" />
            </div>
            {{-- Fecha de vencimiento del documento --}}
            <div class="col-4 mb-2">
                <x-jet-label for="dni_expedition" value="{{ __('Fecha de expedicion del documento') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="dni_expedition" type="date" class="mt-1 block w-full"
                    wire:model.defer="state.dni_expedition" autocomplete="dni_expedition" />
                @else
                <x-jet-input id="dni_expedition" type="date" class="mt-1 block w-full"
                    wire:model.defer="state.dni_expedition" autocomplete="dni_expedition" readonly />
                @endif
                <x-jet-input-error for="dni_expedition" class="mt-2" />
            </div>
            {{-- Ciudad de expedición del documento --}}
            <div class="col-4 mb-2">
                <x-jet-label for="city_dni" value="{{ __('Ciudad de expedición del documento') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="city_dni" type="text" class="mt-1 block w-full" wire:model.defer="state.city_dni" />
                @else
                <x-jet-input id="city_dni" type="text" class="mt-1 block w-full" wire:model.defer="state.city_dni"
                    readonly />
                @endif
                <x-jet-input-error for="city_dni" class="mt-2" />
            </div>
            
            {{-- Foto del documento front--}}
            @if (Auth::user()->verify == '0')
            <div class="col-12 mt-3 d-flex justify-content-center row">
                <x-jet-label for="photo_dni_front" value="{{ __('Foto de documento parte frontal') }}" class="col-6 mb-2" />
                <x-jet-input id="photo_dni_front" type="file" class="col-6" wire:model.defer="state.photo_dni_front"
                    autocomplete="photo_dni_front" accept="image/*" />
                <img id="photo_preview_f" class="img-fluid col-6 mt-3 mb-5" />
                <x-jet-input-error for="photo_dni_front" class="mt-2" />
            </div>
            @endif

            {{-- Foto del documento back--}}
            @if (Auth::user()->verify == '0')
            <div class="col-12 mt-3 d-flex justify-content-center row">
                <x-jet-label for="photo_dni_back" value="{{ __('Foto de documento parte trasera') }}" class="col-6 mb-2" />
                <x-jet-input id="photo_dni_back" type="file" class="col-6" wire:model.defer="state.photo_dni_back"
                accept="image/*" />
                <img id="photo_preview_b" class="img-fluid col-6 mt-3 mb-5" />
                <x-jet-input-error for="photo_dni_back" class="mt-2" />
            </div>
            @endif

            {{-- Selfie con el documento--}}
            @if (Auth::user()->verify == '0')
            <div class="col-12 mt-3 d-flex justify-content-center row">
                <x-jet-label for="selfie_document" value="{{ __('Selfie con el documento') }}" class="col-6 mb-2" />
                <x-jet-input id="selfie_document" type="file" class="col-6" wire:model.defer="state.selfie_document" accept="image/*" />
                <img id="selfie_d" class="img-fluid col-6 mt-3 mb-5" />
                <x-jet-input-error for="selfie_document" class="mt-2" />
            </div>
            @endif

            {{-- Correo electrónico --}}
            <div class="col-4 mb-2">
                <x-jet-label for="email" value="{{ __('Correo electrónico') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                @else
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email"
                    readonly />
                @endif
                <x-jet-input-error for="email" class="mt-2" />
            </div>
            {{-- Teléfono fijo --}}
            <div class="col-4 mb-2">
                <x-jet-label for="phone" value="{{ __('Teléfono fijo') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="state.phone" />
                @else
                <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="state.phone" readonly />
                @endif
                <x-jet-input-error for="phone" class="mt-2" />
            </div>
            {{-- Teléfono Móvil --}}
            <div class="col-4 mb-2">
                <x-jet-label for="mobile_phone" value="{{ __('Teléfono Móvil') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="mobile_phone" type="text" class="mt-1 block w-full"
                    wire:model.defer="state.mobile_phone" />
                @else
                <x-jet-input id="mobile_phone" type="text" class="mt-1 block w-full"
                    wire:model.defer="state.mobile_phone" readonly />
                @endif
                <x-jet-input-error for="mobile_phone" class="mt-2" />
            </div>

            {{-- Zona para editar la Información de Vivienda --}}
            <h3 class="mt-3 mb-2 font-bold col-12 text-center">Información de Vivienda</h3>

            <div class="col-3">
                <x-jet-label for="country_id" value="{{ __('Nacionalidad') }}" />
                @if (Auth::user()->verify == '0')
                <select id="country_id" type="number" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="state.country_id" >
                    @foreach ( $country as $item)
                    <option value="{{ $item->id}}">{{ $item->name}}</option>
                    @endforeach
            </select>
                @else
            <input type="text" readonly class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" value="{{ Auth::user()->countrie->name }}">
                @endif
                <x-jet-input-error for="country_id" class="mt-2" />
            </div>

            <div class="col-3">
                <x-jet-label for="district" value="{{ __('Barrio') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="district" type="text" class="mt-1 block w-full" wire:model.defer="state.district" />
                @else
                <x-jet-input id="district" type="text" class="mt-1 block w-full" wire:model.defer="state.district"
                    readonly />
                @endif
                <x-jet-input-error for="district" class="mt-2" />
            </div>

            <div class="col-3">
                <x-jet-label for="city" value="{{ __('Ciudad') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="state.city" />
                @else
                <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="state.city" readonly />
                @endif
                <x-jet-input-error for="city" class="mt-2" />
            </div>

            <div class="col-3">
                <x-jet-label for="department" value="{{ __('Departamento') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="department" type="text" class="mt-1 block w-full"
                    wire:model.defer="state.department" />
                @else
                <x-jet-input id="department" type="text" class="mt-1 block w-full" wire:model.defer="state.department"
                    readonly />
                @endif
                <x-jet-input-error for="department" class="mt-2" />
            </div>

            <div class="col-12 mt-1">
                <x-jet-label for="address" value="{{ __('Dirección') }}" />
                @if (Auth::user()->verify == '0')
                <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="state.address" />
                @else
                <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="state.address"
                    readonly />
                @endif
                <x-jet-input-error for="address" class="mt-2" />
            </div>


            @if (Auth::user()->verify == '0')
            <div class="col-12 mt-3 d-flex justify-content-center row">
                <x-jet-label for="photo_document" class="col-6 mb-2"
                    value="{{ __('Recibo de servicios / Extracto bancario / Recibo de teléfono') }}" />
                <x-jet-input id="photo_document" type="file" class="col-6"
                    wire:model.defer="state.photo_document"
                    accept="image/*" />
            <img id="photo_preview2" class="img-fluid col-8 mt-3" />
                <x-jet-input-error for="photo_document" class="mt-2" />
            </div>
            @endif
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

{{-- modal --}}
@if (Auth::user()->verify == 0)
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">!!! IMPORTANTE !!!</h5>
          {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> --}}
        </div>
        <div class="modal-body">
        @if (Auth::user()->dni == NULL)
        <p>Despues de llenar sus datos, sera enviado a revision donde un administrador lo revisara detalladamente.</p><br>
        <p><span class="font-bold">Si sus datos tiene algun detalle:</span> El administrador le dejara un mensaje en esta modal, comentando el error de sus datos</p><br>
        <p><span class="font-bold">Si se aprueban sus datos:</span> Su cuenta ya estara verificada y lista para invertir</p><br>
        <span class="text-danger font-bold">Sea consiente que despues de aprobar sus datos y su cuenta este ya verificada, !NO! podra volver a cambiar los datos</span>
        @elseif(Auth::user()->dni != NULL && Auth::user()->msj_admin != NULL)
        <span class="text-danger font-bold">{{ Auth::user()->msj_admin }}</span>
        @elseif(Auth::user()->msj_admin == NULL)
        <span class="text-danger font-bold">Procesando datos</span>
        @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar y continuar</button>
        </div>
      </div>
    </div>
  </div>
@endif
