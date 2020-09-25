<div class="row">
    <div class="col-4">
        <select name="country_id" id="" class="select2 form-control">
            <option value="">کشور</option>
            @if ($country)
                <option selected value="{{$country->id}}">{{$country->name}}</option>
            @endif
            @foreach($countries as $country)
                <option value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-4">
        <select name="state_id" id="" class="select2 form-control">
            <option value="">استان</option>
            @if ($state)
                <option selected value="{{$state->id}}">{{$state->name}}</option>
            @endif
        </select>
    </div>
    <div class="col-4">
        <select name="city_id" id="" class="select2 form-control">
            <option value="">شهر</option>
            @if ($city)
                <option selected value="{{$city->id}}">{{$city->name}}</option>
            @endif
        </select>
    </div>
</div>

<script>
    $(() => {
        $('[name="country_id"]').change(function() {
            var country_id = $(this).find('option:selected').val();
            $.ajax({
                url: "{{route('get.states.location')}}?country_id="+country_id,
                method: 'get',
                data: { ajax: 'true' },
                success: function(response) {
                    console.log(response)
                    $('[name="state_id"]').html(response)
                },
                error: function(request, status, error) {
                    console.log(request);
                }
            })
        })
        $('[name="state_id"]').change(function() {
            var state_id = $(this).find('option:selected').val();
            $.ajax({
                url: "{{route('get.cities.location')}}?state_id="+state_id,
                method: 'get',
                data: { ajax: 'true' },
                success: function(response) {
                    console.log(response)
                    $('[name="city_id"]').html(response)
                },
                error: function(request, status, error) {
                    console.log(request);
                }
            })
        })
    })
</script>