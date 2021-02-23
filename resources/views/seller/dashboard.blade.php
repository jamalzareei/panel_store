@extends('layouts/master')

@section('content')

<div class="row">
    
    <div class="col-xl-4 col-md-6 col-sm-12 profile-card-2">
        <div class="card" style="height: 329.188px;">
            <div class="card-header mx-auto pb-0">
                <div class="row m-0 justify-content-around">
                    <div class="avatar avatar-xl">
                        <img class="img-fluid" src="{{ $seller->image->path ?? config('shixeh.x_logo') }}" alt="img placeholder">
                    </div>
                    <div class="col-sm-12 text-center">
                        <h4>{{ $seller->name }}</h4>
                    </div>
                    <div class="col-sm-12 text-center">
                        <p class="">
                            <a href="{{ route('seller.data.get') }}">
                                ویرایش اطلاعات پایه
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body text-center mx-auto">
                    <div class="d-flex justify-content-around ">
                        <div class="uploads">
                            <p class="font-weight-bold font-medium-2 mb-0">{{ $seller->products_count }}</p>
                            <span class=""> محصول </span>
                        </div>
                        <div class="followers">
                            <p class="font-weight-bold font-medium-2 mb-0">{{ $seller->branches_count }}</p>
                            <span class=""> شعبه </span>
                        </div>
                        {{-- <div class="following">
                            <p class="font-weight-bold font-medium-2 mb-0">0</p>
                            <span class=""> سفارش </span>
                        </div> --}}
                    </div>
                    <a href="{{ config('shixeh.baseSite') }}" target="_blank" class="btn gradient-light-primary btn-block mt-2 waves-effect waves-light">صفحه فروشنده</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-md-6 col-sm-12 profile-card-2">
        
        <div class="row">
            <div class="col text-center">
                <a class="btn btn-outline-dark mr-1 mb-1 waves-effect waves-light " href="{{ route('seller.data.get') }}" >
                    اطلاعات پایه
                </a>
            </div>
            <div class="col text-center">
                <a class="btn btn-outline-dark mr-1 mb-1 waves-effect waves-light " href="{{ route('seller.data.get') }}" >
                    آپلود لوگو
                </a>
            </div>
            <div class="col text-center">
                <a class="btn btn-outline-dark mr-1 mb-1 waves-effect waves-light " href="{{ route('seller.setting.get') }}" >
                    تنظیمات فروشگاه
                </a>
            </div>
            <div class="col text-center">
                <a class="btn btn-outline-dark mr-1 mb-1 waves-effect waves-light " href="{{ route('seller.brancehs.get') }}" >
                    شعبه ها
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            پلان فعال
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="alert alert-dark" role="alert">
                                <h4 class="alert-heading">پلان برنزی </h4>
                                <p class="mb-0">
                                    <a href="{{ route('user.tickets') }}">
                                        برای ارتقا حساب کاربری و برای مشاوره با تیم پشتیبانی تماس حاصل نمایید.
                                    </a>
                                </p>
                            </div>  
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                
                <a class="btn btn-dark btn-block mr-1 mb-1 waves-effect waves-light " href="{{ route('seller.products.get') }}" >
                    محصولات
                </a>
            </div>
            <div class="col">
                
                <a class="btn btn-dark btn-block mr-1 mb-1 waves-effect waves-light " href="{{ route('seller.orders') }}" >
                    سفارشات
                </a>
            </div>
            
        </div>
        <div class="row">
            <div class="col">
                <a href="{{ route('user.tickets') }}" class="btn bg-gradient-dark mr-1 mb-1 btn-block waves-effect waves-light">تیکت ها</a>
            </div>
        </div>
        
    </div>

</div>



<div class="row" id="table-striped">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">پیام های پشتیبانی</h4>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">عنوان</th>
                                <th scope="col">باز/بسته</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">تاریخ تغییر</th>
                                <th scope="col">مشاهده</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $key => $ticket)
                                <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $ticket->title }}</td>
                                        <td>{!! $ticket->type == 'OPEN' ? '<span class="badge badge-success">باز</span>' : '<span class="badge badge-danger">بسته</span>' !!}</td>
                                        <td>{{ $ticket->status_id ? 'دیده شده' : 'دیده نشده' }}</td>
                                        <td>{{ verta($ticket->updated_at) }}</td>
                                        <td>
                                            <a href="{{ route('user.tickets', ['ticket_id'=>$ticket->id]) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="table-striped">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">آخرین محصولات</h4>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th scope="col">کد</th>
                                <th scope="col">نام</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">ویرایش</th>
                                <th scope="col">مشاهده</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                        <th scope="row">{{ $product->code }}</th>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            @if ($product && !$product->actived_at)
                                                <div class="chip chip-danger my-1">
                                                    <div class="chip-body">
                                                        <div class="avatar bg-rgba-white">
                                                            <i class="fas fa-info"></i>
                                                        </div>
                                                        <span class="chip-text">غیر فعال</span>
                                                    </div>
                                                </div>
                                                <div class="hidden">غیر فعال</div>
                                            @elseif ($product && $product->actived_at && !$product->admin_actived_at)
                                                <div class="chip chip-info my-1">
                                                    <div class="chip-body">
                                                        <div class="avatar bg-rgba-white">
                                                            <i class="fas fa-info"></i>
                                                        </div>
                                                        <span class="chip-text">در انتظار تایید</span>
                                                    </div>
                                                </div>
                                                <div class="hidden">در انتظار تایید</div>
                                            @elseif ($product && $product->actived_at && $product->admin_actived_at)
                                                <div class="chip chip-success my-1">
                                                    <div class="chip-body">
                                                        <div class="avatar bg-rgba-white">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                        <span class="chip-text">تایید شده</span>
                                                    </div>
                                                </div>
                                                <div class="hidden">تایید شده</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="text-danger" href="{{ route('seller.product.updateorcreate', ['slug'=>$product->slug]) }}">
                                                <i class="fas fa-edit text-warning"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ config('shixeh.baseSite').$product->slug }}">
                                                <i class="fas fa-eye "></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection