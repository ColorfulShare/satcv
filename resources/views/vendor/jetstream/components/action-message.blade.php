@props(['on'])
<div x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; toastr['success'](
        'Tus cambios se han guardado satisfactoriamente',
        'Cambios Guardados!',
        {
          closeButton: true,
          tapToDismiss: false
        }
      ); window.location.href = '{{ route('dashboard')}}'; timeout = setTimeout(() => { shown = false }, 2000);  })"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    style="display: none;"
    {{ $attributes->merge(['class' => 'text-sm text-gray-600']) }}>
    {{ $slot->isEmpty() ? 'Saved.' : $slot }}
</div>