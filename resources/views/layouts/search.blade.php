
<div class="form-group {{$colLg ?? 'col-lg-6'}} col-md-6 col-sm-6 col-12">
    <label for="search">Buscar</label>
    <input type="text" class="form-control" id="search" name="filter[search]" value='{{(isset($filter['search']) ? $filter['search'] : '')}}' autocomplete="off">
</div>

@if(!isset($doNotShowStatus))
    <div class="form-group {{$colLg ?? 'col-lg-6'}} col-md-6 col-sm-6 col-12">
        <label for="is_active">Estatus</label>
        <select class='form-control' id='is_active' name="filter[is_active]">
            <option value=''>Seleccione...</option>
            <option value='1' {{ (array_key_exists('is_active', $filter) && $filter['is_active'] === '1') ? 'selected' : '' }}>
                Activo
            </option>
            <option value='0' {{ (array_key_exists('is_active', $filter) && $filter['is_active'] === '0') ? 'selected' : '' }}>
                Inactivo
            </option>
        </select>
    </div>
@endif

