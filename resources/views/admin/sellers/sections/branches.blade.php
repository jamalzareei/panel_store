

@forelse ($seller->branches as $key => $branch)
<div class="row ">
            
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">عنوان نمایشی</label>
            <input type="text" placeholder="عنوان نمایشی" class="form-control" id="title" name="title" value="{{$branch->title}}">
            <small class="help-block text-danger error-title"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="manager">نام مدیریت شعبه</label>
            <input type="text" placeholder="نام مدیریت شعبه" class="form-control" id="manager" name="manager" value="{{$branch->manager}}">
            <small class="help-block text-danger error-manager"></small>
        </div>
    </div>

    <div class="col-md-12">
        <fieldset>
            <div class="vs-checkbox-con vs-checkbox-primary">
                <input type="checkbox" name="actived_at" {{($branch->actived_at) ? 'checked' : ''}} value="1">
                <span class="vs-checkbox">
                    <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check"></i>
                    </span>
                </span>
            <span class="">فعال </span>
            </div>
        </fieldset>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="password-icon">آدرس</label>
            @include('components.sections.location', ['countries' => $countries, 'country' => $branch->country ?? null, 'state' => $branch->state ?? null, 'city' => $branch->city ?? null])
            <small class="help-block text-danger error-country_id"></small>
            <small class="help-block text-danger error-state_id"></small>
            <small class="help-block text-danger error-city_id"></small>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="address">آدرس کامل شعبه :</label>
            <textarea placeholder="آدرس کامل شعبه" id="address" name="address" rows="5" class="form-control">{{ $branch->address }}</textarea>
            <small class="help-block text-danger error-address"></small>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="phones">شماره های تماس :</label>
            <input type="text" placeholder="شماره های تماس" data-role="tagsinput" class="form-control" id="phones" name="phones" value="{{ $branch->phones }}">
            <small class="help-block text-danger error-phones"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" placeholder="latitude" class="form-control" id="latitude" name="latitude" value="{{ $latitude ?? '31.87067197598904'}}">
            <small class="help-block text-danger error-latitude"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" placeholder="Longitude" class="form-control" id="longitude" name="longitude" value="{{ $longitude ?? '54.36171474738359'}}">
            <small class="help-block text-danger error-longitude"></small>
        </div>
    </div>
</div>
@empty
    
@endforelse
