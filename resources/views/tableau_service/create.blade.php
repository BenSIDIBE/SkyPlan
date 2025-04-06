@extends('layouts.app')

@section('content')

    <livewire:tableau-service-form-component :$semaines  :$semaineSelectionnee  :$week  :$utilisateurs  :$postes > </livewire:tableau-service-form-component>

@endsection
