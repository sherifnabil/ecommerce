<div id="product_setting" class="tab-pane fade">
    <h3>{{ trans('admin.product_setting') }}</h3>

    <div class="form-group">
        {!! Form::label('stock', trans('admin.price')) !!}
        {!! Form::text('price', $product->price, ['class' => 'form-control', 'placeholder' =>  trans('admin.price')]) !!}
    </div>
    <div class="form-group">
        {!! Form::label('stock', trans('admin.stock')) !!}
        {!! Form::text('stock', $product->stock, ['class' => 'form-control', 'placeholder' =>  trans('admin.stock')]) !!}
    </div>

    <div class="form-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
        {!! Form::label('start_at', trans('admin.start_at')) !!}
        {!! Form::text('start_at', $product->start_at, ['class' => 'form-control datepicker', 'placeholder' =>  trans('admin.start_at')]) !!}
    </div>
    <div class="form-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
        {!! Form::label('end_at', trans('admin.end_at')) !!}
        {!! Form::text('end_at', $product->end_at, ['class' => 'form-control datepicker', 'placeholder' =>  trans('admin.end_at')]) !!}
    </div>
    <div class="clearfix" ></div>

    <div class="form-group">
        {!! Form::label('price_offer', trans('admin.price_offer')) !!}
        {!! Form::text('price_offer', $product->price_offer, ['class' => 'form-control', 'placeholder' =>  trans('admin.price_offer')]) !!}
    </div>

    <div class="form-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
        {!! Form::label('start_offer_at', trans('admin.start_offer_at')) !!}
        {!! Form::textarea('start_offer_at', $product->start_offer_at, ['class' => 'form-control datepicker', 'placeholder' =>  trans('admin.start_offer_at')]) !!}
    </div>
    <div class="form-group col-md-6 col-lg-6 col-sm-6 col-xs-12">
        {!! Form::label('end_offer_at', trans('admin.end_offer_at')) !!}
        {!! Form::textarea('end_offer_at', $product->end_offer_at, ['class' => 'form-control datepicker', 'placeholder' =>  trans('admin.end_offer_at')]) !!}
    </div>
    <div class="clearfix" ></div>


    <div class="form-group">
        {!! Form::label('status', trans('admin.status')) !!}
        {!! Form::select('status', $product->status, ['class' => 'form-control', 'placeholder' =>  trans('admin.status')]) !!}
    </div>

</div>
