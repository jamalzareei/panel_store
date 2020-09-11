@extends('layouts/master')

@section('head')
    
@endsection

@section('footer')
    <script>
        $(() => {
            $('#show-codes').click(function(){
                var phone = $('[name="phone"]').val();
                if(phone){
                    $('.codes-box').show();
                    $(this).hide();

                }
            })
        })
    </script>
@endsection

@section('content')
    
    
    <div class="content-body">
        <!-- Basic Horizontal form layout section start -->
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{$title}}</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <form action="{{ route('user.data.phone.post') }}" method="post" class="ajaxForm w-100">
                                            @csrf
                                            <div class="col-12">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="phone">شماره همراه ({{$user->phone}})</label>
                                                        <div class="position-relative has-icon-left">
                                                            <input type="text" dir="ltr" id="phone" class="form-control" name="phone" placeholder="شماره همراه جدید خود را وارد نمایید..." value="">
                                                            <div class="form-control-position">
                                                                <i class="feather icon-phone"></i>
                                                            </div>
                                                            <small class="help-block text-danger error-phone"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <button type="submit" id="show-codes" class="btn btn-primary mr-1 mb-1"><i></i> ارسال کد تایید </button>
                                                </div>
                                            
                                            </div>

                                            <div class="col-12 codes-box" style="display: none">
                                                <p class="text-info"> کد تاییدیه به شماره همراه شما ارسال گردید. </p>
                                                <div class="row">

                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="code_new">کد تاییدیه شماره همراه جدید</label>
                                                            <div class="position-relative has-icon-left">
                                                                <input type="text" dir="ltr" id="code_new" class="form-control" name="code_new" placeholder="کد تاییدیه شماره همراه جدید" value="">
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-code"></i>
                                                                </div>
                                                                <small class="help-block text-danger error-code_new"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1"><i></i> تایید شماره همراه  </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
        </section>
        <!-- // Basic Horizontal form layout section end -->

    </div>


@endsection