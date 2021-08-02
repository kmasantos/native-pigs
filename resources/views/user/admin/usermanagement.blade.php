@extends('layouts.default')

@section('title')
    User Management
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h4>User Management</h4>
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
                <div class="row center" style="padding-top: 10px;">
                    @if (isset($error))
                        <div class="row red lighten-3">
                            <div class="col s12">
                                <h5 class="center">{{ $error }}</h5>
                            </div>
                        </div>
                    @elseif(isset($message))
                        <div class="row light-green lighten-3">
                            <div class="col s12">
                                <h5 class="center">{{ $message }}</h5>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col s12 m10 l12">
                    <table class="centered striped">
                        <thead class="green lighten-1">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Farm</th>
                                <th>Last Login</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->getFarm()->name }}</td>
                                    <td>{{ Carbon\Carbon::parse($user->lastseen)->format('j F, Y h:i A') }}</td>
                                    <td>
                                        <a href="#edit_user{{ $user->id }}" class="tooltipped modal-trigger"
                                            data-position="top" data-tooltip="Edit"><i class="fas fa-pencil-alt"></i></a>
										<a href="#mimic_user{{ $user->id }}" class="tooltipped modal-trigger"
												data-position="top" data-tooltip="Mimic user?"><i class="fas fa-sign-in-alt"></i></a>
											@if (empty($user->deleted_at))
                                            <a href="#delete_user{{ $user->id }}" class="tooltipped modal-trigger"
                                                data-position="top" data-tooltip="Delete user?"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        @else
                                            <a href="#delete_user{{ $user->id }}" class="tooltipped modal-trigger"
                                                data-position="top" data-tooltip="Restore user?"><i
                                                    class="fas fa-trash-restore-alt"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                {{-- MODAL STRUCTURE --}}
                                <div id="edit_user{{ $user->id }}" class="modal">
                                    {!! Form::open(['route' => 'admin.edit_user', 'method' => 'post']) !!}
                                    <div class="modal-content">
                                        <h5 class="center">Edit User {{ $user->name }}</h5>
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <div class="row center">
                                            <div class="input-field col s6 m6 l6">
                                                <input id="name" type="text" name="username" class="validate"
                                                    value="{{ $user->name }}" required>
                                                <label for="name">Name</label>
                                            </div>
                                            <div class="input-field col s6 m6 l6">
                                                <input id="email" type="email" name="user_email" class="validate"
                                                    value="{{ $user->email }}" required>
                                                <label for="email">Email</label>
                                                <span class="helper-text" data-error="invalid" data-success="valid"></span>
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
                                <div id="delete_user{{ $user->id }}" class="modal">
                                    {!! Form::open(['route' => 'admin.delete_user', 'method' => 'post']) !!}
                                    <div class="modal-content">
                                        <h5 class="center">{{ $user->deleted_at ? 'Restore' : 'Delete' }} User
                                            {{ $user->name }}</h5>
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    </div>
                                    <div class="row center">
                                        <button class="btn waves-effect waves-light green darken-3" type="submit">
                                            {{ $user->deleted_at ? 'Restore' : 'Delete' }} <i
                                                class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
								<div id="mimic_user{{ $user->id }}" class="modal">
                                    {!! Form::open(['route' => 'admin.mimic_user', 'method' => 'post']) !!}
                                    <div class="modal-content">
                                        <h5 class="center">Log in as User
                                            {{ $user->name }}</h5>
											<p>This will generate a log in link which will be valid for 5 minutes. You need to click on the link in a different browser or a private browsing session to log in as that user.</p>
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    </div>
                                    <div class="row center">
                                        <button class="btn waves-effect waves-light green darken-3" type="submit">
                                            Log in as user <i
                                                class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            @empty
                                <tr>No Users Available</tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large green darken-4 modal-trigger" href="#add_user">
                    <i class="large material-icons">add</i>
                </a>
            </div>
            {{-- MODAL STRUCTURE --}}
            <div id="add_user" class="modal">
                {!! Form::open(['route' => 'admin.fetch_user', 'method' => 'post']) !!}
                <div class="modal-content">
                    <h5 class="center">Add New User</h5>
                    <div class="row center">
                        <div class="input-field col s6 m6 l6">
                            <input id="name" type="text" name="new_username" class="validate">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col s6 m6 l6">
                            <input id="email" type="email" name="new_user_email" class="validate">
                            <label for="email">Email</label>
                            <span class="helper-text" data-error="invalid" data-success="valid"></span>
                        </div>
                    </div>
                    <div class="row center">
                        <div class="col s8 m8 l8 offset-s2 offset-m2 offset-l2">
                            <select name="new_farm" class="browser-default">
                                <option value="" disabled selected>Choose farm</option>
                                @foreach ($farms as $farm)
                                    <option value="{{ $farm->id }}">{{ $farm->name }}</option>
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
        </div>
    </div>
@endsection
