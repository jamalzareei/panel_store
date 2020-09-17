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
        width: '100%'
    });
</script>
@endsection

@section('content')
    
<section id="basic-vertical-layouts">
    <div class="row match-height">

        <div class="col-md-12 col-12">
            <section id="number-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$title}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="info-tab-fill" data-toggle="tab" href="#info-fill" role="tab" aria-controls="info-fill" aria-selected="true">پرداخت و فروش</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link "  id="transport-tab-fill" data-toggle="tab" href="#transport-fill" role="tab" aria-controls="transport-fill" aria-selected="false">زمان و هزینه هاس ارسال</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            
                                            <div class="tab-pane active" id="info-fill" role="tabpanel" aria-labelledby="file-tab-fill">
                                                <form class="ajaxForm" action="{{ route('seller.setting.post') }}" method="POST">
                                                    @csrf
                                                    <section id="basic-horizontal-layouts">
                                                        <div class="row match-height">
                                                            <div class="col-12 my-3">
                                                                <h5 for="">پرداخت: </h5>
                                                                <ul class="list-unstyled mb-0">
                                                                    @forelse ($payTypes as $pay)
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="pay[]" value="{{$pay->id}}" {{($setting && in_array($pay->id, $setting['pay'])) ? 'checked' : ''}} id="data-block">
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">{{$pay->name}}</span>
                                                                                <small class="help-block text-danger error-pay"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    @empty
                                                                    
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                            <div class="col-12 my-3">
                                                                <h5  for="">فروش: </h5>
                                                                <ul class="list-unstyled mb-0">
                                                                    @forelse ($sellTypes as $sell)
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="sell[]" value="{{$sell->id}}" {{($setting && in_array($sell->id, $setting['sell'])) ? 'checked' : ''}} id="data-block">
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">{{$sell->name}}</span>
                                                                                <small class="help-block text-danger error-sell"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    @empty
                                                                    
                                                                    @endforelse
                                                                </ul>
                                                            </div>

                                                            <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ویرایش اطلاعات </button>
                                                        
                                                        </div>
                                                    </section>
                                                </form>
                                            </div>
                                            
                                            <div class="tab-pane" id="transport-fill" role="tabpanel" aria-labelledby="transport-tab-fill">
                                                
                                                <form class="ajaxForm" action="{{ route('seller.setting.ship.post') }}" method="POST">
                                                    @csrf
                                                    <fieldset>

                                                        <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ثبت اطلاعات </button>
                                                        
                                                        <!-- DataTable starts -->
                                                        <div class="table-responsive">
                                                            <table class="table data-list-view1">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center"></th>
                                                                        <th class="text-center">استان</th>
                                                                        <th class="text-center">هزینه ارسال</th>
                                                                        <th class="text-center">زمان ارسال</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse ($states as $key => $state)
                                                                        <tr row="{{$state->id}}">
                                                                            <td col="id">{{$state->id}}</td>
                                                                            <td col="title" class="">
                                                                                <strong class="w-100 form-control border-0">{{$state->name}}</strong>
                                                                                <input type="hidden" name="country_id[]" value="{{$state->country->id ?? null}}">
                                                                                <input type="hidden" name="state_id[]" value="{{$state->id}}">
                                                                                <input type="hidden" name="city_id[]" value="{{null}}">
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                <input type="number" name="shipping_cost[]" class="form-control" placeholder="هزینه ارسال"
                                                                                 value="{{(!empty($state->postsetting) && isset($state->postsetting->shipping_cost)) ? $state->postsetting->shipping_cost : ''}}">
                                                                                    <div class="input-group-prepend">
                                                                                        <select name="currency_id[]" id="" class="select2">
                                                                                            <option value="" selected>واحد پولی</option>
                                                                                            @foreach($currencies as $curr)
                                                                                                <option {{(!empty($state->postsetting) && isset($state->postsetting->currency_id) && $state->postsetting->currency_id == $curr->id) ? 'selected' : ''}} value="{{$curr->id}}">{{$curr->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="number" name="shipping_time[]" class="form-control" placeholder="زمان ارسال"
                                                                                    value="{{(!empty($state->postsetting) && isset($state->postsetting->shipping_time)) ? $state->postsetting->shipping_time : ''}}">
                                                                                    <div class="input-group-prepend">
                                                                                        <select name="unit_of_time[]" id="" class="select2">
                                                                                            {{-- <option value="">استان</option> --}}
                                                                                            <option {{(!empty($state->postsetting) && isset($state->postsetting->unit_of_time) && $state->postsetting->unit_of_time == 'روز') ? 'selected' : ''}} value="روز">روز</option>
                                                                                            <option {{(!empty($state->postsetting) && isset($state->postsetting->unit_of_time) && $state->postsetting->unit_of_time == 'ساعت') ? 'selected' : ''}} value="ساعت">ساعت</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                    @empty
                                                                        
                                                                    @endforelse
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- DataTable ends -->

                                                        {{-- @foreach($states as $state)
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label  class="w-100"> استان</label>
                                                                    <strong class="w-100 form-control border-0">{{$state->name}}</strong>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="">هزینه پست</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="هزینه ارسال">
                                                                        <div class="input-group-prepend">
                                                                            <select name="state_id" id="" class="select2">
                                                                                <option value="" selected>واحد پولی</option>
                                                                                @foreach($currencies as $curr)
                                                                                    <option selected value="{{$curr->id}}">{{$curr->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="">زمان ارسال</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="زمان ارسال">
                                                                        <div class="input-group-prepend">
                                                                            <select name="state_id" id="" class="select2">
                                                                                <option selected value="روز">روز</option>
                                                                                <option value="ساعت">ساعت</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        @endforeach --}}

                                                        {{-- <div class="row">
                                                            <div class="col-md-5">
                                                                <label for="">انتخاب استان</label>
                                                                <select name="state_id" id="" class="select2" multiple>
                                                                    @foreach($states as $state)
                                                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="">هزینه پست</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="هزینه ارسال">
                                                                    <div class="input-group-prepend">
                                                                        <select name="state_id" id="" class="select2">
                                                                            <option value="" selected>واحد پولی</option>
                                                                            @foreach($currencies as $curr)
                                                                                <option selected value="{{$curr->id}}">{{$curr->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="">زمان ارسال</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="زمان ارسال">
                                                                    <div class="input-group-prepend">
                                                                        <select name="state_id" id="" class="select2">
                                                                            <option selected value="روز">روز</option>
                                                                            <option value="ساعت">ساعت</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for=""></label>
                                                                <div class="input-group">
                                                                    <button type="button" class="btn btn-icon btn-icon rounded-circle btn-warning mr-1 mb-1 waves-effect waves-light">
                                                                        <i class="vs-icon feather icon-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                            
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