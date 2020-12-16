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
        // placeholder: "انتخاب نمایید...",
    });
</script>

<link href="{{asset('assets/summernote/summernote.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/summernote/summernote.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.textarea-html').summernote({
        placeholder: $(this).attr('placeholder'),
        tabsize: 2,
        height: 200
      });
    });
    </script>
@endsection

@section('content')

<section class="multiple-select2" data-select2-id="180">
    <div class="row" data-select2-id="179">
        <div class="col-12" data-select2-id="178">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                    @if ($product && !$product->actived_at)
                        <a class="btn bg-gradient-danger text-white my-1" href="{{ route('product.send.admin', ['id' => $product->id]) }}">
                            ارسال به مدیریت جهت بررسی
                        </a>
                    @elseif ($product && $product->actived_at && !$product->admin_actived_at)
                        <div class="chip chip-info my-1">
                            <div class="chip-body">
                                <div class="avatar bg-rgba-white">
                                    <i class="fas fa-info"></i>
                                </div>
                                <span class="chip-text">در انتظار تایید</span>
                            </div>
                        </div>
                    @elseif ($product && $product->actived_at && $product->admin_actived_at)
                        <div class="chip chip-success my-1">
                            <div class="chip-body">
                                <div class="avatar bg-rgba-white">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="chip-text">تایید شده</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-content row">
                    <div class="col-md-2 pt-5 px-1">
                        <ul class="nav nav-pills flex-column ml-1">
                            <li class="nav-item mb-1">
                                <a class="nav-link font-small-2 active" id="stacked-pill-info" data-toggle="pill" href="#vertical-pill-info" aria-expanded="true">
                                     اطلاعات پایه محصول
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link font-small-2 {{($product) ? '' : 'disabled'}}" id="stacked-pill-properties" data-toggle="pill" href="#vertical-pill-properties" aria-expanded="false">
                                     ویژگی های محصول
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link font-small-2 {{($product) ? '' : 'disabled'}} " id="stacked-pill-price" data-toggle="pill" href="#vertical-pill-price" aria-expanded="false">
                                     قیمت محصول
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link font-small-2 {{($product) ? '' : 'disabled'}} " id="stacked-pill-details" data-toggle="pill" href="#vertical-pill-details" aria-expanded="false">
                                    جزئیات محصول
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link font-small-2 {{($product) ? '' : 'disabled'}} " id="stacked-pill-tags" data-toggle="pill" href="#vertical-pill-tags" aria-expanded="false">
                                    تگ های محصول
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link font-small-2 {{($product) ? '' : 'disabled'}} " id="stacked-pill-gallery" data-toggle="pill" href="#vertical-pill-gallery" aria-expanded="false">
                                    گالری (عکس)
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link font-small-2 {{($product) ? '' : 'disabled'}} " id="stacked-pill-seo" data-toggle="pill" href="#vertical-pill-seo" aria-expanded="false">
                                    اطلاعات سئوی محصول
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-md-10">
                        
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="vertical-pill-info" aria-labelledby="stacked-pill-info" aria-expanded="true">
                                    
                                @if ($product)
                                    <form action="{{ route('seller.product.update.post', ['id'=>$product->id, 'type'=>'info']) }}" class="ajaxForm" method="post">
                                        <input type="hidden" name="id" value="{{$product->id ?? ''}}">
                                @else
                                    <form action="{{ route('seller.product.add.post') }}" class="ajaxForm" method="post">
                                @endif
                                    <div class="card-body border-left-light rounded my-3">
                                        <div class="divider divider-info">
                                            <div class="divider-text"> دسته بندی محصول و اطلاعات پایه </div>
                                        </div>
                                        <div class="row">
                                                <div class="col" col="1">
                                                    {!!$categories!!}
                                                    {{-- @include('seller.products.load-categories', ['categories' => $categories, 'col'=> 1]) --}}
                                                </div>
                                                
                                                <div class="col load-categories" col="2">

                                                </div>
                                                <div class="col load-categories" col="3">

                                                </div>
                                                <div class="col load-categories" col="4">

                                                </div>
                                                <div class="col load-categories" col="5">

                                                </div>

                                            <div class="col-12">
                                                <ol class="breadcrumb breadcrumb-categories">
                                                    <li class="breadcrumb-item" col="1">{{(isset($product) && isset($product->categories) && isset($product->categories[0]) && isset($product->categories[0]->name)) ? $product->categories[0]->name : ''}}</li>
                                                    <li class="breadcrumb-item" col="2">{{(isset($product) && isset($product->categories) && isset($product->categories[1]) && isset($product->categories[1]->name)) ? $product->categories[1]->name : ''}}</li>
                                                    <li class="breadcrumb-item" col="3">{{(isset($product) && isset($product->categories) && isset($product->categories[2]) && isset($product->categories[2]->name)) ? $product->categories[2]->name : ''}}</li>
                                                    <li class="breadcrumb-item" col="4">{{(isset($product) && isset($product->categories) && isset($product->categories[3]) && isset($product->categories[3]->name)) ? $product->categories[3]->name : ''}}</li>
                                                    <li class="breadcrumb-item" col="5">{{(isset($product) && isset($product->categories) && isset($product->categories[4]) && isset($product->categories[4]->name)) ? $product->categories[4]->name : ''}}</li>
                                                </ol>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 form-group">
                                                <label for="data-name">نام محصول</label>
                                                <input type="text" class="form-control" name="name" id="data-name" placeholder="نام محصول" value="{{$product->name ?? ''}}">
                                                <small class="help-block text-danger error-name"></small>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="data-code">کد محصول</label>
                                                <input type="text" dir="ltr" class="form-control" name="code" id="data-code" placeholder="کد محصول" value="{{$product->code ?? ($code ?? '')}}">
                                                <small class="help-block text-danger error-code"></small>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <button type="submit" class="btn btn-primary btn-block">ثبت اطلاعات محصول</button>
                                        </div>
                                    </div>
                                    
                                </form>                    
                            </div>

                            @if ($product)
                            
                                <div role="tabpanel" class="tab-pane" id="vertical-pill-properties" aria-labelledby="stacked-pill-properties" aria-expanded="true">
                                                            
                                    <form action="{{ route('seller.product.update.post', ['id'=>$product->id, 'type'=>'properties']) }}" class="ajaxForm" method="post">
                                        <input type="hidden" name="id" value="{{$product->id ?? ''}}">
                                
                                        <div class="card-body border-left-light rounded my-3">
                                            <div class="divider divider-info">
                                                <div class="divider-text h3">ویژگی ها</div>
                                            </div>
        
                                            <div class="row">
                                                @forelse ($product->categories as $key => $categoryProperty)
                                                    <div class="col-md-12 divider divider-solid">
                                                        <div class="divider-text"> ویژگی های {{$categoryProperty->name}}</div>
                                                    </div>
                                                    @forelse ($categoryProperty->properties as $property)
                                                        <div class="col-md-6 form-group">
                                                            <label for="data-property">{{$property->name}}</label>
                                                            @if ($property->default_list)
                                                                            
                                                            <select name="properties[{{$property->id}}][]" multiple id="" class="select2 form-control" data-placeholder="انتخاب مقدار ویژگی از لیست">
                                                                @foreach(explode(",",$property->default_list) as $propListPriceImpode)
                                                                    <option value="{{$propListPriceImpode}}" {{($property->propertyvalue && $property->propertyvalue->value && (strpos($property->propertyvalue->value, $propListPriceImpode) !== false) ) ? 'selected' : ''}}>{{$propListPriceImpode}}</option>
                                                                @endforeach
                                                            </select>
                                                            @else
                                                            <input type="text" class="form-control" name="properties[{{$property->id}}]" id="data-property-{{$property->id}}" value="{{$property->propertyvalue->value ?? ''}}" placeholder="مقدار ویژگی">
                                                            @endif
                                                            <small class="help-block text-danger error-property"></small>
                                                        </div>
                                                    @empty
                                                        
                                                    @endforelse
                                                @empty
                                                    
                                                @endforelse
                                            </div>
                                            <div class="row">
                                                <button type="submit" class="btn btn-primary btn-block">ثبت ویژگی های محصول</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="vertical-pill-price" aria-labelledby="stacked-pill-price" aria-expanded="true">
                                    <div class="card-body border-left-light rounded my-3">
                                        <div class="divider divider-info">
                                            <div class="divider-text"> قیمت</div>
                                        </div>
        
                                        <form action="{{ route('seller.product.update.post', ['id'=>$product->id, 'type'=>'price']) }}" class="ajaxForm" method="post">
                                            <input type="hidden" name="id" value="{{$product->id ?? ''}}">
                                    
                                            <div class="row border-success rounded">
                                                <div class="w-100 divider divider-primary">
                                                    <div class="divider-text">افزودن قیمت</div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-5 form-group">
                                                            <label for="data-price">قیمت اصلی</label>
                                                            <input type="number" dir="ltr" class="form-control" name="price" id="data-price" placeholder="قیمت اصلی">
                                                            <small class="help-block text-danger error-price"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="data-discount">درصد تخفیف</label>
                                                            <input type="number" dir="ltr" class="form-control" name="discount" id="data-discount" placeholder="درصد تخفیف" value="0">
                                                            <small class="help-block text-danger error-discount"></small>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label for="data-amount">تعداد <small class="text-info">(موجودی)</small></label>
                                                            <input type="number" dir="ltr" class="form-control" name="amount" id="data-amount" placeholder="تعداد">
                                                            <small class="help-block text-danger error-amount"></small>
                                                        </div>
                                                        @forelse ($product->categories as $key => $propertyPrices)
                                                            @if(!($propertyPrices->properties)->isEmpty())
                                                                @forelse ($propertyPrices->properties->where('is_price', 1) as $propertyPrice)
                                                                    <div class="col form-group">
                                                                        <label for="data-propertyPrice">{{$propertyPrice->name}} <small class="text-danger">*</small></label>
                                                                        <input type="text" class="form-control" name="propertyprices[{{$propertyPrice->id}}]" id="data-propertyPrice-{{$propertyPrice->id}}" value="" placeholder="مقدار ویژگی">
                                                                        <small class="help-block text-danger error-propertyPrice.{{$propertyPrice->id}}"></small>
                                                                    </div>
                                                                @empty
                                                                    
                                                                @endforelse
                                                
                                                            @endif
                                                        @empty
                                                            
                                                        @endforelse
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-md-2 d-flex">
                                                    {{-- <label for="tags" class="w-100">افزودن</label> --}}
                                                    <button type="submit" class="btn btn-icon btn-icon rounded-circle btn-primary m-auto waves-effect waves-light">
                                                        <i class="feather icon-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
        
                                        <div class="row" id="load-data-ajax">
                                            {!! $listPrices !!}
                                        </div>
                                    </div>
                        
                                </div>
                                
                                <div role="tabpanel" class="tab-pane" id="vertical-pill-details" aria-labelledby="stacked-pill-details" aria-expanded="true">
                                    <form action="{{ route('seller.product.update.post', ['id'=>$product->id, 'type'=>'details']) }}" class="ajaxForm" method="post">
                                        <input type="hidden" name="id" value="{{$product->id ?? ''}}">
                                        <div class="card-body border-left-light rounded my-3">
                                            <div class="divider divider-info">
                                                <div class="divider-text">توضیحات</div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description_small">توضیحات کوتاه :</label>
                                                    <textarea placeholder="توضیحات کوتاه" id="description_small" name="description_small" rows="5" class="form-control">{{ isset($product) ? $product->description_small : ''}}</textarea>
                                                    <small class="help-block text-danger error-description_small"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description_full">توضیحات کامل :</label>
                                                    <textarea placeholder="توضیحات کامل" id="description_full" name="description_full" rows="10" class="form-control textarea-html">{{ isset($product) ? $product->description_full : ''}}</textarea>
                                                    <small class="help-block text-danger error-description_full"></small>
                                                </div>
                                            </div>

                                            
                                            <div class="row">
                                                <button type="submit" class="btn btn-primary btn-block">افزودن / ویرایش جزئیات محصول</button>
                                            </div>
                                        </div>
                                    </form>                     
                                </div>

                                <div role="tabpanel" class="tab-pane" id="vertical-pill-tags" aria-labelledby="stacked-pill-tags" aria-expanded="true">
                                    <form action="{{ route('seller.product.update.post', ['id'=>$product->id, 'type'=>'tags']) }}" class="ajaxForm" method="post">
                                        <input type="hidden" name="id" value="{{$product->id ?? ''}}">
                                        <div class="card-body border-left-light rounded my-3">
                                            <div class="divider divider-info">
                                                <div class="divider-text"> تگ (جستجوی کلمات متصل به محصول) </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-10 form-group">
                                                    <label for="tags">تگ:</label>
                                                    <input type="text" placeholder="تگ جدید با اینتر یا تب کلمه جدید اضافه نمایید ..." data-role="tagsinput" class="form-control" id="tags" name="tags" value="">
                                                    <small class="help-block text-danger error-tags"></small>
                                                </div>
                                                <div class="col-2">
                                                    <label for="tags" class="w-100">افزودن</label>
                                                    <button type="submit" class="btn btn-icon btn-icon rounded-circle btn-primary mr-1 mb-1 waves-effect waves-light">
                                                        <i class="feather icon-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>                      
                                </div>

                                <div role="tabpanel" class="tab-pane" id="vertical-pill-gallery" aria-labelledby="stacked-pill-gallery" aria-expanded="true">
                                    <div class="card-body border-left-light rounded my-3">
                                        <div class="divider divider-info">
                                            <div class="divider-text"> گالری عکس محصول </div>
                                        </div>
        
                                        <form action="{{ route('seller.product.update.post', ['id'=>$product->id, 'type'=>'gallery']) }}" class="ajaxForm" method="post">
                                            <input type="hidden" name="id" value="{{$product->id ?? ''}}">
                                            <div class="row">
                                                
                                                <div class="col-md-12">
                                                    @include('components.sections.crop', ['head'=> '', 'type' => '', 'height' => '500', 'width' => '500'])
                                                    <input type="hidden" name="image_file" class="image_file">
                                                    <small class="help-block text-danger error-image_file w-100 m-1 row text-center"></small>
                                                </div>
                                                <div class="col-md-12 mt-5 p-1 m-auto text-center">
                                                    
                                                    <div class="row" id="load-data-2-ajax">
                                                        {!! $listImages !!}
                                                    </div>
                                                    {{-- <img src="{{config('shixeh.path_logo')}}" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                    <img src="{{config('shixeh.path_logo')}}" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                    <img src="{{config('shixeh.path_logo')}}" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                    <img src="{{config('shixeh.path_logo')}}" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto"> --}}
                                                    {{-- @if ($seller && $seller->image && isset($seller->image) && $seller->image->path)
                                                    @else
                                                        <img src="{{config('shixeh.path_logo')}}" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                    @endif --}}
                                                
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                                            
                                </div>

                                <div role="tabpanel" class="tab-pane" id="vertical-pill-seo" aria-labelledby="stacked-pill-seo" aria-expanded="true">
                                                            
                                    <form action="{{ route('seller.product.update.post', ['id'=>$product->id, 'type'=>'seo']) }}" class="ajaxForm" method="post">
                                        <input type="hidden" name="id" value="{{$product->id ?? ''}}">
                                        <div class="card-body border-left-light rounded my-3">
                                            <div class="divider divider-info">
                                                <div class="divider-text">اطلاعات سئوی محصول</div>
                                            </div>
        
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">عنوان صفحه</label>
                                                        <input type="text" placeholder="عنوان صفحه" class="form-control" id="title" name="title" value="{{$product->seo->title ?? ''}}">
                                                        <small class="help-block text-danger error-title"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="head">هدر h1 برای صفحه</label>
                                                        <input type="text" placeholder="هدر h1 برای صفحه" class="form-control" id="head" name="head" value="{{$product->seo->head ?? ''}}">
                                                        <small class="help-block text-danger error-head"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="meta_keywords">متا تگ ها :</label>
                                                        <input type="text" placeholder="متا تگ ها" data-role="tagsinput" class="form-control" id="meta_keywords" name="meta_keywords" value="{{$product->seo->meta_keywords ?? ''}}">
                                                        <small class="help-block text-danger error-meta_keywords"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="meta_description">متا توضیحات :</label>
                                                        <textarea placeholder="متا توضیحات" id="meta_description" name="meta_description" rows="5" class="form-control">{{$product->seo->meta_description ?? ''}}</textarea>
                                                        <small class="help-block text-danger error-meta_description"></small>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="row">
                                                <button type="submit" class="btn btn-primary btn-block">ثبت اطلاعات سئوی محصول</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection