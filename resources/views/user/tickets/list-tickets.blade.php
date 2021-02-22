@extends('layouts/master')
@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/colors/palette-gradient.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-chat.css') }}">
@endsection
@section('footer')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/app-chat.css') }}">
<!-- BEGIN: Page JS-->
<script src="{{ asset('app-assets/js/scripts/pages/app-chat.js') }}">
</script>
<!-- END: Page JS-->
@endsection
@section('content')


<div class="vertical-layout vertical-menu-modern content-left-sidebar chat-application navbar-floating footer-static  "
    data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">

    <div class="row d-flex div-action-btns" dir="ltr">

        
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <section class="todo-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenter">افزودن تیکت جدید</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="add-category" class="todo-input ajaxForm" method="POST"
                        action="{{ route('user.ticket.add') }}">
                        @csrf
                        <div class="modal-body">

                            <fieldset class="form-group">
                                <label for="title">عنوان</label>
                                <input type="text" class="new-todo-item-title form-control" name="title" id="title" placeholder="عنوان">
                                <small class="help-block text-danger error-title">

                                </small>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="level">اولویت</label>
                                <select name="level" id="level" class="select2 form-control">
                                    <option value="LOW">پایین</option>
                                    <option value="MEDIUM">متوسط</option>
                                    <option value="HIGH">زیاد</option>
                                </select>
                                <small class="help-block text-danger error-level">

                                </small>
                            </fieldset>

                            <div class="modal-footer">
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <button type="submit" class="btn btn-primary add-todo-item waves-effect waves-light"
                                        form="add-category">
                                        <i class="feather icon-check d-block ">

                                        </i>
                                        <span class="">افزودن </span>
                                    </button>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left mb-0 d-none d-lg-block">
                                    <button type="button" class="btn btn-outline-light waves-effect waves-light"
                                        data-dismiss="modal">
                                        <i class="feather icon-x d-block d-lg-none">

                                        </i>
                                        <span class="d-none d-lg-block">بستن</span>
                                    </button>
                                </fieldset>
                            </div>
                    </form>
                </section>
            </div>
        </div>
    </div>


    {{-- //////////////////////// --}}

    <div class="vertical-layout vertical-menu-modern content-left-sidebar chat-application navbar-floating footer-static  "
        data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">
        <div class="content-area-wrapper m-0">
            <div class="sidebar-left">
                <div class="sidebar">




                    <div class="sidebar-content card">

                        <div id="users-list" class="chat-user-list list-group position-relative ps mt-0">

                            <ul class="chat-users-list-wrapper media-list">
                                <li>
                                    <button type="button" class="btn bg-gradient-info m-1 waves-effect waves-light action-add-new"
                                        data-toggle="modal" data-target="#exampleModalCenter">
                                        <i class="feather icon-plus">
                                        </i> افزودن تیکت جدید
                                    </button>
                                </li>
                                @forelse ($tickets as $tick)
                                    <a href="{{ route('user.tickets', ['ticket_id'=>$tick->id]) }}">
                                    <li class="{{ ($tick->status_id == 0) ? '' : 'bg-rgba-dark'}}">
                                        <div class="user-chat-info">
                                            <div class="contact-info">
                                                <h5 class="font-weight-bold mb-0" dir="ltr">
                                                    {{ $tick->title }}
                                                </h5>
                                                <small class="truncate">
                                                    {{verta($tick->created_at)->formatDifference()}}
                                                </small>
                                            </div>
                                            <div class="contact-meta">
                                                <span class="float-right mb-25 small">
                                                
                                                    @if ($tick->type)
                                                        <span class="badge badge-success">باز</span>
                                                    @else
                                                        
                                                        <span class="badge badge-danger">بسته</span>
                                                    @endif
                                                </span>

                                            </div>
                                        </div>
                                    </li>
                                </a>
                                @empty
                                    
                                @endforelse
                            </ul>
                        </div>

                    </div>


                </div>
            </div>
            <div class="content-right">
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="chat-overlay">

                        </div>
                        @if ($ticket)
                            @include('user.tickets.ticket',['ticket'=>$ticket])
                        @else
                            
                            <section class="chat-app-window">
                                <div class="start-chat-area">
                                    <span class="mb-1 start-chat-icon feather icon-message-square"></span>
                                    
                                    <button type="button" class="btn bg-gradient-info m-1 waves-effect waves-light action-add-new" data-toggle="modal" data-target="#exampleModalCenter">
                                        <i class="feather icon-plus"></i> افزودن تیکت جدید
                                    </button>
                                </div>
                            </section>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Content-->

        <!-- END: Content-->

        <div class="sidenav-overlay">

        </div>
        <div class="drag-target">

        </div>

    </div>

</div>
@endsection