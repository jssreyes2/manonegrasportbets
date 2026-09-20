
@if (isset($variable))
    <div class="d-flex" style="padding: 10px;">
        {{ $variable->appends(request()->input())->links('pagination::bootstrap-4') }}
    </div>
@endif
