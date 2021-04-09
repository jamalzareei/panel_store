@extends('layouts/master')

@section('head')

<style>
    .action-add{display: none;}
</style>
@endsection

@section('footer')

@endsection

@section('content')
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">پلان انتخابی شما: {{ $plansUser[0]->plan->name }} </h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                            <li><a data-action=""><i class="feather icon-rotate-cw categories-data-filter"></i></a></li>
                            {{-- <li><a data-action="close"><i class="feather icon-x"></i></a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    
                    <div class="card-body">
                        <section id="basic-horizontal-layouts">

                            <div class="row d-flex div-action-btns" dir="ltr">
            
                                <a href="{{ route('seller.plans.pricing') }}" class="btn bg-gradient-info mr-1 waves-effect waves-light action-add-new" >
                                    <i class="feather icon-plus"></i> فعال سازی پلان جدید
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table data-list-view">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>نام پلان</th>
                                            <th>تاریخ ثبت</th>
                                            <th>تاریخ انقضا</th>
                                            <th>وضعیت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($plansUser as $planUser)
                                            <tr row="{{ $planUser->id }}">
                                                <td col="id">{{ $planUser->id }}</td>
                                                <td col="id">{{ $planUser->plan->name }}</td>
                                                <td col="id">{{ verta($planUser->payed_at)->format('%d %B، %Y') }}</td>
                                                <td col="id">{{ verta($planUser->payed_at)->addDays($planUser->actived_days)->format('%d %B، %Y') }}</td>
                                                <td col="id">
                                                    @if (\Carbon\Carbon::now()->timestamp < \Carbon\Carbon::parse($planUser->payed_at)->addDays($planUser->actived_days)->timestamp)
                                                        <span class="badge badge-success">فعال</span>
                                                    @else
                                                        <span class="badge badge-danger">منقضی</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                هیچ پلان فعالی ندارید.
                                            </div>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
