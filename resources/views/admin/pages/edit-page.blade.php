@extends('layouts/master') @section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}"> @endsection @section('footer')

<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script>
    $(".select2").select2({
        dir: "rtl",
        dropdownAutoWidth: true,
        width: '100%'
    });
</script>
<link href="{{asset('assets/summernote/summernote.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/summernote/summernote.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.textarea-html').summernote({
        placeholder: $(this).attr('placeholder'),
        tabsize: 2,
        height: 1000
      });
    });
    </script>
@endsection @section('content')


<section id="basic-vertical-layouts">
    <div class="row match-height">

        <div class="col-md-12 col-12">
            <section id="number-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{$title}}</h4>

                                <a class="btn bg-gradient-danger text-white my-1" href="{{ route('admin.pages.get') }}">
                                    برگشت لیست همه صفحات
                                </a>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="info-tab-fill" data-toggle="tab" href="#info-fill" role="tab" aria-controls="info-fill" aria-selected="true">اطلاعات کلی</a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a class="nav-link {{($page) ? '' : 'disabled'}}" id="file-tab-fill" data-toggle="tab" href="#file-fill" role="tab" aria-controls="file-fill" aria-selected="true">لوگوی فروشگاه</a>
                                            </li> --}}
                                            <li class="nav-item">
                                                <a class="nav-link {{($page) ? '' : 'disabled'}}"  id="seo-tab-fill" data-toggle="tab" href="#seo-fill" role="tab" aria-controls="seo-fill" aria-selected="false">اطلاعات سئو و صفحه</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <form action="{{ route('admin.page.update', ['id' => $page->id]) }}" method="post" class="ajaxForm">
                                            @csrf
                                            <div class="tab-content">
                                                
                                                <div class="tab-pane active" id="info-fill" role="tabpanel" aria-labelledby="file-tab-fill">
                                                    <section id="basic-horizontal-layouts">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row match-height">
                                                                    <div class="col-12">
                                                                        <ul class="list-unstyled mb-0">
                                                                            
                                                                            <li class="d-inline-block mr-2">
                                                                                <fieldset>
                                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                                        <input type="checkbox" name="active" value="1" id="data-block" {{($page && $page->actived_at && $page->admin_actived_at) ? 'checked' : ''}}>
                                                                                        <span class="vs-checkbox">
                                                                                            <span class="vs-checkbox--check">
                                                                                                <i class="vs-icon feather icon-check"></i>
                                                                                            </span>
                                                                                        </span>
                                                                                        <span class="">فعال</span>
                                                                                        <small class="help-block text-danger error-active"></small>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </li>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="name">نام صفحه</label>
                                                                            <div class="position-relative has-icon-left">
                                                                                <input type="text" id="name" class="form-control" name="name" placeholder="نام صفحه" value="{{$page->name ?? ''}}">
                                                                                <div class="form-control-position">
                                                                                    <i class="feather icon-user"></i>
                                                                                </div>
                                                                                <small class="help-block text-danger error-name"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="details">متن صفحه :</label>
                                                                            <textarea placeholder="متن صفحه" id="details" name="details" rows="5" class="form-control textarea-html">{{ $page ? @file_get_contents(config('shixeh.cdn_domain_files').$page->path) : ''}}</textarea>
                                                                            <small class="help-block text-danger error-details"></small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <button type="submit" class="btn btn-primary mr-1 mb-1"><i></i> ذخیره اطلاعات</button> {{-- <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button> --}}
                                                                    </div>
        
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h4 class="card-title">انتخاب هدر صفحه</h4>
                                                                    </div>
                                                                    <div class="card-content">
                                                                        <div class="card-body">
                                                                            <div class="text-center">
                                                                                @if ($page && $page->image && isset($page->image) && $page->image->path)
                                                                                    <img src="{{config('shixeh.cdn_domain_files')}}/{{$page->image->path}}" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                                                @else
                                                                                    <img src="{{config('shixeh.path_logo')}}" alt="" id="preview_image_crop" class="img-thumbnail user-circle m-auto">
                                                                                @endif
                                                                                <input type="hidden" name="image_file" class="image_file">
                                                                                <small class="help-block text-danger error-image_file w-100 m-1 row text-center"></small>
                                                                            </div>
                                                                            @include('components.sections.crop', ['head'=> '', 'type' => 'circle'])
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </section>
                                                </div>
                                                
                                                <div class="tab-pane" id="seo-fill" role="tabpanel" aria-labelledby="seo-tab-fill">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="title">عنوان صفحه</label>
                                                                    <input type="text" placeholder="عنوان صفحه" class="form-control" id="title" name="title" value="{{ ($page && $page->seo) ? $page->seo->title : ''}}">
                                                                    <small class="help-block text-danger error-title"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="head">هدر h1 برای صفحه</label>
                                                                    <input type="text" placeholder="هدر h1 برای صفحه" class="form-control" id="head" name="head" value="{{ ($page && $page->seo) ? $page->seo->head : ''}}">
                                                                    <small class="help-block text-danger error-head"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_keywords">متا تگ ها :</label>
                                                                    <input type="text" placeholder="متا تگ ها" data-role="tagsinput" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ ($page && $page->seo) ? $page->seo->meta_keywords : ''}}">
                                                                    <small class="help-block text-danger error-meta_keywords"></small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="meta_description">متا توضیحات :</label>
                                                                    <textarea placeholder="متا توضیحات" id="meta_description" name="meta_description" rows="5" class="form-control">{{ ($page && $page->seo) ? $page->seo->meta_description : ''}}</textarea>
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