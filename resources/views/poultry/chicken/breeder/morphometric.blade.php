@extends('layouts.newLayout')

@section('title')
  Breeder - Morphometric Characteristics{{-- Specify if breeder or replacement when backend added through variable passed --}}
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Morphometric Characteristics</h4> {{-- Specify if breeder or replacement when backend added through variable passed --}}
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Province: <strong><u>{{ $province }}</u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Generation: <strong><u>{{ $properties[2]->value }}</u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Farm ID: <strong><u>{{ $code }}</u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Line: <strong><u> {{ $properties[3]->value }} </u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Breed Name: <strong><u> {{ $breedname }}</u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Family: <strong><u>{{ $properties[4]->value }}</u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Animal Type: <strong><u>{{ ucfirst($animaltype_name) }}</u></strong>
                    </div>
                  </div>
                </div>
              </div>
              {!! Form::open(['route' => 'farm.poultry.fetch_replacement_morphometric_id', 'method' => 'post']) !!}
                {{-- structure  row -> col -> col: input-field --}}
                <input type="hidden" name="animal_id" value="{{ $animal->id }}">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input disabled id="gender" type="text" value="{{ $properties[5]->value }}" >
                        <label for="gender">Gender</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input disabled id="id_no" type="text" value="{{ $properties[1]->value }}">
                        <label for="id_no">ID Number</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="height" type="number" class="validate" name="height" min=0 required>
                        <label for="height">Height (cm)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="body_length" type="number" class="validate" name="body_length" min=0 required>
                        <label for="body_length">Body Length (cm)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="chest_circumference" type="number" class="validate" name="chest_circumference" min=0 required>
                        <label for="chest_circumference">Chest Circumference (cm)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="wing_span" type="number" class="validate" name="wing_span" min=0 required>
                        <label for="wing_span">Wing Span (cm)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="shank_length" type="number" class="validate" name="shank_length" min=0 required>
                        <label for="shank_length">Shank Length (cm)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="date_first_lay" type="text" class="datepicker" name="date_first_lay" required>
                        <label for="date_first_lay">Date at First Lay</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12 center">
                    <button class="btn waves-effect waves-light yellow darken-3" type="submit">Submit
                      <i class="material-icons right">send</i>
                    </button>
                  </div>
                </div>
              {!!Form::close()!!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

@endsection
