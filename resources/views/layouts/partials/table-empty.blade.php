{{-- Fila de "sin resultados" dentro de una tabla. Recibe $colspan --}}
<tr class="tbh-empty-row">
    <td colspan="{{ $colspan }}">
        <div class="tbh-empty">
            <i class="fas fa-search"></i>
            <div>{{ __t('text.backend.messages.alert_table', 'No se encontraron resultados.') }}</div>
            @if(request()->has('filter'))
                <small>{{ __t('text.backend.messages.try_other_filters', 'Prueba con otros filtros o límpialos para ver todo.') }}</small>
            @endif
        </div>
    </td>
</tr>
