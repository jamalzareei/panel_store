
<div class="card-body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="info-pay-tab-fill" data-toggle="tab" href="#info-pay-fill" role="tab" aria-controls="info-pay-fill" aria-selected="true">پرداخت و فروش</a>
        </li>
        <li class="nav-item">
            <a class="nav-link "  id="transport-tab-fill" data-toggle="tab" href="#transport-fill" role="tab" aria-controls="transport-fill" aria-selected="false">زمان و هزینه هاس ارسال</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        
        <div class="tab-pane active" id="info-pay-fill" role="tabpanel" aria-labelledby="file-tab-fill">
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
                                            <input type="checkbox" name="pay[]" value="{{$pay->id}}" {{($setting && is_array($setting['pay']) && in_array($pay->id, $setting['pay'])) ? 'checked' : ''}} id="data-block">
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
                                            <input type="checkbox" name="sell[]" value="{{$sell->id}}" {{($setting && is_array($setting['sell']) && in_array($sell->id, $setting['sell'])) ? 'checked' : ''}} id="data-block">
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

                        {{-- <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ویرایش اطلاعات </button> --}}
                    
                    </div>
                </section>
            </form>
        </div>
        
        <div class="tab-pane" id="transport-fill" role="tabpanel" aria-labelledby="transport-tab-fill">
            
            <form class="ajaxForm" action="{{ route('seller.setting.ship.post') }}" method="POST">
                @csrf
                <fieldset>

                    {{-- <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ثبت اطلاعات </button> --}}
                    
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
                    
                </fieldset>
            </form>
        </div>
    </div>
        
</div>
