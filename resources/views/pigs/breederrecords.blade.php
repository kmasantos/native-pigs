@extends('layouts.swinedefault')

@section('title')
  Breeder Records
@endsection

@section('content')
  <div class="container">
    <h4>Breeder Records</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;">
      {!! Form::open(['route' => 'farm.pig.search_breeders', 'method' => 'post', 'role' => 'search']) !!}
      {{ csrf_field() }}
      <div class="input-field col s12">
        <input type="text" name="q" placeholder="Search breeder" class="col s9">
        <button type="submit" class="btn green darken-4">Search <i class="material-icons right">search</i></button>
      </div>
      {!! Form::close() !!}
      @if(isset($details))
        <div class="row">
          <div class="col s12">
            <h5 class="center">Search results for <strong>{{ $query }}</strong>:</h5>
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
                @foreach($details as $breeder)
                  <tr>
                    @if($breeder->status == "dead breeder" || $breeder->status == "sold breeder" || $breeder->status == "removed breeder")
                      @if($breeder->getAnimalProperties()->where("property_id", 2)->first()->value == 'F')
                        @if(is_null($breeder->getAnimalProperties()->where("property_id", 64)->first()))
                          <td><a href="{{ URL::route('farm.pig.view_sow', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a></td>
                        @else
                          <td><a href="{{ URL::route('farm.pig.view_sow', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a> (Old ID: {{ $breeder->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                        @endif
                      @elseif($breeder->getAnimalProperties()->where("property_id", 2)->first()->value == 'M')
                        @if(is_null($breeder->getAnimalProperties()->where("property_id", 64)->first()))
                          <td><a href="{{ URL::route('farm.pig.view_boar', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a></td>
                        @else
                          <td><a href="{{ URL::route('farm.pig.view_boar', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a> (Old ID: {{ $breeder->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                        @endif
                      @endif
                      <td colspan="3">{{$breeder->status}}, cannot add or edit records</td>
                    @else
                      @if($breeder->grossmorpho == 1 || $breeder->morphochars == 1 || $breeder->weightrecord == 1)
                        @if($breeder->getAnimalProperties()->where("property_id", 2)->first()->value == 'F')
                          @if(is_null($breeder->getAnimalProperties()->where("property_id", 64)->first()))
                            <td><a href="{{ URL::route('farm.pig.view_sow', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a></td>
                          @else
                            <td><a href="{{ URL::route('farm.pig.view_sow', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a> (Old ID: {{ $breeder->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                          @endif
                        @elseif($breeder->getAnimalProperties()->where("property_id", 2)->first()->value == 'M')
                          @if(is_null($breeder->getAnimalProperties()->where("property_id", 64)->first()))
                            <td><a href="{{ URL::route('farm.pig.view_boar', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a></td>
                          @else
                            <td><a href="{{ URL::route('farm.pig.view_boar', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="View breeder">{{ $breeder->registryid }}</a> (Old ID: {{ $breeder->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                          @endif
                        @endif
                      @elseif($breeder->grossmorpho == 0 && $breeder->morphochars == 0 && $breeder->weightrecord == 0)
                        @if(is_null($breeder->getAnimalProperties()->where("property_id", 64)->first()))
                          <td>{{ $breeder->registryid }}</td>
                        @else
                          <td>{{ $breeder->registryid }} (Old ID: {{ $breeder->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                        @endif
                      @endif
                      @if($breeder->grossmorpho == 0)
                        <td>
                          <a href="{{ URL::route('farm.pig.gross_morphology_page', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                        </td>
                      @elseif($breeder->grossmorpho == 1)
                        <td>
                          <a href="{{ URL::route('farm.pig.edit_gross_morphology_page', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                        </td>
                      @endif
                      @if($breeder->morphochars == 0)
                        <td>
                          <a href="{{ URL::route('farm.pig.pig_morphometric_characteristics_page', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                        </td>
                      @elseif($breeder->morphochars == 1)
                        <td>
                          <a href="{{ URL::route('farm.pig.edit_pig_morphometric_characteristics_page', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                        </td>
                      @endif
                      @if($breeder->weightrecord == 0)
                        <td>
                          <a href="{{ URL::route('farm.pig.weight_records_page', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="Add"><i class="material-icons">add_circle_outline</i></a>
                        </td>
                      @elseif($breeder->weightrecord == 1)
                        <td>
                          <a href="{{ URL::route('farm.pig.edit_weight_records_page', [$breeder->id]) }}" class="tooltipped" data-position="top" data-tooltip="Edit"><i class="material-icons">edit</i></a>
                        </td>
                      @endif
                    @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @elseif(isset($message))
        <h5 class="center">{{ $message }}</h5>
      @endif
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
                      @if(is_null($sow->getAnimalProperties()->where("property_id", 64)->first()))
                        <td><a href="{{ URL::route('farm.pig.view_sow', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="View sow">{{ $sow->registryid }}</a></td>
                      @else
                        <td><a href="{{ URL::route('farm.pig.view_sow', [$sow->id]) }}" class="tooltipped" data-position="top" data-tooltip="View sow">{{ $sow->registryid }}</a> (Old ID: {{ $sow->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                      @endif
                    @elseif($sow->grossmorpho == 0 && $sow->morphochars == 0 && $sow->weightrecord == 0)
                      @if(is_null($sow->getAnimalProperties()->where("property_id", 64)->first()))
                        <td>{{ $sow->registryid }}</td>
                      @else
                        <td>{{ $sow->registryid }} (Old ID: {{ $sow->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                      @endif
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
            @if($archived_sows == [])
            @else
              <div class="row">
                <div class="col s12">
                  <ul class="collapsible popout">
                    <li>
                      <div class="collapsible-header grey lighten-2">Archive</div>
                      <div class="collapsible-body">
                        <table class="fixed-width">
                          <thead>
                            <tr>
                              <th>Registration ID</th>
                              <th>Status</th>
                              <th>View Record</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($archived_sows as $archived_sow)
                              <tr>
                                @if(is_null($archived_sow->getAnimalProperties()->where("property_id", 64)->first()))
                                  <td>{{ $archived_sow->registryid }}</td>
                                @else
                                  <td>{{ $archived_sow->registryid }} (Old ID: {{ $archived_sow->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                                @endif
                                @if($archived_sow->status == "dead breeder")
                                  <td>Dead</td>
                                @elseif($archived_sow->status == "sold breeder")
                                  <td>Sold</td>
                                @elseif($archived_sow->status == "removed breeder")
                                  <td>Removed from herd</td>
                                @endif
                                <td class="center">
                                  <a href="{{ URL::route('farm.pig.view_sow', [$archived_sow->id]) }}"><i class="material-icons">visibility_on</i></a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            @endif
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
                      @if(is_null($boar->getAnimalProperties()->where("property_id", 64)->first()))
                        <td><a href="{{ URL::route('farm.pig.view_boar', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="View boar"> {{ $boar->registryid }}</a></td>
                      @else
                        <td><a href="{{ URL::route('farm.pig.view_boar', [$boar->id]) }}" class="tooltipped" data-position="top" data-tooltip="View boar"> {{ $boar->registryid }}</a> (Old ID: {{$boar->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                      @endif
                    @elseif($boar->grossmorpho == 0 && $boar->morphochars == 0 && $boar->weightrecord == 0)
                      @if(is_null($boar->getAnimalProperties()->where("property_id", 64)->first()))
                        <td>{{ $boar->registryid }}</td>
                      @else
                        <td>{{ $boar->registryid }} (Old ID: {{ $boar->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                      @endif
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
            @if($archived_boars == [])
            @else
              <div class="row">
                <div class="col s12">
                  <ul class="collapsible popout">
                    <li>
                      <div class="collapsible-header grey lighten-2">Archive</div>
                      <div class="collapsible-body">
                        <table class="fixed-width">
                          <thead>
                            <tr>
                              <th>Registration ID</th>
                              <th>Status</th>
                              <th>View Record</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($archived_boars as $archived_boar)
                              <tr>
                                @if(is_null($archived_boar->getAnimalProperties()->where("property_id", 64)->first()))
                                  <td>{{ $archived_boar->registryid }}</td>
                                @else
                                  <td>{{ $archived_boar->registryid }} (Old ID: {{ $archived_boar->getAnimalProperties()->where("property_id", 64)->first()->value }})</td>
                                @endif
                                @if($archived_boar->status == "dead breeder")
                                  <td>Dead</td>
                                @elseif($archived_boar->status == "sold breeder")
                                  <td>Sold</td>
                                @elseif($archived_boar->status == "removed breeder")
                                  <td>Removed from herd</td>
                                @endif
                                <td class="center">
                                  <a href="{{ URL::route('farm.pig.view_boar', [$archived_boar->id]) }}"><i class="material-icons">visibility_on</i></a>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            @endif
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