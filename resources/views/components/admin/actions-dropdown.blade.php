@props([
    'item',
    'route' => null,
    'edit' => true,
    'delete' => true,
    'comment' => false,
    'showDelete' => true,
    'customButtons' => [],
    'tableComment' => []
])

<div class="btn-group">
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu" role="menu">
        @if($edit)
            <a class="dropdown-item edit_form" data-id="{{$item->id}}" data-url="{{ route("$route.edit") }}"> <i class="fas fa-edit text-info"></i> Editar</a>
        @endif

        @if($delete)
            <a class="dropdown-item confirm_action" href="javascript:void(0)" data-id="{{$item->id}}" data-name="{{ route("$route.destroy") }}"> <i class="fas fa-trash text-danger"></i> Eliminar</a>
        @endif

        @if($comment)
            @if(!$item->answered)
                <a class="dropdown-item edit_form" data-id="{{$item->id}}" data-url="{{route('comment.response')}}">Ver y Responder</a>
            @else
                <a class="dropdown-item edit_form" data-id="{{$item->id}}" data-url="{{route('comment.response')}}">Ver</a>
            @endif
        @endif

    </div>
</div>