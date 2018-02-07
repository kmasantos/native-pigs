@extends('layouts.swinedefault')

@section('title')
  Individual Records
@endsection

@section('content')
  <div class="container">
    <h4>Individual Records</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
      <div class="col s12">
        {{-- TRY THIS --}}
        <form class="row">
          <div class="col s12">
            <div class="input-field">
              <input id="search" type="search">
              <label for="search"><i class="material-icons left">search</i>Search Record</label>
              <i class="material-icons">close</i>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col s12">
            <ul class="tabs tabs-fixed-width red darken-4">
              <li class="tab col s6"><a href="#sowrecords">Sows</a></li>
              <li class="tab col s6"><a href="#boarrecords">Boars</a></li>
            </ul>
          </div>
          <div id="sowrecords" class="col s12">
            <table class="centered striped fixed-width">
              <thead>
                <tr>
                  <th>Registration ID</th>
                  <th>Gross Morphology</th>
                  <th>Morphometric Characteristics</th>
                  <th>Weight Record</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sows as $sow)
                  <tr>
                    @if($sow->phenotypic == 1 || $sow->morphometric == 1 || $sow->weightrecord == 1)
                      <td><a href="{{ URL::route('farm.pig.view_sow', [$sow->id]) }}">{{ $sow->registryid }}</a></td>
                    @elseif($sow->phenotypic == 0 && $sow->morphometric == 0 && $sow->weightrecord == 0)
                      <td>{{ $sow->registryid }}</td>
                    @endif
                    @if($sow->phenotypic == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.gross_morphology_page', [$sow->id]) }}"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($sow->phenotypic == 1)
                      <td>
                        <a href="#!"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                    @if($sow->morphometric == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.pig_morphometric_characteristics_page', [$sow->id]) }}"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($sow->morphometric == 1)
                      <td>
                        <a href="#!"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                    @if($sow->weightrecord == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.weight_records_page', [$sow->id]) }}"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($sow->weightrecord == 1)
                      <td>
                        <a href="#!"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                  </tr>
                @empty
                  <tr>
                    <td>
                      No sow data found
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div id="boarrecords" class="col s12">
            <table class="centered striped">
              <thead>
                <tr>
                  <th>Registration ID</th>
                  <th>Gross Morphology</th>
                  <th>Morphometric Characteristics</th>
                  <th>Weight Record</th>
                </tr>
              </thead>
              <tbody>
                @forelse($boars as $boar)
                  <tr>
                    @if($boar->phenotypic == 1 || $boar->morphometric == 1 || $boar->weightrecord == 1)
                      <td><a href="{{ URL::route('farm.pig.view_boar', [$boar->id]) }}"> {{ $boar->registryid }}</a></td>
                    @elseif($boar->phenotypic == 0 && $boar->morphometric == 0 && $boar->weightrecord == 0)
                      <td>{{ $boar->registryid }}</td>
                    @endif
                    @if($boar->phenotypic == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.gross_morphology_page', [$boar->id]) }}"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($boar->phenotypic == 1)
                      <td>
                        <a href="#!"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                    @if($boar->morphometric == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.pig_morphometric_characteristics_page', [$boar->id]) }}"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($boar->morphometric == 1)
                      <td>
                        <a href="#!"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                     @if($boar->weightrecord == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.weight_records_page', [$boar->id]) }}"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($boar->weightrecord == 1)
                      <td>
                        <a href="#!"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                  </tr>
                @empty
                  <tr>
                    <td>No boar data found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection