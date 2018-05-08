@extends('layouts.newLayout')

@section('title')
  Breeder - Egg Quality Characteristics {{-- Specify if breeder or replacement when backend added through variable passed --}}
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Egg Quality Characteristics</h4> {{-- Specify if breeder or replacement when backend added through variable passed --}}
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Province: <strong><u>{{Auth::user()->getFarm()->address}}</u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Farm ID: <strong><u>{{Auth::user()->getFarm()->code}}</u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Breed Name: <strong><u></u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Date Collected: <strong><u></u></strong>
                    </div>
                  </div>
                </div>
              </div>
              {!! Form::open([ 'method' => 'post']) !!}
                {{-- structure  row -> col -> col: input-field --}}
                <div class="row">
                  <div class="col s12 m3 l3">
                    Egg Quality at
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="egg_quality_at" type="radio" id="egg_quality_35" />
                    <label for="egg_quality_35">35 days</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="egg_quality_at" type="radio" id="egg_quality_40" />
                    <label for="egg_quality_40">40 days</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="egg_quality_at" type="radio" id="egg_quality_60" />
                    <label for="egg_quality_60">60 days</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="sample_no" type="text" class="validate" name="sample_no">
                        <label for="sample_no">Sample Number</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="generation" type="text" class="validate" name="generation">
                        <label for="generation">Generation</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="line" type="text" class="validate" name="line">
                        <label for="line">Line</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="family" type="text" class="validate" name="family">
                        <label for="family">Family</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="egg_weigth" type="number" min=0 class="validate" name="egg_weight">
                        <label for="egg_weight">Egg Weight (g)</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="egg_color" type="text" class="validate" name="egg_color" placeholder="e.g. Brown, Cream">
                        <label for="egg_color">Egg Color</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="egg_shape" type="text" class="validate" name="egg_shape" placeholder="e.g. Ovoid">
                        <label for="egg_shape">Egg Shape</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="length" type="number" min=0 class="validate" name="length">
                        <label for="length">Length (mm)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="width" type="number" min=0 class="validate" name="width">
                        <label for="width">Width (mm)</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="shell_weight" type="number" min=0 class="validate" name="shell_weight">
                        <label for="shell_weight">Shell Weight (g)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="col s12 m12 l12">
                        Shell Thickness (mm)
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m4 l4">
                        <input id="top" type="number" min=0 class="validate" name="top">
                        <label for="top">Top</label>
                      </div>
                      <div class="input-field col s12 m4 l4">
                        <input id="middle" type="number" min=0 class="validate" name="middle">
                        <label for="middle">Middle</label>
                      </div>
                      <div class="input-field col s12 m4 l4">
                        <input id="bottom" type="number" min=0 class="validate" name="bottom">
                        <label for="bottom">Bottom</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="abumen_height" type="number" min=0 class="validate" name="albumen_height">
                        <label for="albumen_height">Albument Height (mm)</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="yolk_color" type="text" class="validate" name="yolk_color">
                        <label for="yolk_color">Yolk Color</label>
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
