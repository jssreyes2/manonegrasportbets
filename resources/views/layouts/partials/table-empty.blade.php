{{--
    Fila de "sin resultados" dentro de una tabla. Recibe $colspan y, opcional, $emptyText,
    $actionUrl y $actionLabel para ofrecer el siguiente paso (por ejemplo "Ver planes").
--}}
<tr class="tbh-empty-row">
    <td colspan="{{ $colspan }}">
        <div class="tbh-empty">
            <i class="fas {{ empty($emptyText) ? 'fa-search' : 'fa-inbox' }}"></i>
            <div>{{ $emptyText ?? __t('text.backend.messages.alert_table', 'No se encontraron resultados.') }}</div>
            @if(request()->has('filter'))
                <small>{{ __t('text.backend.messages.try_other_filters', 'Prueba con otros filtros o límpialos para ver todo.') }}</small>
            @endif
            @if(!empty($actionUrl))
                <a href="{{ $actionUrl }}" class="btn btn-brand btn-sm mt-3">{{ $actionLabel }}</a>
            @endif
        </div>
    </td>
</tr>
