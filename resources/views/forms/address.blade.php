<hr/>
<div class="form-group m-form__group">
    <div class="col-xs-12">
        <h6>{{__('titles.add_address')}}</h6>
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-2">
        <label for="zipcode">{{__('labels.zipcode')}}</label>
        <input type="text" class="form-control m-input" name="zipcode" id="zipcode"
               data-validation="notempty($(this))" data-label="{{__('labels.zipcode')}}"
               data-error="{{__('labels.field_not_empty')}}"
               placeholder="{{__('labels.zipcode')}}">
    </div>
    <div class="col-md-4">
        <label for="state">{{__('labels.state')}}</label>
        <select class="form-control m-input m-input--square" name="state"
                id="state"
                data-validation="notempty($(this))"
                data-label="{{__('labels.state')}}"
                data-error="{{__('labels.field_not_empty')}}">
            <option disabled selected>{{__('labels.select')}}</option>
            {{--@foreach($states as $key => $state)--}}
            {{--<option value="{{$key}}">{{$state}}</option>--}}
            {{--@endforeach--}}
        </select>
    </div>
    <div class="col-md-4">
        <label for="city">{{__('labels.city')}}</label>
        <input type="text" class="form-control m-input" name="city" id="city"
               data-validation="notempty($(this))" data-label="{{__('labels.city')}}"
               data-error="{{__('labels.field_not_empty')}}"
               placeholder="{{__('labels.city')}}">
    </div>
    <div class="col-md-2">
        <label for="number">{{__('labels.number')}}</label>
        <input type="text" class="form-control m-input" name="number" id="number"
               data-validation="notempty($(this))" data-label="{{__('labels.number')}}"
               data-error="{{__('labels.field_not_empty')}}"
               placeholder="{{__('labels.number')}}">
    </div>
</div>
<div class="form-group m-form__group row">
    <div class="col-md-4">
        <label for="address">{{__('labels.address')}}</label>
        <input type="text" class="form-control m-input" name="address" id="address"
               data-validation="notempty($(this))" data-label="{{__('labels.address')}}"
               data-error="{{__('labels.field_not_empty')}}"
               placeholder="{{__('labels.address')}}">
    </div>

    <div class="col-md-4">
        <label for="complement">{{__('labels.complement')}}</label>
        <input type="text" class="form-control m-input" name="complement" id="complement"
               data-label="{{__('labels.complement')}}"
               placeholder="{{__('labels.complement')}}">
    </div>
    <div class="col-md-4">
        <label for="district">{{__('labels.district')}}</label>
        <input type="text" class="form-control m-input" name="district" id="district"
               data-validation="notempty($(this))" data-label="{{__('labels.district')}}"
               data-error="{{__('labels.field_not_empty')}}"
               placeholder="{{__('labels.district')}}">

    </div>
</div>
