@php
    $filterArray = [];
  if (is_array($filter)) {
      $filterArray = $filter;
  } elseif (is_string($filter) && !empty($filter)) {
      $filterArray = json_decode($filter, true) ?? [];
  }

@endphp

<form method="GET" class="mb-3">
    <div class="row">
        <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
            <input type="text" name="filter[search]" class="form-control" placeholder="{{ $searchPlaceholder ?? 'Buscar...' }}" value="{{($filterArray['search'] ?? '')}}" autocomplete="off">
        </div>

        @if(isset($showStatus) && $showStatus)
            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                <select class='form-control' id='is_active' name="filter[is_active]">
                    <option value=''>Todos los Estatus...</option>
                    <option value='1' {{ (array_key_exists('is_active', $filterArray) && $filterArray['is_active'] === '1') ? 'selected' : '' }}>
                        Activo
                    </option>
                    <option value='0' {{ (array_key_exists('is_active', $filterArray) && $filterArray['is_active'] === '0') ? 'selected' : '' }}>
                        Inactivo
                    </option>
                </select>
            </div>
        @endif

        @if(isset($extraFilterPlans) && $extraFilterPlans)
            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                <select class='form-control' id='subscription_plan' name="filter[subscription_plan]">
                    <option value=''>Todos los Planes...</option>

                    @foreach($plans AS $plan)
                        <option value='{{$plan->source}}' {{ (array_key_exists('subscription_plan', $filterArray) && $filterArray['subscription_plan'] === $plan->source) ? 'selected' : '' }}>
                            {{capitalize_first($plan->name)}}
                        </option>
                    @endforeach

                </select>
            </div>
        @endif

        @if(isset($extraFilterStatus) && $extraFilterStatus)
            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                <select class='form-control' id='subscription_status' name="filter[subscription_status]">
                    <option value=''>Todos los Estatus...</option>
                    <option value='active' {{ (array_key_exists('subscription_status', $filterArray) && $filterArray['subscription_status'] === 'active') ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value='expirado' {{ (array_key_exists('subscription_status', $filterArray) && $filterArray['subscription_status'] === 'expirado') ? 'selected' : '' }}>
                        Expirado
                    </option>
                </select>
            </div>
        @endif

        @if(isset($extraFilterPageStatic) && $extraFilterPageStatic)
            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                <select class='form-control' id='type' name="filter[type]">
                    @foreach(staticPageTypes() AS $key=> $staticPage)
                        <option value="{{$key}}" {{ (array_key_exists('type', $filterArray) && $filterArray['type'] === $key) ? 'selected' : '' }}>{{$staticPage}}</option>
                    @endforeach

                </select>
            </div>
        @endif

        @if(isset($extraFilterLanguage) && $extraFilterLanguage)
            <x-admin.select-language/>
        @endif

        @if(isset($dateFilter))

            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                <input type="text" name="filter[start_date]" class="form-control date" placeholder="{{__t('text.backend.forms.start_date', 'Start Date')}}" value="{{($filterArray['start_date'] ?? '')}}" autocomplete="off">
            </div>

            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                <input type="text" name="filter[end_date]" class="form-control date" placeholder="{{__t('text.backend.forms.end_date', 'End Date')}}" value="{{($filterArray['end_date'] ?? '')}}" autocomplete="off">
            </div>

        @endif

        @if(isset($extraFilterStatusPick) && $extraFilterStatusPick)
            <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
                <select class='form-control' id='input_status' name="filter[input_status]">
                    <option value=''>{{__t('text.backend.tables.all_statuses', 'Todos los Estatus...')}}</option>
                    <option value='1' {{ (array_key_exists('input_status', $filterArray) && $filterArray['input_status'] === 1) ? 'selected' : '' }}>
                        {{__t('text.backend.tables.successful', 'Exitoso')}}
                    </option>
                    <option value='0' {{ (array_key_exists('input_status', $filterArray) && ($filterArray['input_status']!==null && (int)$filterArray['input_status'] ===0)) ? 'selected' : '' }}>
                        {{__t('text.backend.tables.failed', 'Fallido')}}
                    </option>
                </select>
            </div>
        @endif

        <div class="col-md-auto">
            <button type="submit" class="btn btn-outline-info"><i class="fas fa-search"></i> {{__t('text.backend.forms.search', 'Buscar')}}</button>
            <a href="{{ $clearRoute }}" class="btn btn-outline-secondary"><i class="fas fa-redo"></i> {{__t('text.backend.forms.cancel', 'Cancelar')}}</a>
        </div>
    </div>
</form>
