<table class="table data-list-view-">
    <thead>
        <tr>
            <th></th>
            <th>قیمت</th>
            <th>تخفیف</th>
            <th>موجودی</th>
            <th>ویژگی ها</th>
            <th>وضعیت</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($prices as $key => $price)
            <tr row="{{$price->id}}">
                <td col="id">{{$price->id}}</td>
                <td col="price" class="">{{$price->price}}</td>
                <td col="discount" class="">{{$price->discount}}</td>
                <td col="amount" class="">{{$price->amount}}</td>
                <td col="discount" class="">
                    <ul class="list-group">
                        @forelse ($price->priceproperties as $index => $prop)
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 {{($index%2==0) ?'bg-rgba-secondary' : ''}}">
                                <span class="">{{$prop->property->name}}</span>
                                <span class="">{{$prop->value}}</span>
                            </li>
                        @empty
                            
                        @endforelse
                    </ul>
                </td>
                <td col="verify">
                    @if($price->deleted_at)
                    <div class="chip chip-warning">
                        <div class="chip-body">
                            <div class="chip-text">حذف شده</div>
                        </div>
                    </div>
                    @elseif ($price->actived_at)
                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                        <input type="checkbox" class="custom-control-input" name="actived_at[{{$price->id}}]" id="customSwitch{{$price->id}}" checked onclick="changeStatus('{{ route('seller.price.update.status', ['id'=> $price->id]) }}',this)">
                            <label class="custom-control-label" for="customSwitch{{$price->id}}">
                                <span class="switch-text-left">فعال</span>
                                <span class="switch-text-right">غیر فعال</span>
                            </label>
                        </div>
                        <div class="hidden">فعال شده</div>
                    @else
                        <div class="custom-control custom-switch custom-switch-success switch-md mr-2 mb-1">
                            <input type="checkbox" class="custom-control-input" name="actived_at[{{$price->id}}]" id="customSwitch{{$price->id}}" onclick="changeStatus('{{ route('seller.price.update.status', ['id'=> $price->id]) }}',this)">
                            <label class="custom-control-label" for="customSwitch{{$price->id}}">
                                <span class="switch-text-left">فعال</span>
                                <span class="switch-text-right">غیر فعال</span>
                            </label>
                        </div>
                        <div class="hidden">غیر فعال شده</div>
                    @endif
                    
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    هیچ موردی برای نمایش وجود ندارد
                </td>
            </tr>
        @endforelse
        
    </tbody>
</table>