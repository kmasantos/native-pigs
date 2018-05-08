@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
      <div class="col s12 m12 l12">
        <a href="{{Auth::logout()}}">Logout</a>
      </div>
    </div>
</div>
@endsection
