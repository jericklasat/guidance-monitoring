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
        .for-drop td{
            background-color: #db2828;
            color: #fff;
        }
        .for-warning td {
            background-color: #db7b28;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="main ui container" id="main-container">
        <div class="segment form-container">
            @if($id_number)
                <div class="ui three column stackable grid" id="single-information">
                    <div class="column" id="single-std-info-col">
                        <div class="left ui rail" style="left: 0;">
                            <div class="ui sticky">
                                <div class="ui fluid card">
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
                            <div class="ui inverted dimmer">
                                <div class="content">
                                    <div class="ui text loader">Sending Email Notice...</div>
                                </div>
                            </div>
                            <table id="violations-summary" class="ui selectable celled table">
                                <thead>
                                    <th>Violation</th>
                                    <th>Count</th>
                                    <th>Yr/Semester</th>
                                    <th>Subject</th>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <th>Violation</th>
                                    <th>Count</th>
                                    <th>Yr/Semester</th>
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
                                    <th>Yr/Semester</th>
                                    <th>Subject</th>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <th>Date Time</th>
                                    <th>Violation</th>
                                    <th>Yr/Semester</th>
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

@if($id_number)
    @section('on_page_js')
        <script type="text/javascript" src="{{ asset('lib/DataTables/datatables.min.js') }}"> </script>
        <script type="text/javascript" src="{{ asset('lib/DataTables/DataTables-1.10.16/js/dataTables.semanticui.min.js') }}"> </script>
        <script type="text/javascript">
            $(document).ready(function() {
                var email_record_data = [];
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
                                payload.gender,
                                (payload.guardian_contact_number == 0) ? "not available" : payload.guardian_contact_number,
                                payload.birth_date,
                                payload.guardian_email
                            ];
                            dynamic_append(elements, data);
                        } else {
                            $('#single-information').hide();
                            $('.form-container').html('<h2>No data available.</h2>');
                        }
                    }
                });

                var violations_summary_tbl = $('#violations-summary').DataTable({
                    deferRender: true,
                    searching: true,
                    scrollCollapse: true,
                    scrollY: 200,
                    scroller: {
                        loadingIndicator: true
                    },
                    createdRow: function(row, data) {
                        if (data[0] === "Absent" && data[1] === 1) {
                            $(row).addClass('for-warning');
                        }

                        if (data[0] === "Absent" && data[1] === 2) {
                            $(row).addClass('for-drop');
                        }

                        if (data[0] === "Tardiness" && data[1] === 2) {
                            $(row).addClass('for-warning');
                        }

                        if (data[0] === "Tardiness" && data[1] === 3) {
                            $(row).addClass('for-drop');
                        }
                    }
                });
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

                HTTP_MANAGER.executePost("/violation/student-id",{student_id: '{{ $id_number }}'}).done(function(violations_response){
                    if (violations_response.data.status !== 'Success') {
                        return true;
                    }
                    var summary_violations_data = {data: {}};
                    var violations_hitory_data = [];
                    violations_response.data.payload.forEach(function(value, index) {
                        var yr_sem = value.section.split('-');
                        violations_hitory_data.push([
                            value.violation_occur,
                            value.violation_type,
                            yr_sem[0],
                            value.subject_name
                        ]);
                        var counter = 1;
                        var ret_sec = value.section.split('-');
                        var index_marker = value.violation_type + '_' + value.subject_id + '_' + ret_sec[0];
                        if (summary_violations_data.data[index_marker]) {
                            summary_violations_data.data[index_marker].count = (summary_violations_data.data[index_marker].count + 1);
                        } else {
                            summary_violations_data.data[index_marker] = {
                                violation: value.violation_type,
                                count: counter,
                                yr_sect: ret_sec[0],
                                subject_name: value.subject_name
                            };
                        }
                        counter++;
                    });
                    var summary_data = [];
                    Object.values(summary_violations_data.data).forEach(function(value, index){
                        summary_data.push(Object.values(value));
                    });
                    violations_summary_tbl.rows.add(summary_data).draw();
                    violations_table.rows.add(violations_hitory_data).draw();

                    // Warning email popup
                    $('.for-warning').popup({
                        on: 'hover',
                        hoverable  : true,
                        onCreate: function(element) {
                            email_record_data = [];
                            $(element).find('td').each(function(td_index, td_el) {
                                email_record_data.push($(td_el).text());
                            });
                        },
                        title: 'Remind the Parent',
                        html: '<button class="ui right labeled icon button send-warning-email"><i class="envelope icon"></i> Send Warning Notice</button>'
                    });

                    // Drop email popup
                    $('.for-drop').popup({
                        on: 'hover',
                        hoverable  : true,
                        onCreate: function(element) {
                            email_record_data = [];
                            $(element).find('td').each(function(td_index, td_el) {
                                email_record_data.push($(td_el).text());
                            });
                        },
                        title: 'Remind the Parent',
                        html: '<button class="ui right labeled icon button send-drop-email"><i class="envelope icon"></i> Send Drop Notice</button>'
                    });
                });

                $('.ui.sticky').sticky({
                    context: '#single-std-info-col'
                });

                $('body').on('click', '.send-warning-email', function() {
                    $('.ui.dimmer').dimmer('show');
                    HTTP_MANAGER.executePost('/email/send-notice', {
                        violation: email_record_data[0],
                        count: email_record_data[1],
                        yr_sem: email_record_data[2],
                        subject: email_record_data[3],
                        email: $('#email').text(),
                        guardian_name: $('#guardian-name').text(),
                        gender: $('#gender').text(),
                        std_fullname: $('#fullname').text(),
                        type: 'warning'
                    }).done(function() {
                        setTimeout(function(){
                            $('.ui.dimmer').dimmer('hide');
                        }, 2000);
                    });
                });

                $('body').on('click', '.send-drop-email', function() {
                    $('.ui.dimmer').dimmer('show');
                    HTTP_MANAGER.executePost('/email/send-notice', {
                        violation: email_record_data[0],
                        count: email_record_data[1],
                        yr_sem: email_record_data[2],
                        subject: email_record_data[3],
                        email: $('#email').text(),
                        guardian_name: $('#guardian-name').text(),
                        gender: $('#gender').text(),
                        std_fullname: $('#fullname').text(),
                        type: 'drop'
                    }).done(function() {
                        setTimeout(function(){
                            $('.ui.dimmer').dimmer('hide');
                        }, 2000);
                    });
                });
            });
        </script>
    @endsection
@endif
