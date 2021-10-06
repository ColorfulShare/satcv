@extends('layouts/contentLayoutMaster')

@section('title', 'Información de Perfil')

@push('custom_css')
    <style>
        label:not([id="label_photo"]){
            width: 100%;;
        }

        img{
            display: inline;
        }
    </style>
@endpush

@section('content')
@php
$country = \App\Models\Country::all();  
@endphp
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{route('user.update')}}" enctype="multipart/form-data">
            <!-- Profile Photo -->
            
            @csrf
            <div class="col-12 row flex-column align-items-center">
            
                <input type="file" class="d-none" id="photo" name="photo">
            
                <label for="photo">{{ __('Foto') }}</label>
            
                <!-- Current Profile Photo -->
                @if ($user->profile_photo_path != NULL)
                    <div class="mt-0">
                        
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                            class="rounded-full h-20 w-20 object-cover" id="preview_photo">
                    </div>
                @else
                    <div class="mt-0">
                        <img src="https://ui-avatars.com/api/?background=random&name={{ $user->username }}"
                            alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover" id="preview_photo">
                    </div>
                @endif

                <!-- New Profile Photo Preview -->
                <label for="photo" class="mt-2 mr-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition" id="label_photo">Seleccione una nueva foto</label>

                <span for="photo" class="mt-2 span"> </>
            </div>
            
            <div class="row mt-5">

                {{-- nombre --}}
                <div class="col-4 mb-2">
                    <label for="name" >{{ __('Nombres') }}</>
                        
                    @if ($user->verify == '0')
            
                    <input name="name" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('name') != null ? old('name') : ($user->name != null? $user->name : null) }}"
                        ></>
                    @else
                    <input name="name" type="text" class="mt-1 block w-full form-control w-100"
                        autocomplete="name" readonly value="{{ old('name') != null ? old('name') : ($user->name != null? $user->name : null) }}"></>
                    @endif
                    <span for="name" class="mt-2"></>
                </div>
            {{-- apellido --}}
            <div class="col-4 mb-2">
                <label for="lastname">{{ __('Apellidos') }}</>
                @if ($user->verify == '0')
                <input name="lastname" type="text" class="mt-1 block w-full form-control w-100"
                    autocomplete="lastname" value="{{ old('lastname') != null ? old('lastname') : ($user->lastname != null? $user->lastname : null) }}"></>
                @else
                <input name="lastname" type="text" class="mt-1 block w-full form-control w-100"
                    autocomplete="lastname" readonly value="{{ old('lastname') != null ? old('lastname') : ($user->lastname != null? $user->lastname : null) }}"></>
                @endif
                <span for="lastname" class="mt-2"></>
            </div>
            {{-- nacimiento --}}
            <div class="col-4 mb-2">
                <label for="birth">{{ __('Fecha de nacimiento') }}</>
                @if ($user->verify == '0')
                <input name="birth" type="date" class="mt-1 block w-full form-control w-100"
                    autocomplete="birth" value="{{old('birth') != null ? old('birth') : ($user->birth != null? $user->birth : null) }}"></>
                @else
                <input name="birth" type="date" class="mt-1 block w-full form-control w-100"
                    autocomplete="birth" value="{{old('birth') != null ? old('birth') : ($user->birth != null? $user->birth : null) }}" readonly></>
                @endif
                <span for="birth" class="mt-2"></>
            </div>
            {{-- Tipo de documento --}}
            <div class="col-2">
                <label for="document_type">{{ __('Tipo de documento') }}</>
                @if ($user->verify == '0')
                    <select name="document_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control w-100" id="document_type">
                        <option value="">Seleccione un tipo de documento</option>
                        <option value="0" @if((old('document_type') != null && old('document_type') ==  '0' ) || $user->document_type == '0')  selected  @endif>DNI</option>
                        <option value="1" @if((old('document_type') != null && old('document_type') ==  '1' ) || $user->document_type == '1') selected  @endif>Pasaporte</option>
                        <option value="2" @if((old('document_type') != null && old('document_type') ==  '2' ) || $user->document_type == '2') selected  @endif>Cedula ciudadana</option>
                        <option value="3" @if((old('document_type') != null && old('document_type') ==  '3' ) || $user->document_type == '3') selected  @endif>Licencia de conducir</option>
                    </select>
                @else
                    @if ($user->document_type == '0')
                        <input name="document_type" type="text" readonly class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 form-control w-100" value="DNI">
                    @else
                        <input name="document_type" type="text" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm form-control w-100" value="Pasaporte">
                    @endif
                @endif
                <span for="document_type" class="mt-2"></>
            </div>
            {{-- Número del documento --}}
            <div class="col-2 mb-2">
                <label for="dni">{{ __('N° del documento') }}</>
                @if ($user->verify == '0')
                <input name="dni" type="text" class="mt-1 block w-full form-control w-100"
                    autocomplete="dni" value="{{old('dni') != null ? old('dni') : ($user->dni != null? $user->dni : null) }}"></>
                @else
                <input name="dni" type="text" class="mt-1 block w-full form-control w-100"
                    autocomplete="dni" readonly value="{{old('dni') != null ? old('dni') : ($user->dni != null? $user->dni : null) }}"></>
                @endif
                <span for="dni" class="mt-2"></>
            </div>
            {{-- Fecha de vencimiento del documento --}}
            <div class="col-4 mb-2">
                <label for="dni_expedition">{{ __('Fecha de expedicion del documento') }}</>
                @if ($user->verify == '0')
                <input name="dni_expedition" type="date" class="mt-1 block w-full form-control w-100" autocomplete="dni_expedition" value="{{old('dni_expedition') != null ? old('dni_expedition') : ($user->dni_expedition != null? $user->dni_expedition : null) }}"></>
                @else
                <input name="dni_expedition" type="date" class="mt-1 block w-full form-control w-100"
                    autocomplete="dni_expedition" value="{{old('dni_expedition') != null ? old('dni_expedition') : ($user->dni_expedition != null? $user->dni_expedition : null) }}" readonly></>
                @endif
                <span for="dni_expedition" class="mt-2"></>
            </div>
            {{-- Ciudad de expedición del documento --}}
            <div class="col-4 mb-2">
                <label for="city_dni">{{ __('Ciudad de expedición del documento') }}</>
                @if ($user->verify == '0')
                <input name="city_dni" type="text" class="mt-1 block w-full form-control w-100" value="{{old('city_dni') != null ? old('city_dni') : ($user->city_dni != null? $user->city_dni : null) }}"></>
                @else
                <input name="city_dni" type="text" class="mt-1 block w-full form-control w-100" value="{{old('city_dni') != null ? old('city_dni') : ($user->city_dni != null? $user->city_dni : null) }}" readonly></>
                @endif
                <span for="city_dni" class="mt-2"></>
            </div>
            <div class="row">
            {{-- Foto del documento front--}}
                @if ($user->verify == '0')
                    <div class="col-6 mt-3">
                        <label for="photo_dni_front" class="">{{ __('Foto de documento parte frontal') }}</>
                    </div>
                    <div class="col-6 mt-3">
                    
                        <input name="photo_dni_front" id="photo_dni_front" type="file" class="w-100"
                        autocomplete="photo_dni_front" accept="image/*"></>
                    </div>
                    <div class="col-12 text-center">
                        <img id="photo_preview_f" class=""></>
                        <span for="photo_dni_front" class=""></>
                    </div>
                @endif

            {{-- Foto del documento back--}}

                @if ($user->verify == '0')
                    <div id="box_dni_back" class="d-none col-12 row">
                        <div class="col-6 mt-3">
                            <label for="photo_dni_back" class="">{{ __('Foto de documento parte trasera') }}</>
                        </div>
                        <div class="col-6 mt-3">
                        
                            <input name="photo_dni_back" id="photo_dni_back" type="file" class="w-100"
                            autocomplete="photo_dni_back" accept="image/*"></>
                        </div>
                        <div class="col-12 text-center">
                            <img id="photo_preview_b" class=""></>
                            <span for="photo_dni_back" class=""></>
                        </div>
                    </div>
                @endif

                {{-- Selfie con el documento--}}

                @if ($user->verify == '0')
                    <div class="col-6 mt-3">
                        <label for="selfie_document" class="">{{ __('Selfie con el documento') }}</>
                    </div>
                    <div class="col-6 mt-3">
                    
                        <input name="selfie_document" id="selfie_document" type="file" class="w-100"
                        autocomplete="selfie_document" accept="image/*"></>
                    </div>
                    <div class="col-12 text-center">
                        <img id="selfie_d" class=""></>
                        <span for="selfie_document" class=""></>
                    </div>
                @endif
    
            </div>
            {{-- Correo electrónico --}}
            <div class="col-4 mb-2">
                <label for="email">{{ __('Correo electrónico') }}</>
                @if ($user->verify == '0')
                <input name="email" value="{{ old('email') != null ? old('email') : ($user->email != null? $user->email : null) }}" id="email" type="email" class="mt-1 block w-full form-control w-100"></>
                @else
                <input name="email" id="email" type="email" class="mt-1 block w-full form-control w-100"
                    readonly value="{{ old('email') != null ? old('email') : ($user->email != null? $user->email : null) }}"></>
                @endif
                <span for="email" class="mt-2"></>
            </div>
            {{-- Teléfono fijo --}}
            <div class="col-4 mb-2">
                <label for="phone">{{ __('Teléfono fijo') }}</>
                @if ($user->verify == '0')
                <input name="phone" id="phone" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('phone') != null ? old('phone') : ($user->phone != null? $user->phone : null) }}"></>
                @else
                <input name="phone" id="phone" type="text" class="mt-1 block w-full form-control w-100" readonly value="{{ old('phone') != null ? old('phone') : ($user->phone != null? $user->phone : null) }}"></>
                @endif
                <span for="phone" class="mt-2"></>
            </div>
            {{-- Teléfono Móvil --}}
            <div class="col-4 mb-2">
                <label for="mobile_phone">{{ __('Teléfono Móvil') }}</>
                @if ($user->verify == '0')
                <input name="mobile_phone" id="mobile_phone" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('mobile_phone') != null ? old('mobile_phone') : ($user->mobile_phone != null? $user->mobile_phone : null) }}"></>
                @else
                <input name="mobile_phone" id="mobile_phone" type="text" class="mt-1 block w-full form-control w-100" readonly value="{{ old('mobile_phone') != null ? old('mobile_phone') : ($user->mobile_phone != null? $user->mobile_phone : null) }}"></>
                @endif
                <span for="mobile_phone" class="mt-2"></>
            </div>

            {{-- Zona para editar la Información de Vivienda --}}
            <h3 class="mt-3 mb-2 font-bold col-12 text-center">Información de Vivienda</h3>

            <div class="col-3">
                <label for="country_id" >{{ __('Nacionalidad') }}</>
                @if ($user->verify == '0')
                <select name="country_id" id="country_id" type="number" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control w-100">
                    <option value="">Seleccione una nacionalidad</option>
                    @foreach ( $country as $item)
                    <option @if((old('country_id') != null && old('country_id') ==  $item->id ) || $user->country_id == $item->id)  selected  @endif value="{{ $item->id}}">{{ $item->name}}</option>
                    @endforeach
            </select>
                @else
            <input type="text" readonly class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm form-control w-100" value="{{ old('country_id') != null ? old('country_id') : ($user->countrie != null? $user->countrie->name : null) }}">
                @endif
                <span for="country_id" class="mt-2"></>
            </div>

            <div class="col-3">
                <label for="district">{{ __('Barrio') }}</>
                @if ($user->verify == '0')
                <input name="district" id="district" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('district') != null ? old('district') : ($user->district != null? $user->district : null) }}"></>
                @else
                <input id="district" type="text" class="mt-1 block w-full form-control w-100"
                    readonly value="{{ old('district') != null ? old('district') : ($user->district != null? $user->district : null) }}"></>
                @endif
                <span for="district" class="mt-2"></>
            </div>

            <div class="col-3">
                <label for="city">{{ __('Ciudad') }}</>
                @if ($user->verify == '0')
                <input name="city" id="city" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('city') != null ? old('city') : ($user->city != null? $user->city : null) }}"></>
                @else
                <input name="city" id="city" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('city') != null ? old('city') : ($user->city != null? $user->city : null) }}" readonly></>
                @endif
                <span for="city" class="mt-2"></>
            </div>

            <div class="col-3" id="box_department">
                <label for="department">{{ __('Departamento') }}</>
                @if ($user->verify == '0')
                <input name="department" id="department" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('department') != null ? old('department') : ($user->department != null? $user->department : null) }}"></>
                @else
                <input name="department" id="department" type="text" class="mt-1 block w-full form-control w-100" 
                    readonly value="{{ old('department') != null ? old('department') : ($user->department != null? $user->department : null) }}"></>
                @endif
                <span for="department" class="mt-2"></>
            </div>

            <div class="col-12 mt-1">
                <label for="address">{{ __('Dirección') }}</>
                @if ($user->verify == '0')
                <input name="address" id="address" type="text" class="mt-1 block w-full form-control w-100" value="{{ old('address') != null ? old('address') : ($user->address != null? $user->address : null) }}"></>
                @else
                <input name="address" id="address" type="text" class="mt-1 block w-full form-control w-100" 
                    readonly value="{{ old('address') != null ? old('address') : ($user->address != null? $user->address : null) }}"></>
                @endif
                <span for="address" class="mt-2"></>
            </div>

                @if ($user->verify == '0')
                    <div class="row w-100">
                    <div class="col-6 mt-3">
                        <label for="photo_document" class="">{{ __('Recibo de servicios / Extracto bancario / Recibo de teléfono') }}</>
                    </div>
                    <div class="col-6 mt-3">
                    
                        <input name="photo_document" id="photo_document" type="file" class="w-100"
                        autocomplete="photo_document" accept="image/*" value="{{ old('photo_document') != null ? old('photo_document') : ($user->photo_document != null? $user->photo_document : null) }}"></>
                    </div>
                    <div class="col-12 text-center">
                        <img id="photo_preview2" class=""></>
                        <span for="photo_document" class=""></>
                    </div>
                    </div>
                @endif
        
            </div>

            <div class="col-12" >
                <div class="float-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Guardar') }}
                    <button>
                </div>
            </div> 
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{route('user.updatePassword')}}" method="POST">
            @csrf
            <div>
                {{ __('Actualice su contraseña') }}
            </div>
        
            <div>
                {{ __('Asegure su cuenta usando una contraseña segura, el uso de números y carácteres especiales es recomendado para aumentar la fiabilidad.') }}
            </div>
            
            <div class="row">
                <div class="col-12">
                    <label for="current_password"></label>
                    <input name="mypassword" type="password" class="mt-1 form-control">
                    <span class="mt-2"></span>
                </div>

                <div class="col-12">
                    <label for=""></label>
                    <input name="password" type="password" class="mt-1 form-control">
                    <span class="mt-2"></span>
                </div>

                <div class="col-12">
                    <label for=""></label>
                    <input name="password_confirmation" type="password" class="mt-1 form-control">
                    <span class="mt-2"></span>
                </div>

                <div class="col-12 mt-3">
                    <div class="float-right">
                    <button class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
            {{--
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
                    <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
                    <x-jet-input-error for="current_password" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="password" value="{{ __('New Password') }}" />
                    <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
                    <x-jet-input-error for="password" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                    <x-jet-input-error for="password_confirmation" class="mt-2" />
                </div>
            </x-slot>
        
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>
        
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
            --}}
        </form>
    </div>
