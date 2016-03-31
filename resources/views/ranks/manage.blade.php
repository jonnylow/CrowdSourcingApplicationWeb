@extends('layouts.master')

@section('title', 'Manage Ranks')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Manage Ranks</h1>

            <div class="row margin-bottom-sm">
                <div class="col-md-8 col-md-offset-2">
                    @include('errors.list')
                </div>
            </div>

            {!! Form::open(['method' => 'PATCH', 'route' => ['ranks.update']]) !!}

            <div class="row margin-bottom-sm">
                <table id="rank-table" class="table table-striped table-bordered table-hover" data-toggle="table" data-sort-name="rank" data-sort-order="asc" data-unique-id="rank">
                    <thead>
                    <tr>
                        <th class="col-md-2" data-field="rank" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Rank</th>
                        <th class="col-md-4" data-field="name" data-searchable="true" data-halign="center" data-align="center" data-valign="middle">Rank Name</th>
                        <th class="col-md-4" data-field="points_req" data-halign="center" data-align="center" data-valign="middle" data-editable="true">Min. Points Required</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($ranks))
                        @foreach ($ranks as $rank)
                            <tr>
                                <td>{{ $rank->rank }}</td>
                                <td>{{ $rank->name }}</td>
                                <td>
                                    @if ($rank->min == 0)
                                        {{ $rank->min }}
                                    @else
                                        {!! Form::number('rank_' . $rank->rank, $rank->min, ['class' => 'form-control', 'id' => 'rank_' . $rank->rank]) !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="form-group text-center">
                {!! Form::submit('Save ranks', ['class' => 'btn btn-primary btn-lg']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

<script>
    function validateRank3() {
        var rank2 = 65534;

        if($('#rank_2').valid()) {
            rank2 = parseInt($('input[name="rank_2"]').val(), 10);
        }

        $('input[name="rank_3"]').rules('remove');
        $('input[name="rank_3"]').rules('add', {
            required: true,
            digits: true,
            min: 1,
            max: rank2 - 1.0,
            messages: {
                required: "Point for rank 3 is required.",
                digits: "Point for rank 3 must be a number.",
                min: "Point for rank 3 must be more than 0.",
                max: "Point for rank 3 must be less than " + rank2 + "."
            }
        });
        $('input[name="rank_3"]').valid();
    }

    function validateRank2() {
        var rank3 = 1;
        var rank1 = 65535;

        if($('#rank_3').valid()) {
            rank3 = parseInt($('input[name="rank_3"]').val(), 10);
        }

        if($('#rank_1').valid()) {
            rank1 = parseInt($('input[name="rank_1"]').val(), 10);
        }

        $('input[name="rank_2"]').rules('remove');
        $('input[name="rank_2"]').rules('add', {
            required: true,
            digits: true,
            min: rank3 + 1.0,
            max: rank1 - 1.0,
            messages: {
                required: "Point for rank 2 is required.",
                digits: "Point for rank 2 must be a number.",
                min: "Point for rank 2 must be more than  " + rank3 + ".",
                max: "Point for rank 3 must be less than " + rank1 + "."
            }
        });
        $('input[name="rank_2"]').valid();
    }

    function validateRank1() {
        var rank2 = 2;

        if($('#rank_2').valid()) {
            rank2 = parseInt($('input[name="rank_2"]').val(), 10);
        }

        $('input[name="rank_1"]').rules('remove');
        $('input[name="rank_1"]').rules('add', {
            required: true,
            digits: true,
            min: rank2 + 1.0,
            max: 65535,
            messages: {
                required: "Point for rank 1 is required.",
                digits: "Point for rank 1 must be a number.",
                min: "Point for rank 1 must be more than  " + rank2 + ".",
                max: "Point for rank 1 must be less than 65536."
            }
        });
        $('input[name="rank_1"]').valid();
    }


    $(document).on('change', '#rank_3', function () {
        validateRank1();
        validateRank2();
        validateRank3();
    });

    $(document).on('change', '#rank_2', function () {
        validateRank1();
        validateRank2();
        validateRank3();
    });

    $(document).on('change', '#rank_1', function () {
        validateRank1();
        validateRank2();
        validateRank3();
    });
</script>

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
