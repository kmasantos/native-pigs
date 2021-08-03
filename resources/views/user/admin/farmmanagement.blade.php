@extends('layouts.default')

@section('title')
    Farm Management
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h4>Farm Management</h4>
            <div class="divider"></div>
            @if (\Session::has('success'))
                <div class="row light-green lighten-3">
                    <div class="col s12">
                        <h5 class="center">{!! \Session::get('success') !!}</h5>
                    </div>
                </div>
            @endif
            <div class="row center">
                <h5>Data as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
                <div class="col s12 m10 l12">
                    <table class="centered striped">
                        <thead class="green lighten-1">
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Province</th>
                                <th>Breed</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($farms as $farm)
                                <tr>
                                    <td>{{ $farm->name }}</td>
                                    <td>{{ $farm->code }}</td>
                                    <td>{{ $farm->province }}</td>
                                    <td>{{ $farm->getBreed()->breed }}</td>
                                    <td><a href="#edit_farm{{ $farm->id }}" class="tooltipped modal-trigger"
                                            data-position="top" data-tooltip="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    </td>
                                    @if (empty($farm->deleted_at))
                                        <a href="#delete_farm{{ $farm->id }}" class="tooltipped modal-trigger"
                                            data-position="top" data-tooltip="Delete farm?"><i
                                                class="fas fa-trash-alt"></i></a>
                                    @else
                                        <a href="#delete_farm{{ $farm->id }}" class="tooltipped modal-trigger"
                                            data-position="top" data-tooltip="Restore farm?"><i
                                                class="fas fa-trash-restore-alt"></i></a>
                                    @endif
                                </tr>
								<div id="delete_farm{{ $farm->id }}" class="modal">
                                    {!! Form::open(['route' => 'admin.delete_farm', 'method' => 'post']) !!}
                                    <div class="modal-content">
                                        <h5 class="center">{{ $farm->deleted_at ? 'Restore' : 'Delete' }} Farm
                                            {{ $farm->name }}</h5>
                                        <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                                    </div>
                                    <div class="row center">
                                        <button class="btn waves-effect waves-light green darken-3" type="submit">
                                            {{ $farm->deleted_at ? 'Restore' : 'Delete' }} <i
                                                class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                {{-- MODAL STRUCTURE --}}
                                <div id="edit_farm{{ $farm->id }}" class="modal">
                                    {!! Form::open(['route' => 'admin.edit_farm', 'method' => 'post']) !!}
                                    <div class="modal-content">
                                        <h5 class="center">Edit Farm {{ $farm->name }}</h5>
                                        <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                                        <div class="row center">
                                            <div class="input-field col s8 m8 l8 offset-s2 offset-m2 offset-l2">
                                                <input id="name" type="text" name="name" class="validate"
                                                    value="{{ $farm->name }}" required>
                                                <label for="name">Name</label>
                                            </div>
                                        </div>
                                        <div class="row center">
                                            <div class="col s6 m6 l6">
                                                <select name="province" class="browser-default" required>
                                                    <option value="" disabled selected>Choose province</option>
                                                    <optgroup label="Region I">
                                                        <option value="Ilocos Norte">Ilocos Norte</option>
                                                        <option value="Ilocos Sur">Ilocos Sur</option>
                                                        <option value="La Union">La Union</option>
                                                        <option value="Pangasinan">Pangasinan</option>
                                                    </optgroup>
                                                    <optgroup label="Region II">
                                                        <option value="Batanes">Batanes</option>
                                                        <option value="Cagayan">Cagayan</option>
                                                        <option value="Isabela">Isabela</option>
                                                        <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                                                        <option value="Quirino">Quirino</option>
                                                    </optgroup>
                                                    <optgroup label="CAR">
                                                        <option value="Abra">Abra</option>
                                                        <option value="Apayao">Apayao</option>
                                                        <option value="Benguet">Benguet</option>
                                                        <option value="Ifugao">Ifugao</option>
                                                        <option value="Kalinga">Kalinga</option>
                                                        <option value="Mountain Province">Mountain Province</option>
                                                    </optgroup>
                                                    <optgroup label="Region III">
                                                        <option value="Aurora">Aurora</option>
                                                        <option value="Bataan">Bataan</option>
                                                        <option value="Bulacan">Bulacan</option>
                                                        <option value="Nueva Ecija">Nueva Ecija</option>
                                                        <option value="Pampanga">Pampanga</option>
                                                        <option value="Tarlac">Tarlac</option>
                                                        <option value="Zambales">Zambales</option>
                                                    </optgroup>
                                                    <optgroup label="NCR">
                                                        <option value="Metro Manila">Metro Manila</option>
                                                    </optgroup>
                                                    <optgroup label="Region IV-A">
                                                        <option value="Batangas">Batangas</option>
                                                        <option value="Cavite">Cavite</option>
                                                        <option value="Laguna">Laguna</option>
                                                        <option value="Quezon">Quezon</option>
                                                        <option value="Rizal">Rizal</option>
                                                    </optgroup>
                                                    <optgroup label="Region IV-B">
                                                        <option value="Marinduque">Marinduque</option>
                                                        <option value="Occidental Mindoro">Occidental Mindoro</option>
                                                        <option value="Oriental Mindoro">Oriental Mindoro</option>
                                                        <option value="Palawan">Palawan</option>
                                                        <option value="Romblon">Romblon</option>
                                                    </optgroup>
                                                    <optgroup label="Region V">
                                                        <option value="Albay">Albay</option>
                                                        <option value="Camarines Norte">Camarines Norte</option>
                                                        <option value="Camarines Sur">Camarines Sur</option>
                                                        <option value="Catanduanes">Catanduanes</option>
                                                        <option value="Masbate">Masbate</option>
                                                        <option value="Sorsogon">Sorsogon</option>
                                                    </optgroup>
                                                    <optgroup label="Region VI">
                                                        <option value="Aklan">Aklan</option>
                                                        <option value="Antique">Antique</option>
                                                        <option value="Capiz">Capiz</option>
                                                        <option value="Guimaras">Guimaras</option>
                                                        <option value="Iloilo">Iloilo</option>
                                                        <option value="Negros Occidental">Negros Occidental</option>
                                                    </optgroup>
                                                    <optgroup label="Region VII">
                                                        <option value="Bohol">Bohol</option>
                                                        <option value="Cebu">Cebu</option>
                                                        <option value="Siquijor">Siquijor</option>
                                                        <option value="Negros Oriental">Negros Oriental</option>
                                                    </optgroup>
                                                    <optgroup label="Region VIII">
                                                        <option value="Eastern Samar">Eastern Samar</option>
                                                        <option value="Leyte">Leyte</option>
                                                        <option value="Northern Samar">Northern Samar</option>
                                                        <option value="Samar">Samar</option>
                                                        <option value="Southern Leyte">Southern Leyte</option>
                                                    </optgroup>
                                                    <optgroup label="Region IX">
                                                        <option value="Zamboanga del Norte">Zamboanga del Norte</option>
                                                        <option value="Zamboanga del Sur">Zamboanga del Sur</option>
                                                        <option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
                                                    </optgroup>
                                                    <optgroup label="Region X">
                                                        <option value="Bukidnon">Bukidnon</option>
                                                        <option value="Camiguin">Camiguin</option>
                                                        <option value="Lanao del Norte">Lanao del Norte</option>
                                                        <option value="Misamis Occidental">Misamis Occidental</option>
                                                        <option value="Misamis Oriental">Misamis Oriental</option>
                                                    </optgroup>
                                                    <optgroup label="Region XI">
                                                        <option value="Compostela Valley">Compostela Valley</option>
                                                        <option value="Davao del Norte">Davao del Norte</option>
                                                        <option value="Davao del Sur">Davao del Sur</option>
                                                        <option value="Davao Occidental">Davao Occidental</option>
                                                        <option value="Davao Oriental">Davao Oriental</option>
                                                    </optgroup>
                                                    <optgroup label="Region XII">
                                                        <option value="Cotabato">Cotabato</option>
                                                        <option value="Sarangani">Sarangani</option>
                                                        <option value="South Cotabato">South Cotabato</option>
                                                        <option value="Sultan Kudarat">Sultan Kudarat</option>
                                                    </optgroup>
                                                    <optgroup label="Region XIII">
                                                        <option value="Agusan del Norte">Agusan del Norte</option>
                                                        <option value="Agusan del Sur">Agusan del Sur</option>
                                                        <option value="Dinagat Islands">Dinagat Islands</option>
                                                        <option value="Surigao del Norte">Surigao del Norte</option>
                                                        <option value="Surigao del Sur">Surigao del Sur</option>
                                                    </optgroup>
                                                    <optgroup label="ARMM">
                                                        <option value="Basilan">Basilan</option>
                                                        <option value="Lanao del Sur">Lanao del Sur</option>
                                                        <option value="Maguindanao">Maguindanao</option>
                                                        <option value="Sulu">Sulu</option>
                                                        <option value="Tawi-Tawi">Tawi-Tawi</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col s6 m6 l6">
                                                <select name="breed" class="browser-default" required>
                                                    <option value="" disabled selected>Choose breed</option>
                                                    @foreach ($breeds as $breed)
                                                        <option value="{{ $breed->id }}">{{ $breed->breed }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row center">
                                        <button class="btn waves-effect waves-light green darken-3" type="submit">
                                            Submit <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            @empty
                                <tr>No Farms Available</tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large green darken-4 modal-trigger" href="#add_farm">
                    <i class="large material-icons">add</i>
                </a>
            </div>
            {{-- MODAL STRUCTURE --}}
            <div id="add_farm" class="modal">
                {!! Form::open(['route' => 'admin.fetch_farm', 'method' => 'post']) !!}
                <div class="modal-content">
                    <h5 class="center">Add New Farm</h5>
                    <div class="row center">
                        <div class="input-field col s8 m8 l8 offset-s2 offset-m2 offset-l2">
                            <input id="name" type="text" name="new_name" class="validate" required>
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="row center">
                        <div class="col s6 m6 l6">
                            <select name="new_province" class="browser-default" required>
                                <option value="" disabled selected>Choose province</option>
                                <optgroup label="Region I">
                                    <option value="Ilocos Norte">Ilocos Norte</option>
                                    <option value="Ilocos Sur">Ilocos Sur</option>
                                    <option value="La Union">La Union</option>
                                    <option value="Pangasinan">Pangasinan</option>
                                </optgroup>
                                <optgroup label="Region II">
                                    <option value="Batanes">Batanes</option>
                                    <option value="Cagayan">Cagayan</option>
                                    <option value="Isabela">Isabela</option>
                                    <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                                    <option value="Quirino">Quirino</option>
                                </optgroup>
                                <optgroup label="CAR">
                                    <option value="Abra">Abra</option>
                                    <option value="Apayao">Apayao</option>
                                    <option value="Benguet">Benguet</option>
                                    <option value="Ifugao">Ifugao</option>
                                    <option value="Kalinga">Kalinga</option>
                                    <option value="Mountain Province">Mountain Province</option>
                                </optgroup>
                                <optgroup label="Region III">
                                    <option value="Aurora">Aurora</option>
                                    <option value="Bataan">Bataan</option>
                                    <option value="Bulacan">Bulacan</option>
                                    <option value="Nueva Ecija">Nueva Ecija</option>
                                    <option value="Pampanga">Pampanga</option>
                                    <option value="Tarlac">Tarlac</option>
                                    <option value="Zambales">Zambales</option>
                                </optgroup>
                                <optgroup label="NCR">
                                    <option value="Metro Manila">Metro Manila</option>
                                </optgroup>
                                <optgroup label="Region IV-A">
                                    <option value="Batangas">Batangas</option>
                                    <option value="Cavite">Cavite</option>
                                    <option value="Laguna">Laguna</option>
                                    <option value="Quezon">Quezon</option>
                                    <option value="Rizal">Rizal</option>
                                </optgroup>
                                <optgroup label="Region IV-B">
                                    <option value="Marinduque">Marinduque</option>
                                    <option value="Occidental Mindoro">Occidental Mindoro</option>
                                    <option value="Oriental Mindoro">Oriental Mindoro</option>
                                    <option value="Palawan">Palawan</option>
                                    <option value="Romblon">Romblon</option>
                                </optgroup>
                                <optgroup label="Region V">
                                    <option value="Albay">Albay</option>
                                    <option value="Camarines Norte">Camarines Norte</option>
                                    <option value="Camarines Sur">Camarines Sur</option>
                                    <option value="Catanduanes">Catanduanes</option>
                                    <option value="Masbate">Masbate</option>
                                    <option value="Sorsogon">Sorsogon</option>
                                </optgroup>
                                <optgroup label="Region VI">
                                    <option value="Aklan">Aklan</option>
                                    <option value="Antique">Antique</option>
                                    <option value="Capiz">Capiz</option>
                                    <option value="Guimaras">Guimaras</option>
                                    <option value="Iloilo">Iloilo</option>
                                    <option value="Negros Occidental">Negros Occidental</option>
                                </optgroup>
                                <optgroup label="Region VII">
                                    <option value="Bohol">Bohol</option>
                                    <option value="Cebu">Cebu</option>
                                    <option value="Siquijor">Siquijor</option>
                                    <option value="Negros Oriental">Negros Oriental</option>
                                </optgroup>
                                <optgroup label="Region VIII">
                                    <option value="Eastern Samar">Eastern Samar</option>
                                    <option value="Leyte">Leyte</option>
                                    <option value="Northern Samar">Northern Samar</option>
                                    <option value="Samar">Samar</option>
                                    <option value="Southern Leyte">Southern Leyte</option>
                                </optgroup>
                                <optgroup label="Region IX">
                                    <option value="Zamboanga del Norte">Zamboanga del Norte</option>
                                    <option value="Zamboanga del Sur">Zamboanga del Sur</option>
                                    <option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
                                </optgroup>
                                <optgroup label="Region X">
                                    <option value="Bukidnon">Bukidnon</option>
                                    <option value="Camiguin">Camiguin</option>
                                    <option value="Lanao del Norte">Lanao del Norte</option>
                                    <option value="Misamis Occidental">Misamis Occidental</option>
                                    <option value="Misamis Oriental">Misamis Oriental</option>
                                </optgroup>
                                <optgroup label="Region XI">
                                    <option value="Compostela Valley">Compostela Valley</option>
                                    <option value="Davao del Norte">Davao del Norte</option>
                                    <option value="Davao del Sur">Davao del Sur</option>
                                    <option value="Davao Occidental">Davao Occidental</option>
                                    <option value="Davao Oriental">Davao Oriental</option>
                                </optgroup>
                                <optgroup label="Region XII">
                                    <option value="Cotabato">Cotabato</option>
                                    <option value="Sarangani">Sarangani</option>
                                    <option value="South Cotabato">South Cotabato</option>
                                    <option value="Sultan Kudarat">Sultan Kudarat</option>
                                </optgroup>
                                <optgroup label="Region XIII">
                                    <option value="Agusan del Norte">Agusan del Norte</option>
                                    <option value="Agusan del Sur">Agusan del Sur</option>
                                    <option value="Dinagat Islands">Dinagat Islands</option>
                                    <option value="Surigao del Norte">Surigao del Norte</option>
                                    <option value="Surigao del Sur">Surigao del Sur</option>
                                </optgroup>
                                <optgroup label="ARMM">
                                    <option value="Basilan">Basilan</option>
                                    <option value="Lanao del Sur">Lanao del Sur</option>
                                    <option value="Maguindanao">Maguindanao</option>
                                    <option value="Sulu">Sulu</option>
                                    <option value="Tawi-Tawi">Tawi-Tawi</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col s6 m6 l6">
                            <select name="new_breed" class="browser-default" required>
                                <option value="" disabled selected>Choose breed</option>
                                @foreach ($breeds as $breed)
                                    <option value="{{ $breed->id }}">{{ $breed->breed }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row center">
                    <button class="btn waves-effect waves-light green darken-3" type="submit"
                        onclick="Materialize.toast('New farm added successfully!', 4000)">
                        Submit <i class="material-icons right">send</i>
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
