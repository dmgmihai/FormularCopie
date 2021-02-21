@extends('forms.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('forms.index') }}"> Back</a>  {{-- headere--}}
        </div>
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<script src='https://www.google.com/recaptcha/api.js'></script>
<form action="{{ route('forms.store') }}" method="POST">
    @csrf
    <script src='https://www.google.com/recaptcha/api.js'></script>
    
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="text" name="email" class="form-control" placeholder="Email">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Phone:</strong>
                <input type="text" name="phone" class="form-control" placeholder="Phone">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Detail:</strong>
                <textarea rows="4" cols="50" maxlength="300" class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Captcha</label>
                    <div class="col-md-6 pull-center">
                        {!! app('captcha')->display() !!}
                            @if(config('services.recaptcha.key'))
                                <div class="g-recaptcha"
                                        data-sitekey="{{config('services.recaptcha.key')}}">
                                </div>
                            @endif
                    
                    </div>
             
             </div>
        
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! NoCaptcha::renderJs() !!}
</form>
@endsection