@extends('layouts.master')

@section('title', 'Manage Ranks')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Manage Ranks</h1>

            <div class="margin-bottom-xs" id="toolbar">
                <a class="btn btn-default" onclick="insertRow()">Insert new row</a>
            </div>

            <table id="rank-table" class="table table-striped table-bordered table-hover" data-toggle="table" data-pagination="true" data-sort-name="rank" data-sort-order="asc" data-unique-id="rank">
                <thead>
                <tr>
                    <th class="col-md-3" data-field="rank" data-sortable="true" data-halign="center" data-align="center" data-valign="middle">Rank</th>
                    <th class="col-md-4" data-field="name" data-searchable="true" data-halign="center" data-align="center" data-valign="middle" data-editable="true">Rank Name</th>
                    <th class="col-md-3" data-field="points_req" data-halign="center" data-align="center" data-valign="middle" data-editable="true">Min. Points Required</th>
                    <th class="col-md-2" data-field="removeButton" data-align="center" data-valign="middle"></th>
                </tr>
                </thead>
                <tbody>
                @if (count($ranks))
                    @for ($i=0; $i<count($ranks); $i++)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $ranks[$i]->name }}</td>
                            <td>{{ $ranks[$i]->min }}</td>
                            <td>
                                <a class="btn btn-danger btn-xs" onclick="removeRow({{ $ranks[$i]->rank }})">
                                    <span class="glyphicon glyphicon-remove"></span> Delete row
                                </a>
                            </td>
                        </tr>
                    @endfor
                @endif
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="remove-row-modal" tabindex="-1" role="dialog" aria-labelledby="removeRowLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="removeRowLabel">Recovery password</h4>
            </div>
            {!! Form::open(['url' => asset('password/email')]) !!}
            <div class="modal-body">
                <p>Enter your email address</p>
                {!! Form::email('recovery_email', null, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Email']) !!}
            </div>
            <div class="modal-footer">
                {!! Form::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                {!! Form::button('Send Password Reset Link', ['class' => 'btn btn-primary', 'onclick' => 'javascript:alert("Work in Progress")']) !!}
            </div>
            {!! Form::close() !!}
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
@endsection

@section('page-script')

<link rel="stylesheet" href="//rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/css/bootstrap-editable.css">
<script src="{{ asset('js/bootstrap-table-editable.min.js') }}"></script>
<script src="//rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script>
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.ajaxOptions = {type: "put"};

    var $table = $('#rank-table');

//    //make username required
//    $('#new_username').editable('option', 'validate', function(v) {
//        if(!v) return 'Required field!';
//    });
//
//    //make username required
//    $('#new_username').editable('option', 'validate', function(v) {
//        if(!v) return 'Required field!';
//    });
//
//    function saveRefresh() {
//
//    }

    $(function () {
        $("[data-submit-confirm-text]").click(function(e){
            var $el = $(this);
            e.preventDefault();
            var confirmText = $el.attr('data-submit-confirm-text');
            bootbox.confirm(confirmText, function(result) {
                if (result) {
                    $el.closest('form').submit();
                }
            });
        });
    });

    function removeRow(id) {
        $table.bootstrapTable('removeByUniqueId', id);
    };

    function insertRow() {
        var newRow = $table.bootstrapTable('getOptions').totalRows + 1;

        $table.bootstrapTable('insertRow', {
            index: 1,
            row: {
                rank: newRow,
                name: 'Default',
                points_req: '0',
                removeButton: '<a class="btn btn-danger btn-xs" onclick="removeRow(' + newRow + ')"><span class="glyphicon glyphicon-remove"></span> Delete row</a>'
            }
        });
    }
</script>

@endsection
