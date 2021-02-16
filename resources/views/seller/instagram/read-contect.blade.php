@extends('layouts/master')

@section('head')
    
@endsection

@section('footer')
    
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">تغییر ایمیل</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <form action="{{ route('seller.read.instragram.username') }}" method="get" class="w-100">
                                    <input type="hidden" name="_token" value="och2WiEXw6Sbv3B1GGlWr3mdTTtYqUuSso8bWJwE">
                                    <div class="col-12">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="username">آیدی پیج خود را وارد نمایید (shixehcom)</label>
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" dir="ltr" id="username" class="form-control" name="username" placeholder="آیدی پیج خود را وارد نمایید" value="{{ $username ?? '' }}" required>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-username"></i>
                                                    </div>
                                                    <small class="help-block text-danger error-username"></small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" id="show-codes" class="btn btn-primary mr-1 mb-1 waves-effect waves-light"> ارسال و دریافت اطلاعات </button>
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
@endsection