@extends('layouts.admin-layout')

@section('title', 'Reportessssssss')

@section('sidebar')
    @include('reportes.partials.sidebar')
@endsection


@section('content')

    @if(isset($content))
        {!!$content!!}
    @endif

@endsection
