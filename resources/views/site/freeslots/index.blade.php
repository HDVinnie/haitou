@extends('layouts.dashboard')

@section('subtitle', 'Requests')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/c3/c3.css') }}">
@endsection

@section('content')

    <div class="col-md">

        <div class="card text-center mb-3">
            <div class="card-header">
                Site Points
            </div>
            <div class="card-body">
                @if($points->is_enabled)
                    <h4 class="card-title">Uma vez que o Site Points tiverem
                        <b class="text-danger">{{ number_format($points->required, 2) }}</b> pontos, o
                        <b class="text-danger">{{ $points->type() }}</b> estará liberado para todos por
                        <b class="text-danger">{{ $points->days }}</b> dias.</h4>

                    <p class="card-text">Pontos: {{ number_format($points->actual, 2) }} / {{ number_format($points->required, 2) }}</p>

                    <div class="demo-vertical-spacing-lg">
                        <div id="c3-gauge" style="height: 300px"></div>
                    </div>

                    <hr class="border-light container-m--x my-0">
                    @includeIf('errors.errors', [$errors])
                    @include('includes.messages')
                    {!! Form::open(['url' => 'requests', 'class' => 'mt-4 container col-md-5 col-md-offset-4']) !!}
                    <div class="form-group row ml-5">
                        {!! Form::label('point', 'Quantia:', ['class' => 'col-form-label col-sm-2 text-sm-right']) !!}
                        <div class="col-sm-4">
                            {!! Form::number('point', null, ['class' => 'form-control', 'placeholder' => 'Pontos', 'min' => 1, 'max' => 1000, 'required']) !!}
                        </div>
                        <div class="col-sm-1">
                            {!! Form::submit('Doar', ['class' => 'btn btn-primary btn-rounded btn-outline']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                @else
                    <div class="block-header">
                        <h3 class="block-title text-center mt-5 mb-5">Fechado!</h3>
                    </div>
                @endif
            </div>
            <div class="card-footer text-muted">
                Site Points
            </div>
        </div>

    </div>

@endsection


@section('script')
    <script src="{{ asset('vendor/d3/d3.js') }}"></script>
    <script src="{{ asset('vendor/c3/c3.js') }}"></script>
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce() }}">
        $(document).ready(function() {
            $(function() {
                c3.generate({
                    bindto: '#c3-gauge',
                    data: {
                        columns: [
                            ['porcentagem', {{ $percent }}]
                        ],
                        type: 'gauge'
                    },
                    gauge: {
                        label: {
                            format: function(value, ratio) {
                                return value;
                            },
                            show: true // to turn off the min/max labels.
                        },
                        min: 0,
                        max: 100,
                        // units: '%',
                        width: 50 // for adjusting arc thickness
                    },
                    color: {
                        pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'],
                        threshold: {
                            values: [30, 60, 90, 100]
                        }
                    },
                    size: {
                        height: 300
                    }
                });
            });
        });
    </script>
@endsection

