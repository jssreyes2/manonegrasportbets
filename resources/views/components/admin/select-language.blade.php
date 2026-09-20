@props([
    'form' => false,
    'item' => false,
])

@if($form)
    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
        <label for="type">Lenguaje *</label>
        <select class='form-control required inputform' id='language' name="language">
            @foreach(language() AS $language)
                <option value='{{$language}}' {{(isset($item) && $item && $item->language==$language) ?  'selected': ''}}>
                    {{$language}}
                </option>
            @endforeach
        </select>
    </div>
@endif

@if(!$form)
    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
        <select class='form-control' id='language' name="filter[language]">
            @foreach(language() AS $language)
                <option value='{{$language}}' {{ (isset($filterArray) && array_key_exists('language', $filterArray) && $filterArray['language'] === \App\Models\Country::LANGUAGE_EN) ? 'selected' : '' }}>
                    {{$language}}
                </option>
            @endforeach
        </select>
    </div>
@endif
