@extends('layouts.master')

@section('title')Welcome :)@endsection

@section('content')
    <div class="row h-100 justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="display-1">Hotels 4 U</h1>
            @include('partials.navbar')
        </div>
    </div>
    <div class="row h-100 justify-content-center align-items-center" id="about">
        <div id="cake" class="col-4 mx-auto">
            <div class="image-container">
                <img src="{{ asset('img/bnb.jpg') }}" class="image rounded-circle image-fluid">
                <div class="text-container">
                    <a class="lead underline-hover image-text" href="/properties">Relax</a>
                </div>
            </div>
        </div>
        <div id="cookie" class="col-4 mx-auto">
            <div class="image-container">
                <img src="{{ asset('img/bnb2.jpg') }}" class="image rounded-circle image-fluid">
                <div class="text-container">
                    <a class="lead underline-hover image-text" href="/properties">Serenity</a>
                </div>
            </div>
        </div>
        <div id="icecream" class="col-4 mx-auto">
            <div class="image-container">
                <img src="{{ asset('img/bnb3.jpeg') }}" class="image rounded-circle image-fluid">
                <div class="text-container">
                    <a class="lead underline-hover image-text" href="/properties">Unwind</a>
                </div>
            </div>
        </div>
    </div>
    @if(session()->has('message.level'))
        <div class="alert alert-{{ session('message.level') }}"> 
        {!! session('message.content') !!}
        </div>
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        function login(){
            $.ajax({
                url: 'api/login',
                method: "POST",
                data: { 
                    email: $('#login-email').val(), 
                    password: $('#login-password').val()
                },
                success: function(result){
                    console.log(result);
                }
            });
        }
    </script>
@endsection