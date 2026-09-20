@props([
    'action',
    'method',
    'title',
    'cancelRoute',
    'cardType' => 'info',
    'frmId' => ''
])

<div class="card card-{{ $cardType }} card-outline">
    @if($title)
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            @if(isset($tools))
                <div class="card-tools">{{ $tools }}</div>
            @endif
        </div>
    @endif

    <form id="{{$frmId}}" action="{{ $action }}" method="POST">
        @csrf

        @if(isset($method) && in_array(strtoupper($method), ['PUT','PATCH','DELETE']))
            @method($method)
        @endif

        <div class="card-body">
            <div class="row">
                {{ $slot }}
            </div>
        </div>

        @include('admin.partials.form-buttons', ['cancelRoute' => $cancelRoute])
    </form>
</div>