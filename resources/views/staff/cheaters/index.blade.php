@extends('layouts.dashboard')

@section('title', trans('dashboard.cheaters'))

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Staff Painel</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('staff') }}">@lang('dashboard.title')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('dashboard.cheaters')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">@lang('dashboard.cheaters')</h4>
                        <p>Possíveis Cheaters (Fantasmas)</p>
                        <div class="table-responsive m-t-15">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Grupo</th>
                                    <th>Registro</th>
                                    <th>Ultimo login</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cheaters as $cheater)
                                    <tr>
                                        <td>{{ link_to_route('user.profile', $cheater->user->username, ['slug' => $cheater->user->slug]) }}</td>
                                        <td>{{ $cheater->user->group->name }}</td>
                                        <td>{{ $cheater->user->created_at->toDayDateTimeString() }}</td>
                                        @if($cheater->user->logins->created_at != null)
                                            <td>{{ $cheater->user->logins->created_at->toDayDateTimeString() }}</td>
                                        @else
                                            <td>N/A</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $cheaters->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Programas</h4>
                        <p>Programas nao autorizados</p>
                        <div class="table-responsive m-t-15">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Grupo</th>
                                    <th>Porta</th>
                                    <th>IP</th>
                                    <th>Programa</th>
                                    <th>Registro</th>
                                    <th>Ultimo login</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($programs as $program)
                                    <tr>
                                        <td>{{ link_to_route('user.profile', $program->user->name, ['slug' => $program->user->slug]) }}</td>
                                        <td>{{ $program->user->role->name }}</td>
                                        <td>{{ $program->port }}</td>
                                        <td>{{ $program->ip }}</td>
                                        <td>{{ $program->program }}</td>
                                        <td>{{ $program->user->created_at->toDayDateTimeString() }}</td>
                                        @if(isset($program->user->logins->created_at))
                                            <td>{{ $program->user->logins->created_at->toDayDateTimeString() }}</td>
                                        @else
                                            <td>N/A</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $programs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
