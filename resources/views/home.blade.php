@extends('layouts.app')
@section('on_page_css')
    <link rel="stylesheet" href="{{ asset('lib/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/DataTables/DataTables-1.10.16/css/dataTables.semanticui.min.css') }}">
    <style>
        #main-container {
            margin-left: 5em !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #000 !important;
            border: none;
        }
        .violation-separator {
            margin: 35px 0!important;
        }
        .std-data-separator {
            margin: 55px 0!important;
        }
        .footer-search input{
            width: 50%;
        }
        #violation-history_filter, #students-data_filter {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="main ui container" id="main-container">
        <div class="divider"></div>
        <div class="ui horizontal divider violation-separator">
            Violations History
        </div>
        <div class="ui segment " id="violation-hst-cont">
            <div class="right ui rail">
                <div class="ui sticky">
                    <div class="ui vertical menu">
                        <a class="active teal item">
                            Violations Number
                            <div class="ui teal left pointing label" id="violations-tag">0</div>
                        </a>
                        <a class="item">
                            Total Absences
                            <div class="ui red label" id="absences-tag">0</div>
                        </a>
                        <a class="item">
                            Total Lates
                            <div class="ui red label" id="late-tag">0</div>
                        </a>
                        <a class="item">
                            Total Misbehaviour
                            <div class="ui red label" id="misbehaviour-tag">0</div>
                        </a>
                    </div>
                </div>
            </div>
            <table class="ui selectable celled table" id="violation-history">
                <thead>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Violation</th>
                    <th>Subject</th>
                    <th>View</th>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Violation</th>
                    <th>Subject</th>
                    <th>View</th>
                </tfoot>
            </table>
        </div>

        <div class="ui horizontal divider std-data-separator">
            Student's Data
        </div>
        <div class="ui segment" id="std-data-cont">
            <table class="ui selectable celled table" id="students-data">
                <thead>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Section</th>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Section</th>
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
            $('#violation-history tfoot th, #students-data tfoot th').each( function () {
                var title = $(this).text();
                if (title !== "Action") {
                    $(this).html( '<div class="ui input footer-search"><input type="text" placeholder="Search '+title+'" /></div>' );
                }
            } );

            var violation_table = $('#violation-history').DataTable({
                deferRender: true,
                ajax: function ( data,callback) {
                    var build = [];
                    HTTP_MANAGER.executeGet('/violation/history').done(function(response) {
                        if (response.data.status === "Success") {
                            response.data.payload.forEach(function (value) {
                                var aa = Object.keys(value).map(function(e, i) {
                                    if (i === (Object.keys(value).length - 1)) {
                                        return '<a href="{{ route('view_violation') }}/'+ value[e] +'">View</a>';
                                    }
                                    return value[e];
                                });
                                build.push(aa);
                            });
                        }
                        setTimeout( function () {
                            callback( {
                                draw: data.draw,
                                data: build
                            } );
                        },500);
                    });
                }
            });

            var student_table = $('#students-data').DataTable({
                deferRender: true,
                ajax: function ( data,callback) {
                    var build = [];
                    HTTP_MANAGER.executeGet('/retrieve/students').done(function(response){
                        if (response.data.status === "Success") {
                            response.data.payload.forEach(function (value) {
                                var aa = Object.keys(value).map(function(e) {
                                    return value[e];
                                });
                                build.push(aa);
                            });
                        }
                        setTimeout( function () {
                            callback( {
                                draw: data.draw,
                                data: build
                            } );
                        },500);
                    });
                }
            });

            violation_table.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            student_table.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            HTTP_MANAGER.executeGet('/violation/total').done(function(response){
                if (response.data.status === "Success") {
                    $('#absences-tag').html(response.data.payload.Absent);
                    $('#misbehaviour-tag').html(response.data.payload.Behaviour);
                    $('#late-tag').html(response.data.payload.Tardiness);
                    $('#violations-tag').html( ( parseInt(response.data.payload.Absent) + parseInt(response.data.payload.Behaviour) + parseInt(response.data.payload.Tardiness) ) );
                }
            });

            /*
             * Semantic UI Initialize.
             *
             * */
            $('.ui.sticky').sticky({
                context: '#main-container'
            });
        });
    </script>
@endsection
