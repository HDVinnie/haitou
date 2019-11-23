@extends('layouts.dashboard')

@section('subtitle', 'Editar Torrent')

@section('css')
    <!-- sceditor -->
    <link rel="stylesheet" href="{{ asset('vendor/sceditor/minified/themes/default.min.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.css') }}">
@endsection

@section('content')

    <div class="font-weight-bold py-3 h4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('staff') }}">@lang('dashboard.title')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('staff/torrents') }}">@lang('dashboard.torrents')</a>
            </li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </div>

    <hr class="container-m-nx border-light mt-0 mb-5">

    <div class="card mb-4">
        <h6 class="card-header">Editar - Torrent</h6>
        <div class="card-body">

            @includeIf('errors.errors', [$errors])
            {!! Form::model($torrent, ['url' => 'staff/torrents/' . $torrent->id, 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                <div class="form-material">
                    {!! Form::label('name', 'Nome:') !!}
                    {!! Form::text('name', $torrent->name, ['class' => 'form-control', 'maxlength' => 250, 'required']) !!}
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-4">
                    <div class="form-material floating">
                        {!! Form::label('category_id', 'Categoria:') !!}
                        {!! Form::select('category_id', $categories, $torrent->category_id, ['class' => 'form-control select2']) !!}
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <div class="form-material floating">
                        {!! Form::label('media_id', 'Mídia:') !!}
                        {!! Form::select('media_id', $medias, $torrent->media_id, ['class' => 'form-control select2']) !!}
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <div class="form-material floating">
                        {!! Form::label('fansub_id', 'Fansub:') !!}
                        {!! Form::select('fansub_id', $fansubs, $torrent->fansub_id, ['class' => 'form-control select2']) !!}
                    </div>
                </div>
            </div>

            <br>
            <div class="form-row">
                <div class="form-group col-sm-3">
                    <div class="form-material">
                        {!! Form::label('allow_comments', 'Habilita comentário:') !!}
                        {!! Form::select('allow_comments', [false => 'Não', true => 'Sim'], null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <div class="form-material">
                        {!! Form::label('is_freeleech', 'Free Leech:') !!}
                        {!! Form::select('is_freeleech', [false => 'Não', true => 'Sim'], null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <div class="form-material">
                        {!! Form::label('is_silver', 'Silver:') !!}
                        {!! Form::select('is_silver', [false => 'Não', true => 'Sim'], null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <div class="form-material">
                        {!! Form::label('is_doubleup', 'Double UP:') !!}
                        {!! Form::select('is_doubleup', [false => 'Não', true => 'Sim'], null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
            </div>

            <br>
            <div class="form-group">
                <div class="form-material">
                    {!! Form::label('description', 'Descrição: *') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control note', 'rows' => 8]) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-9">
                    {!! Form::submit('Editar', ['class' => 'btn btn-success btn-rounded btn-outline-success']) !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('vendor/select2/select2.js') }}"></script>
    <!-- sceditor -->
    <script src="{{ asset('vendor/sceditor/minified/sceditor.min.js') }}"></script>
    <script src="{{ asset('vendor/sceditor/minified/formats/bbcode.js') }}"></script>
    <script src="{{ asset('vendor/sceditor/languages/pt-BR.js') }}"></script>

    <!-- Page JS Code -->
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce() }}">
        $(document).ready(function () {
            $(".select2").select2();

            var textarea = document.getElementById('description');
            sceditor.create(textarea, {
                format: 'bbcode',
                locale: 'pt-BR',
                emoticonsRoot: '/vendor/sceditor/',
                style: '/vendor/sceditor/minified/themes/content/default.min.css'
            });
        });
    </script>
@endsection
