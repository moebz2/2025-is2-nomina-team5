@extends('layouts.admin-layout')

@section('title', 'Configuración')

@section('sidebar')
    @include('configuracion.partials.sidebar')
@endsection


@section('content')

    @if(isset($content))
        {!!$content!!}
    @endif

@endsection
