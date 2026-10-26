{{--
    Campo de la web pública con etiqueta, icono, error bajo el campo y, si es password, botón de ojo.
    Los atributos extra (required, autocomplete, inputmode, maxlength...) pasan directo al <input>.
--}}
@props([
    'name',
    'label',
    'type'  => 'text',
    'id'    => null,
    'icon'  => null,
    'hint'  => null,
    'value' => null,
])

@php
    $id = $id ?? $name;
    // Errores de formularios enviados sin AJAX (recuperar contraseña)
    $serverError = isset($errors) ? $errors->first($name) : null;
@endphp

<div class="space-y-1.5" data-field>
    <label for="{{ $id }}" class="tbh-label">{{ $label }}</label>
    <div class="tbh-field-box {{ $serverError ? 'is-invalid' : '' }} relative bg-black/60 border border-neutral-800 rounded-xl flex items-center px-3.5 py-3 transition-all neon-border-focus">
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 text-neutral-500 shrink-0 mr-3" aria-hidden="true"></i>
        @endif

        <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" @if(!is_null($value)) value="{{ $value }}" @endif
               @if($serverError) aria-invalid="true" aria-describedby="{{ $id }}-error" @elseif($hint) aria-describedby="{{ $id }}-hint" @endif
               {{ $attributes->merge(['class' => 'w-full bg-transparent text-sm text-white placeholder-neutral-600 focus:outline-none']) }}>

        @if($type === 'password')
            <button type="button" data-toggle-password="{{ $id }}" aria-pressed="false" aria-label="{{ __t('text.frontend.ux.show_password') }}"
                    class="ml-2 p-1 rounded-md text-neutral-500 hover:text-lime-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-lime-400">
                <i data-eye-open data-lucide="eye" class="w-4 h-4"></i>
                <i data-eye-closed data-lucide="eye-off" class="w-4 h-4 hidden"></i>
            </button>
        @endif
    </div>

    {{ $slot }}

    @if($hint)
        <p id="{{ $id }}-hint" class="tbh-field-hint">{{ $hint }}</p>
    @endif
    <p data-error id="{{ $id }}-error" class="tbh-field-error" aria-live="polite" @unless($serverError) hidden @endunless>{{ $serverError }}</p>
</div>
