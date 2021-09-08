@push('custom_js')
<script>
    $(document).ready(function() {
        
        @if($this->user->photo_dni_front !== NULL)
            previewPersistedFile("{{asset('storage/'.$this->user->photo_dni_front)}}", 'photo_preview_f');
        @endif

        @if($this->user->photo_dni_back !== NULL)
            previewPersistedFile("{{asset('storage/'.$this->user->photo_dni_back)}}", 'photo_preview_b');
        @endif

        @if($this->user->photo_document !== NULL)
        previewPersistedFile("{{asset('storage/'.$this->user->photo_document)}}", 'photo_preview2');
        @endif
    });

    function previewFile(input, preview_id) {
        // if (input.files && input.files[0]) {
        //     var reader = new FileReader();
        //     reader.onload = function(e) {
        //         $("#" + preview_id).attr('src', e.target.result);
        //         $("#" + preview_id).css('height', '200px');
        //         $("#" + preview_id).parent().parent().removeClass('d-none');
        //     }
        //     $("label[for='" + $(input).attr('id') + "']").text(input.files[0].name);
        //     reader.readAsDataURL(input.files[0]);          
        // }
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
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{photoName: null, photoPreview: null}" class="col-12 row flex-column align-items-center">
            <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

            <x-jet-label for="photo" value="{{ __('Foto') }}" />

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

        <div class="row mt-5">
            <div x-data="{photoName: null, photoPreview: null}" class="col-12 row flex-column align-items-center"> 
            

                {{-- <x-jet-input id="photo_dni_front" type="file" class="col-6" wire:model.defer="state.photo_dni_front" autocomplete="photo_dni_front" onchange="previewFile(this, 'photo_preview_f')" accept="image/*" /> --}}
                {{-- <x-jet-label for="photo" value="{{ __('Foto') }}" />

                <div class="mt-2" x-show="photoPreview">
                    <span class="img-fluid col-6 mt-3" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"> </span>
                </div>

                <div class="custom-file"> 
                    <label class="custom-file-label" for="img_ad">Selecciona una imagen</label>
                    <input type="file" class="custom-file-input" wire:model.defer="state.photo_dni_front" x-ref="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);" />  
                </div> --}}


                {{-- <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Seleccione una nueva foto') }}
                </x-jet-secondary-button> --}}

                <x-jet-label for="photo" value="{{ __('Foto') }}" />

                <div class="mt-2" x-show="photoPreview">
                    <span class="block w-20 h-20" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\'); width: 350px; height: 250px;'"> </span>
                </div>

                <div class="custom-file mt-4"> 
                    <label class="custom-file-label" for="img_ad">Selecciona una imagen</label>
                    {{-- <input type="file" class="custom-file-input" wire:model.defer="state.photo_dni_front" x-ref="photo" x-on:change="
                    photoName = $refs.photo.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        photoPreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.photo.files[0]);" />   --}}
                    <input type="file" class="custom-file-input" wire:model.defer="state.photo_dni_front" x-ref="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);" />  
                </div>
            </div>

            {{-- <div class="form-group mb-5">
                <label class="required">
                    Imagen principal del Anuncio
                </label>
                <div class="row mb-4 d-none" id="icon_preview_wrapper">
                    <div class="col"></div>
                    <div class="col-auto">
                        <img id="ico_preview" class="img-fluid rounded" />
                    </div>
                    <div class="col"></div>
                </div>
                <div class="custom-file">
                    <label class="custom-file-label" for="img_ad">Selecciona una imagen</label>
                    <input type="file" id="img_ad"
                        class="custom-file-input @error('img_ad') is-invalid @enderror"
                        name="img_ad" onchange="previewFile(this, 'ico_preview')"
                        accept="image/*">
                    @error('img_ad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> --}}


            {{-- @if (Auth::user()->verify == '0')
            <div class="col-12 mt-3 d-flex justify-content-center row">
                <x-jet-label for="photo_dni_front" value="{{ __('Foto de documento parte frontal') }}" class="col-6 mb-2" />
                <x-jet-input id="photo_dni_front" type="file" class="col-6" wire:model.defer="state.photo_dni_front"
                    autocomplete="photo_dni_front" onchange="previewFile(this, 'photo_preview_f')" accept="image/*" />
                <img id="photo_preview_f" class="img-fluid col-6 mt-3" />
                <x-jet-input-error for="photo_dni_front" class="mt-2" />
            </div>
            @endif --}}
{{-- 
            @if (Auth::user()->verify == '0')
            <div class="col-12 mt-3 d-flex justify-content-center row">
                <x-jet-label for="photo_dni_back" value="{{ __('Foto de documento parte trasera') }}" class="col-6 mb-2" />
                <x-jet-input id="photo_dni_back" type="file" class="col-6" wire:model.defer="state.photo_dni_back"
                    onchange="previewFile(this, 'photo_preview_b')" accept="image/*" />
                <img id="photo_preview_b" class="img-fluid col-6 mt-3" />
                <x-jet-input-error for="photo_dni_back" class="mt-2" />
            </div>
            @endif


            @if (Auth::user()->verify == '0')
            <div class="col-12 mt-3 d-flex justify-content-center row">
                <x-jet-label for="photo_document" class="col-6 mb-2"
                    value="{{ __('Recibo de servicios / Extracto bancario / Recibo de teléfono') }}" />
                <x-jet-input id="photo_document" type="file" class="col-6"
                    wire:model.defer="state.photo_document" onchange="previewFile(this, 'photo_preview2')"
                    accept="image/*" />
            <img id="photo_preview2" class="img-fluid col-8 mt-3" />
                <x-jet-input-error for="photo_document" class="mt-2" />
            </div>
            @endif --}}
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


