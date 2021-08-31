@extends("layouts.landing")

@section("title", "Klaida")

@section("content")
    <h2 class="content--title">{{ $error ?? "Įvyko klaida!" }}</h2>
@endsection