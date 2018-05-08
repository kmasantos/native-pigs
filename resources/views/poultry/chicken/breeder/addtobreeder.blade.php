@extends('layouts.newLayout')

@section('title')
  Breeder - Add to Family
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Add to Breeder Group</h4>
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              {!! Form::open(['method' => 'post']) !!}
                <div class="row">
                  <div class="col s12 m12 l12">
                    {{-- <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <select>
                          <option value="" disabled selected>Select Family</option>
                          @forelse ($families as $family)
                            <option value="{{$family->value}}">{{$family->value}}</option>
                          @empty
                            No Available Families
                          @endforelse
                        </select>
                        <label>Family</label>
                      </div>
                    </div> --}}
                    {{-- <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <select>
                          <option value="" disabled selected>Select Father ID</option>
                          @forelse ($malebreeders as $male)
                            <option value="{{$male->value}}">{{$male->value}}</option>
                          @empty
                            No Available Families
                          @endforelse
                        </select>
                        <label>Father</label>
                      </div>
                    </div> --}}
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <i class="material-icons prefix">search</i>
                        <input id="search" type="text" class="validate tooltipped" data-position="bottom" data-delay="50" data-tooltip="Search for animal's registry ID">
                        <label for="search">Search ID</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <table class="bordered highlight responsive-table centered">
                      <thead>
                        <tr>
                          <th data-field="id">Registry ID</th>
                          <th data-field="action1">Add to Family</th>
                          <th data-field="action2">Create Family</th>
                        </tr>
                      </thead>

                      <tbody>
                        @forelse ($replacements as $replacement)
                          @if (substr($replacement->registryid, 16, 1) == 'M')
                            <tr>
                              <td>{{$replacement->registryid}}</td>
                              <td>
                                <a class="modal-trigger" href="#add_to_family_modal"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                              </td>
                              <td>
                                <a href="{{ URL::route('farm.poultry.create_family_id', [$replacement->id]) }}"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
                              </td>
                            </tr>
                            @else
                              <tr>
                                <td>{{$replacement->registryid}}</td>
                                <td>
                                  <a class="modal-trigger" href="#add_to_family_modal"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                  <i class="fa fa-list-alt tooltipped" aria-hidden="true" data-position="bottom" data-delay="50" data-tooltip="Action not available"></i>
                                </td>
                              </tr>
                          @endif

                        @empty
                          <tr>
                            <td></td>
                            <td>No Animals in Replacement Stocks</td>
                            <td></td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- Modal Structure -->
                <div id="add_to_family_modal" class="modal modal-fixed-footer">
                  <div class="modal-content">
                    <h4>Add to Family</h4>
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <select>
                          <option value="" disabled selected>Select Family</option>
                            @forelse ($families as $family)
                            <option value="{{$family->value}}">{{$family->value}}</option>
                          @empty
                            No Available Families
                          @endforelse
                        </select>
                        <label>Family</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
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
