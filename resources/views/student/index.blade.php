@extends('layouts.app')

@section('on_page_css')
    <link rel="stylesheet" href="{{ asset('lib/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/DataTables/DataTables-1.10.16/css/dataTables.semanticui.min.css') }}">
    <style>
        .form-container {
            margin-top: 5em;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #000 !important;
            border: none;
        }
        #students-record_filter {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="main ui container" id="main-container">
        <div class="segment form-container">
            <table id="students-record" class="ui selectable celled table">
                <thead>
                    <th>ID Number</th>
                    <th>Full Name</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Action</th>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <th>ID Number</th>
                    <th>Full Name</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Action</th>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('on_page_js')
    <script type="text/javascript" src="{{ asset('lib/DataTables/datatables.min.js') }}"> </script>
    <script type="text/javascript" src="{{ asset('lib/DataTables/DataTables-1.10.16/js/dataTables.semanticui.min.js') }}"> </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#students-record tfoot th').each( function () {
                var title = $(this).text();
                if (title !== "Action") {
                    $(this).html( '<div class="ui input"><input type="text" placeholder="Search '+title+'" /></div>' );
                }
            } );

            var table_data = $('#students-record').DataTable({
                deferRender: true,
                ajax: function ( data,callback,settings ) {
                    var build = [];
                    HTTP_MANAGER.executeGet('/retrieve/students').done(function(response) {
                        if (response.data.status === "Success") {
                            response.data.payload.forEach(function (value) {
                                var aa = Object.keys(value).map(function(e) {
                                    return value[e];
                                })
                                build.push(aa);
                            });
                        }
                    });
                    setTimeout( function () {
                        callback( {
                            draw: data.draw,
                            data: build
                        } );
                    },500);
                },
                columns: [
                    { data: "student_id_number",
                        render: function (nTd, sData, oData) {
                            return "<strong>SN: </strong>" + oData[0];
                        }
                    },
                    { data: "fullname",
                        render: function (nTd, sData, oData) {
                            return oData[1];
                        }
                    },
                    { data: "course",
                        render: function (nTd, sData, oData) {
                            return oData[2];
                        }
                    },
                    { data: "section",
                        render: function (nTd, sData, oData) {
                            return oData[3];
                        }
                    },
                    { data: "action",
                        render: function (nTd, sData, oData) {
                            return '<div class="ui small buttons">' +
                                '<a href="{{ route('student_update') }}/'+oData[4]+'" class="ui button" id="data-update-trigger' + oData[4] + '" data-std_data_id="' + oData[4] + '"><i class="icon edit"></i></a>' +
                                '<div class="or"></div>' +
                                '<a href="{{ route('student_single') }}/'+oData[4]+'" class="ui button green" ><i class="icon info"></i></a>' +
                                '</div>';
                        }
                    },
                ]
            });

            table_data.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        });
    </script>
@endsection