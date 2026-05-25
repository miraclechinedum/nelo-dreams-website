@extends('layouts.app')

@section('content')
    <span id="top" class="sr-only"></span>

    @include('partials.home.hero')
    @include('partials.home.about')
    @include('partials.home.objectives')
    @include('partials.home.programs')
    @include('partials.home.values')
    @include('partials.home.impact')
    @include('partials.home.testimonials')
    @include('partials.home.partnership')
    @include('partials.home.approach')
    @include('partials.home.cta')
    @include('partials.home.contact')
@endsection
