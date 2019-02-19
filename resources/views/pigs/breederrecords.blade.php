@extends('layouts.swinedefault')

@section('title')
  Breeder Records
@endsection

@section('content')
  <div class="container">
    <h4>Breeder Records</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
      <div class="col s12">
        <div class="row">
          <div class="col s12">
            <ul class="tabs tabs-fixed-width green lighten-1">
              <li class="tab"><a href="#sowrecords">Sows</a></li>
              <li class="tab"><a href="#boarrecords">Boars</a></li>
            </ul>
          </div>
          <div id="sowrecords" class="col s12" style="padding-top:10px;">
            <table class="centered striped fixed-width">
              <thead class="green lighten-1">
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
                    @if($sow->grossmorpho == 1 || $sow->morphochars == 1 || $sow->weightrecord == 1)
                      <td><a href="{{ URL::route('farm.pig.view_sow', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="View sow">{{ $sow->registryid }}</a></td>
                    @elseif($sow->grossmorpho == 0 && $sow->morphochars == 0 && $sow->weightrecord == 0)
                      <td>{{ $sow->registryid }}</td>
                    @endif
                    @if($sow->grossmorpho == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.gross_morphology_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($sow->grossmorpho == 1)
                      <td>
                        <a href="{{ URL::route('farm.pig.edit_gross_morphology_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                    @if($sow->morphochars == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.pig_morphometric_characteristics_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($sow->morphochars == 1)
                      <td>
                        <a href="{{ URL::route('farm.pig.edit_pig_morphometric_characteristics_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                    @if($sow->weightrecord == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.weight_records_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($sow->weightrecord == 1)
                      <td>
                        <a href="{{ URL::route('farm.pig.edit_weight_records_page', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                  </tr>
                @empty
                  <tr>
                    <td colspan="4">No sow data found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div id="boarrecords" class="col s12" style="padding-top: 10px;">
            <table class="centered striped">
              <thead class="green lighten-1">
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
                    @if($boar->grossmorpho == 1 || $boar->morphochars == 1 || $boar->weightrecord == 1)
                      <td><a href="{{ URL::route('farm.pig.view_boar', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="View boar"> {{ $boar->registryid }}</a></td>
                    @elseif($boar->grossmorpho == 0 && $boar->morphochars == 0 && $boar->weightrecord == 0)
                      <td>{{ $boar->registryid }}</td>
                    @endif
                    @if($boar->grossmorpho == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.gross_morphology_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($boar->grossmorpho == 1)
                      <td>
                        <a href="{{ URL::route('farm.pig.edit_gross_morphology_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                    @if($boar->morphochars == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.pig_morphometric_characteristics_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($boar->morphochars == 1)
                      <td>
                        <a href="{{ URL::route('farm.pig.edit_pig_morphometric_characteristics_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                    @if($boar->weightrecord == 0)
                      <td>
                        <a href="{{ URL::route('farm.pig.weight_records_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                      </td>
                    @elseif($boar->weightrecord == 1)
                      <td>
                        <a href="{{ URL::route('farm.pig.edit_weight_records_page', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                      </td>
                    @endif
                  </tr>
                @empty
                  <tr>
                    <td colspan="4">No boar data found</td>
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

@section('scripts')
  <script type="text/javascript">
      $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false, // Close upon selecting a date,
        format: 'yyyy-mm-dd', 
        max: new Date()
      });
  </script>
@endsection