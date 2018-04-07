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
    </style>
@endsection

@section('content')
    <div class="main ui container" id="main-container">
        <div class="segment form-container">
            @if($id_number)
                <div class="ui three column stackable grid" id="single-information">
                    <div class="column">
                        <div class="ui fluid card">
                            <div class="image">
                                <img src="https://semantic-ui.com/images/avatar2/large/matthew.png">
                            </div>
                            <div class="content">
                                <span class="header" id="fullname"></span>
                                <div class="meta">
                                    <span class="date" id="email"></span>
                                </div>
                                <div class="meta">
                                    <span class="date" id="mobile-number"></span>
                                </div>
                            </div>
                            <div class="extra content">
                                <div>
                                    <strong>ID Number: </strong> <span id="id-number"></span>
                                </div>
                                <div>
                                    <strong>Course: </strong> <span id="course"></span>
                                </div>
                                <div>
                                    <strong>Section: </strong> <span id="section"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="two column" style="width: 66.66%;">
                        <h3 class="ui dividing header">Full Information</h3>
                        <div class="ui two column row grid">
                            <div class="column">
                                <strong>Guardian Name: </strong> <span id="guardian-name"></span>
                            </div>
                            <div class="column">
                                <strong>Personal Address: </strong> <span id="personal-address"></span>
                            </div>

                        </div>
                        <div class="ui two column row grid">
                            <div class="column">
                                <strong>Guardian Address: </strong> <span id="guardian-address"></span>
                            </div>
                            <div class="column">
                                <strong>Gender: </strong> <span id="gender"></span>
                            </div>
                        </div>
                        <div class="ui two column row grid">
                            <div class="column">
                                <strong>Guardian Contact: </strong> <span id="guardian-contact"></span>
                            </div>
                            <div class="column">
                                <strong>Birth Date: </strong> <span id="birth-date"></span>
                            </div>
                        </div>
                        <div class="ui two column row grid">
                            <div class="column">
                                <strong>Guardian Email: </strong> <span id="guardian-email"></span>
                            </div>
                        </div>
                        <h4 class="ui dividing header" style="margin-top:50px;">Violations Summary</h4>
                        <div class="ui column row">
                            <table id="violations-summary" class="ui selectable celled table">
                                <thead>
                                    <th>Violation</th>
                                    <th>Count</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Absent</td>
                                        <td>1</td>
                                        <td>2nd</td>
                                        <td>TLE</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <th>Violation</th>
                                    <th>Count</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                </tfoot>
                            </table>
                        </div>
                        <h4 class="ui dividing header" style="margin-top:50px;">Violations History</h4>
                        <div class="ui column row">
                            <table id="violations-record" class="ui selectable celled table">
                                <thead>
                                    <th>Date Time</th>
                                    <th>Violation</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <th>Date Time</th>
                                    <th>Violation</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <h2>No data available.</h2>
            @endif
        </div>
    </div>
@endsection

@section('on_page_js')
    <script type="text/javascript" src="{{ asset('lib/DataTables/datatables.min.js') }}"> </script>
    <script type="text/javascript" src="{{ asset('lib/DataTables/DataTables-1.10.16/js/dataTables.semanticui.min.js') }}"> </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#violations-record tfoot th, #violations-summary tfoot th').each( function () {
                var title = $(this).text();
                if (title !== "Action") {
                    $(this).html( '<div class="ui input"><input type="text" placeholder="Search '+title+'" /></div>' );
                }
            } );
            HTTP_MANAGER.executePost("/students/single",{data_id: "{{ $id_number }}" }).done(function(response){
                var dynamic_append = function (elements, values) {
                    elements.forEach(function(element, i){
                        $('#'+element).html(values[i]);
                    });
                };
                if (response.data.status === "Success") {
                    if (response.data.payload != null) {
                        var elements = ["fullname","email","mobile-number","id-number","section","course","guardian-name","personal-address","guardian-address","gender","guardian-contact","birth-date","guardian-email"];
                        var payload = response.data.payload;
                        var middlename = (payload.middlename !== "N/A") ? payload.middlename : " ";
                        var data = [
                            payload.lastname + ", " + payload.firstname + " " + middlename,
                            payload.contact_email,
                            (payload.mobile_number == 0) ? "not available" : payload.mobile_number,
                            payload.student_id_number,
                            payload.current_section,
                            payload.course_name,
                            payload.guardian_name,
                            payload.address,
                            payload.guardian_address,
                            payload.birth_date,
                            payload.gender,
                            (payload.guardian_contact_number == 0) ? "not available" : payload.guardian_contact_number,
                            payload.guardian_email
                        ];
                        dynamic_append(elements, data);
                    } else {
                        $('#single-information').hide();
                        $('.form-container').html('<h2>No data available.</h2>');
                    }
                }
            });

            var violations_summary_tbl = $('#violations-summary').DataTable();
            var violations_table = $('#violations-record').DataTable();

            violations_summary_tbl.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            violations_table.columns().every( function () {
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
