@extends('layouts.master')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/wizard.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dropify/dist/css/dropify.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('footer')

    <script src="{{ asset('app-assets/vendors/js/extensions/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/wizard-steps.js') }}"></script>
    <!-- END: Page JS-->
    <script src="{{ asset('assets/dropify/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script>

        $(".select2").select2({
            dir: "rtl",
            dropdownAutoWidth: true,
            width: '100%',
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

                                @if ($property && $property->category_id)
                                    <a href="{{ route('admin.properties.list', ['category_id'=> $property->category_id]) }}" class="btn bg-gradient-info mr-1 waves-effect waves-light action-add-new" >
                                        <i class="feather icon-list"></i> لیست دیگر پراپرتی های هم گروه
                                    </a>
                                @endif
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p>در این قسمت اطلاعات دیگر پراپرتی را کامل نمایید.</p>


                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link " id="file-tab-fill" data-toggle="tab" href="#file-fill" role="tab" aria-controls="file-fill" aria-selected="true">فایل (عکس)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="info-tab-fill" data-toggle="tab" href="#info-fill" role="tab" aria-controls="info-fill" aria-selected="false">اطلاعات اصلی</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="seo-tab-fill" data-toggle="tab" href="#seo-fill" role="tab" aria-controls="seo-fill" aria-selected="false">اطلاعات سئو و صفحه</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->

                                        <form class="ajaxUpload" action="{{ route('admin.property.update.post', ['id'=> $property->id]) }}" action="" method="post">
                                            @csrf
                                            <div class="tab-content pt-1">
                                                <div class="tab-pane" id="file-fill" role="tabpanel" aria-labelledby="file-tab-fill">
                                                    <fieldset>

                                                        <label for="">اپلود عکس دسته بنده (عکس در سایز 512*512 و فرمت jpg) </label>
                                                        <input type="file" name="image" class="dropify file-upload" data-default-file="{{($property) ? config('shixeh.cdn_domain_files').$property->image : ''}}" />
                                                        <small class="help-block text-danger error-image"></small>

                                                        <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> اپلود و ذخیره عکس </button>
                                                    </fieldset>
                                                </div>
                                                <div class="tab-pane active" id="info-fill" role="tabpanel" aria-labelledby="info-tab-fill">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="is_filter" value="1" id="data-block" {{($property && $property->is_filter) ? 'checked' : ''}}>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">نمایش در فیلتر ها</span>
                                                                                <small class="help-block text-danger error-is_filter"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="actived_at" value="1" id="data-block" {{($property && $property->actived_at) ? 'checked' : ''}}>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">فعال</span>
                                                                                <small class="help-block text-danger error-actived_at"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="is_show_less" value="1" id="data-block" {{($property && $property->is_show_less == 1) ? 'checked' : ''}}>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">نمایش در کنار محصول</span>
                                                                                <small class="help-block text-danger error-is_show_less"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                <input type="checkbox" name="is_price" value="1" id="data-block" {{($property && $property->is_price == 1) ? 'checked' : ''}}>
                                                                                <span class="vs-checkbox">
                                                                                    <span class="vs-checkbox--check">
                                                                                        <i class="vs-icon feather icon-check"></i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="">تاثیر روی قیمت</span>
                                                                                <small class="help-block text-danger error-is_price"></small>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>

                                                                    <li class="d-inline-block mr-2 w-100">
                                                                        <fieldset class="my-2">
                                                                            <label for="categories">دسته بندی های مرتبط</label>
                                                                            <select name="categories[]" multiple class="form-control w-100 select2" id="categories" data-placeholder="دسته بندی های مرتبط را انتخاب نمایید">
                                                                                @forelse ($categories as $category)
                                                                                    <option value="{{$category->id}}" {{($property->categories->where('id', $category->id)->count()) ? 'selected' : ''}}>

                                                                                        @if ($category->parent && $category->parent->name)
                                                                                            @if ($category->parent->parent && $category->parent->parent->name)
                                                                                                @if ($category->parent->parent->parent && $category->parent->parent->parent->name)
                                                                                                    {{ $category->parent->parent->parent->name }} >
                                                                                                @endif
                                                                                                {{ $category->parent->parent->name }} >
                                                                                            @endif
                                                                                            {{ $category->parent->name }} >
                                                                                        @endif
                                                                                        {{$category->name}}
                                                                                    </option>
                                                                                @empty

                                                                                @endforelse
                                                                            </select>
                                                                        </fieldset>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="name">نام</label>
                                                                    <input type="text" placeholder="نام" class="form-control" id="name" name="name" value="{{ $property ? $property->name : ''}}">
                                                                    <small class="help-block text-danger error-name"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="slug">اسلاگ</label>
                                                                    <input type="text" placeholder="اسلاگ" class="form-control" id="slug" name="slug" value="{{ $property ? $property->slug : ''}}">
                                                                    <small class="help-block text-danger error-slug"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="default_list">لیست گزینه های پیش فرض :</label>
                                                                    <input type="text" data-role="tagsinput" placeholder="لیست گزینه های پیش فرض" class="form-control w-100" id="default_list" name="default_list" value="{{ $property ? $property->default_list : ''}}">
                                                                    <small class="help-block text-danger error-default_list"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="filter_list">لیست ایتم هایی که در فیلتر نمایش داده میشود :</label>
                                                                    <input type="text" data-role="tagsinput" placeholder="لیست ایتم هایی که در فیلتر نمایش داده میشود" class="form-control" id="filter_list" name="filter_list" value="{{ $property ? $property->filter_list : ''}}">
                                                                    <small class="help-block text-danger error-filter_list"></small>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="description_short">توضیحات کوتاه :</label>
                                                                    <textarea placeholder="توضیحات کوتاه" id="description_short" name="description_short" rows="5" class="form-control">{{ $property ? $property->description_short : ''}}</textarea>
                                                                    <small class="help-block text-danger error-description_short"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="description_full">توضیحات کامل :</label>
                                                                    <textarea placeholder="توضیحات کامل" id="description_full" name="description_full" rows="5" class="form-control">{{ $property ? $property->description_full : ''}}</textarea>
                                                                    <small class="help-block text-danger error-description_full"></small>
                                                                </div>
                                                            </div> --}}


                                                        <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ویرایش اطلاعات </button>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="tab-pane" id="seo-fill" role="tabpanel" aria-labelledby="seo-tab-fill">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="title">عنوان صفحه</label>
                                                                    <input type="text" placeholder="عنوان صفحه" class="form-control" id="title" name="title" value="{{ ($property && $property->seo) ? $property->seo->title : ''}}">
                                                                    <small class="help-block text-danger error-title"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="head">هدر h1 برای صفحه</label>
                                                                    <input type="text" placeholder="هدر h1 برای صفحه" class="form-control" id="head" name="head" value="{{ ($property && $property->seo) ? $property->seo->head : ''}}">
                                                                    <small class="help-block text-danger error-head"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_keywords">متا تگ ها :</label>
                                                                    <input type="text" placeholder="متا تگ ها" data-role="tagsinput" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ ($property && $property->seo) ? $property->seo->meta_keywords : ''}}">
                                                                    <small class="help-block text-danger error-meta_keywords"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_description">متا توضیحات :</label>
                                                                    <textarea placeholder="متا توضیحات" id="meta_description" name="meta_description" rows="5" class="form-control">{{ ($property && $property->seo) ? $property->seo->meta_description : ''}}</textarea>
                                                                    <small class="help-block text-danger error-meta_description"></small>
                                                                </div>
                                                            </div>

                                                            <button class="btn btn-primary btn-md my-2 " type="submit"> <i class=""></i> ویرایش اطلاعات </button>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </form>
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
