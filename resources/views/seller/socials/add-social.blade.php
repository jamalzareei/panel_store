@extends('layouts/master')

@section('head')
    
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('footer')
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script>
    
    $(".select2").select2({
        dir: "rtl",
        
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        templateResult: iconFormat,
        templateSelection: iconFormat,
        escapeMarkup: function(es) { return es; }
    });

    function iconFormat(icon) {
        var originalOption = icon.element;
        if (!icon.id) { return icon.text; }
        // var $icon = "<i class='" + $(icon.element).data('icon') + "'></i>" + icon.text;
        var $icon = $(icon.element).data('icon') + icon.text;


        return $icon;
    }
</script>
@endsection

@section('content')
    
<section id="basic-vertical-layouts">
    <div class="row match-height">

        <div class="col-md-12">
            <section id="number-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$title}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="col-12 mt-3">
                                    <h5>اضافه کردن</h5>
                                    <form class="ajaxForm" action="{{ route('seller.social.add.post') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                
                                                <label for="">انتخاب شبکه اجتماعی</label>
                                                <select name="social_id" data-placeholder="انتخاب نمایید" class="select2-icons form-control select2" id="select2-icons">
                                                    @foreach($socials as $social)
                                                        <option value="{{$social->id}}" data-icon="{{$social->icon}}"> {{$social->name}}</option>
                                                    @endforeach
                                                </select>
                                                <small class="help-block text-danger error-social_id"></small>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">نام کاربری </label>
                                                <div class="input-group">
                                                    <input type="text" dir="ltr" class="form-control" name="username" placeholder="نام کاربری">
                                                </div>
                                                <small class="help-block text-danger error-username"></small>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="">لینک </label>
                                                <div class="input-group">
                                                    <input type="text" dir="ltr" class="form-control" name="url" placeholder="لینک">
                                                </div>
                                                <small class="help-block text-danger error-url"></small>
                                            </div>
                                            <div class="col-md-1">
                                                <label for=""></label>
                                                <div class="input-group">
                                                    <button type="submit" class="btn btn-icon btn-icon rounded-circle btn-warning mr-1 mb-1 waves-effect waves-light">
                                                        <i class="vs-icon feather icon-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <h5> لیست </h5>
                                    <div id="load-data-ajax">
                                        {!!$listSocials!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>


@endsection