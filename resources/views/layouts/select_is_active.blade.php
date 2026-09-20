<label for="is_active">Estatus *</label>
<select class='form-control' id='is_active' name="is_active">
    <option value='1' {{((isset($item) and $item->is_active==status_register($item->is_active)) ?  'selected': '')}}>
        {{status_register(1)}}
    </option>

    <option value='0' {{((isset($item) and empty($item->is_active)) ?  'selected': '')}}>
        {{status_register(0)}}
    </option>
</select>