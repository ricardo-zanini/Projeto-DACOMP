@extends('templates.base')
@section('title', 'Cancelamentos')

@section('content')
    <h1>CANCELAMENTOS</h1>
@endsection

@push('styles')
<style>
   h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding: 50px 0px;
    }
    .subtitle{
        color:#2e96d5;
    }
    .container{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
        justify-content: center;
        align-items: center;
    }

</style>
@endpush