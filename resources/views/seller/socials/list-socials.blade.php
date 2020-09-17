<!-- DataTable starts -->
<div class="table-responsive">
    <table class="table data-list-view1">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th class="text-center">شبکه اجتماعی</th>
                <th class="text-center">نام کاربری</th>
                <th class="text-center">لینک</th>
                <th class="text-center">حذف</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($socials as $key => $social)
                <tr row="{{$social->id}}">
                    <td col="id">{{$social->id}}</td>
                    <td col="social">
                        @if ($social && $social->social)
                            {!! $social->social->icon !!} {{$social->social->name}}
                        @endif
                    </td>
                    <td col="username" class="text-left">
                        {{$social->username}}
                        {{-- <input type="text" dir="ltr" name="" class="form-control" placeholder="نام کاربری" value=""> --}}
                    </td>
                    <td col="url" class="text-left">
                        {{$social->url}}            
                    </td>
                    <td col="action">
                        <a class="action-delete" onclick="deleteRow('{{ route('seller.social.delete', ['id'=>$social->id]) }}', '{{$social->id}}')">
                            <i class="feather icon-trash"></i>
                        </a>
                    
                    </td>
                    
                </tr>
            @empty
                
            @endforelse
            
        </tbody>
    </table>
</div>
<!-- DataTable ends -->