</div>

{{-- modal --}}
@if ($user->verify == 0)
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
      @if ($user->dni == NULL)
      <p>Despues de llenar sus datos, sera enviado a revision donde un administrador lo revisara detalladamente.</p><br>
      <p><span class="font-bold">Si sus datos tiene algun detalle:</span> El administrador le dejara un mensaje en esta modal, comentando el error de sus datos</p><br>
      <p><span class="font-bold">Si se aprueban sus datos:</span> Su cuenta ya estara verificada y lista para invertir</p><br>
      <span class="text-danger font-bold">Sea consiente que despues de aprobar sus datos y su cuenta este ya verificada, !NO! podra volver a cambiar los datos</span>
      @elseif($user->dni != NULL && $user->msj_admin != NULL)
      <span class="text-danger font-bold">{{ $user->msj_admin }}</span>
      @elseif($user->msj_admin == NULL)
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
@endsection

@section('page-script')

@endsection

@push('custom_js')
<script>
    $(document).ready(function() {
        
        @if($user->photo_dni_front !== NULL)
            previewPersistedFile("{{asset('storage/'.$user->photo_dni_front)}}", 'photo_preview_f');
        @endif
        
        @if($user->photo_dni_back !== NULL)
            previewPersistedFile("{{asset('storage/'.$user->photo_dni_back)}}", 'photo_preview_b');
        @endif
            
        @if($user->selfie_document !== NULL)
            previewPersistedFile("{{asset('storage/'.$user->selfie_document)}}", 'selfie_d');
        @endif

        @if($user->photo_document !== NULL)
        previewPersistedFile("{{asset('storage/'.$user->photo_document)}}", 'photo_preview2');
        @endif
    });

    function previewFile(input, preview_id) {
        //console.log(input)
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#" + preview_id).attr('src', e.target.result);
                //$("#" + preview_id).css('width', '200px');
                $("#" + preview_id).parent().parent().removeClass('d-none');
            }
            $("label[for='" + $(input).attr('id') + "']").text(input.files[0].name);
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewPersistedFile(url, preview_id) {
        $("#" + preview_id).attr('src', url);
        //$("#" + preview_id).css('height', '200px');
        //$("#" + preview_id).parent().parent().removeClass('d-none');
    }

    //eventos CHANGES
    let inputFoto = document.querySelector('#photo');
    let photo_dni_front = document.querySelector('#photo_dni_front');
    let photo_dni_back = document.querySelector('#photo_dni_back');
    let selfie_document = document.querySelector('#selfie_document');
    let photo_document = document.querySelector('#photo_document');

    inputFoto.addEventListener('change', function(e){ previewFile(e.target, 'preview_photo'); });
    photo_dni_front.addEventListener('change', function(e){ previewFile(e.target, 'photo_preview_f'); });
    photo_dni_back.addEventListener('change', function(e){ previewFile(e.target, 'photo_preview_b'); });
    selfie_document.addEventListener('change', function(e){ previewFile(e.target, 'selfie_d'); });
    photo_document.addEventListener('change', function(e){ previewFile(e.target, 'photo_preview2'); });

    let document_type = document.querySelector('#document_type');
    let box_dni_back = document.querySelector('#box_dni_back');
    
    document_type.addEventListener('change', function(e){
        console.log(e.target.value);
        if(e.target.value == 2 || e.target.value == 3){
            box_dni_back.classList.remove("d-none");
        }else{
            box_dni_back.classList.add("d-none");
        }
    });

    let country_id = document.querySelector('#country_id');
    let box_department = document.querySelector('#box_department');

    country_id.addEventListener('change', function(e){
        if(e.target.value == 42){
            box_department.classList.remove("d-none");
        }else{
            box_department.classList.add("d-none");
        }
    });
</script>

<script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>
@endpush



