@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
      <div class="col s12 m12 l12">
        {{$user->name}}
        {{$farm->getFarmType()->species}}
      </div>
    </div>
</div>
@endsection
