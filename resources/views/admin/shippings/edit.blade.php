@extends('admin.index')
@section('content')
@push('js')
<script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAqQZukuqiPG12VkNYG0JWLf6jXa8bqPfU'></script>
<script type="text/javascript" src="{{ url('design/adminlte/dist/js/locationpicker.jquery.js') }}"></script>
<?php
    $lat = !empty($shipping->lat) ? $shipping->lat: '30.034024628931657';
    $lng = !empty($shipping->lng) ? $shipping->lng: '31.24238681793213';

?>
<script>
    $('#us1').locationpicker({
        location: {
            latitude: {{ $lat }},
            longitude: {{ $lng }}
        },
        radius: 300,
        markerIcon: "{{ url('design/adminlte/dist/img/map-marker-2-xl.png') }}",

        inputBinding: {
            latitudeInput: $('#lat'),
            longitudeInput: $('#lng'),
            // radiusInput: $('#us2-radius'),
            // locationNameInput: $('#address')
        }

    });
</script>
@endpush

<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <div class="box-body">
            {!! Form::open(['url'   =>  aurl('shippings/'. $shipping->id) ,'method' => 'put', 'files' => true]) !!}
               <input type="hidden" value="{{ $lat}}" id="lat" name="lat"/>
                <input type="hidden" value="{{ $lng }}" id="lng" name="lng"/>
                <div class="form-group">
                    {!! Form::label('name_ar', trans('admin.name_ar')) !!}
                    {!! Form::text('name_ar', $shipping->name_ar, ['class' => 'form-control']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('name_en', trans('admin.name_en')) !!}
                    {!! Form::text('name_en', $shipping->name_en, ['class' => 'form-control']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('user_id', trans('admin.owner_id')) !!}
                    {!! Form::select('user_id', '$shipping->user_id', ['class' => 'form-control', 'placeholder' => '.................']) !!}

                </div>

                <div class="form-group">
                    {!! Form::label('lng', trans('admin.lng')) !!}
                    {!! Form::text('lng', $shipping->lng, ['class' => 'form-control']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('lat', trans('admin.lat')) !!}
                    {!! Form::text('lat', $shipping->lat, ['class' => 'form-control']) !!}

                </div>

                <div class="form-group">
                    {!! Form::label('icon', trans('admin.manu_icon')) !!}
                    {!! Form::file('icon', ['class' => 'form-control']) !!}
                    @if(!empty($mamnufacture->icon))
                        <img src="{{ Storage::url( $mamnufacture->icon) }}"  style="height:50px; width:50px" />
                    @endif
                </div>

                {!! Form::submit(trans('admin.add'), ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}


            </div>
          </div>



@endsection
