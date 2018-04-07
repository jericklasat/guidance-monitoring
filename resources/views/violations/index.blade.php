@extends('layouts.app')

@section('on_page_css')
    <link href="{{ asset('css/calendar.min.css') }}" rel="stylesheet">
    <style>
        .form-container {
            margin-top: 5em;
        }
        .grid.container {
            margin-top: 2em;
        }
        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
    </style>
@endsection

@section('content')
    <div class="main ui container" id="main-container">
        <div class="segment form-container">
            <div class="ui one cards">
                <form class="ui form" id="add-violation-form" method="post" style="width: 100%;">
                    <div class="ui card" style="width: 100%;">
                        <div class="content">
                            <h3 class="ui dividing header">Add Violation</h3>
                            <div class="description">
                                <div class="field">
                                    <label for="school-data">Student Information</label>
                                    <div class="three fields" id="school-data">
                                        <div class="field">
                                            <select class="ui search dropdown" name="std_account" id="std-account">
                                                <option value="">Select Student</option>
                                            </select>
                                        </div>
                                        <div class="field" style="text-align: center;padding-top: 15px;">
                                            <strong>Course: </strong><span id="std-course"></span>
                                        </div>
                                        <div class="field" style="text-align: center;padding-top: 15px;">
                                            <strong>Section: </strong><span id="std-section"></span>
                                        </div>
                                    </div>
                                    <label for="school-data">Violation Information</label>
                                    <div class="four fields" id="school-data">
                                        <div class="field">
                                            <select class="ui search dropdown" name="violation_type" id="violation-type">
                                                <option value="">Select Violation</option>
                                                <option value="Absent">Absent</option>
                                                <option value="Tardiness">Tardiness</option>
                                                <option value="Behaviour">Behaviour</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <select class="ui search dropdown" name="subject" id="subject">
                                                <option value="">Select Subject</option>
                                            </select>
                                            <a id="add-subject-trigger" class="ui blue basic pointing label">Not in the list?</a>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="instructor_name" id="instructor-name" placeholder="Instructor Name"/>
                                        </div>
                                        <div class="field">
                                            <div class="ui calendar" id="violation-cal">
                                                <div class="ui input left icon">
                                                    <i class="calendar icon"></i>
                                                    <input type="text" name="violation_occur" id="violation-occur" placeholder="Violation Occur" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="violation-comment">Comment</label>
                                        <textarea id="violation-comment" name="violation_comment"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui two bottom attached buttons">
                            <button type="button" class="ui compact button" id="cancel-request">
                                Cancel
                            </button>
                            <button type="submit" id="submit-request" class="ui primary button">
                                Submit
                            </button>
                        </div>
                        <div class="ui error message" id="error-messages"></div>
                    </div>
                </form>
                <div class="ui tiny modal" id="add-subject-modal">
                    <div class="header">New Subject</div>
                    <div class="content">
                        <div class="ui form">
                            <div class="field">
                                <label>Name of Subject</label>
                                <input type="text" name="new_subject" id="new-subject" placeholder="Subject Name" />
                                <div class="ui pointing red basic label" id="request-error" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="actions">
                        <div class="ui black deny button">Cancel</div>
                        <div class="ui right green approve labeled icon button" id="approve-request">
                            Request
                            <i class="checkmark icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('on_page_js')
    <script src="{{ asset('js/calendar.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var std_subject = $('#subject');
            var std_account = $('#std-account');
            HTTP_MANAGER.executeGet('/retrieve/students', function() {
                std_account.parent().addClass('loading');
            },"retrieve-students").done(function(response) {
                std_account.parent().removeClass('loading');
                if (response.data.status === "Success") {
                    response.data.payload.forEach( function (data) {
                        std_account.append('<option value="' + data.action + '" data-std_course="' + data.course + '" data-std_section=" ' + data.section + ' ">' + data.fullname + '</option>');
                    });
                }
            });

            HTTP_MANAGER.executeGet('/subject/all').done(function(response){
                if (response.data.status === "Success") {
                    response.data.payload.forEach(function (value){
                        std_subject.append("<option value='"+ value.subject_id +"'>" + value.subject_name + "</option>");
                    });
                }
            });

            std_account.on('change', function () {
                var option_value = $(this).find(':selected').data();
                $('#std-course').text(option_value.std_course);
                $('#std-section').text(option_value.std_section);
            });

            $('#add-subject-trigger').on('click', function() {
                var new_subject = $('#new-subject');
                var approve_request = $("#approve-request");
                var not_success = function (message) {
                    new_subject.parent().addClass('error');
                    approve_request.removeClass('loading').removeClass('disabled');
                    $('#request-error').show().text(message);
                };

                var reset_fill = function () {
                    approve_request.removeClass('loading').removeClass('disabled');
                    new_subject.val('').parent().removeClass('error');
                    $('#request-error').hide()
                }

                $('#add-subject-modal').modal({
                    onHide: function(){
                        reset_fill();
                    },
                    onApprove: function() {
                        approve_request.addClass('disabled').addClass('loading');
                        if (new_subject.val() !== "" && new_subject.val() !== undefined) {
                            new_subject.parent().removeClass('error');
                            $('#request-error').hide();
                            HTTP_MANAGER.executePost('/subject/check',{subject:new_subject.val()}).done(function(response) {
                                if (response.data.payload == undefined) {
                                    new_subject.parent().removeClass('error');
                                    $('#request-error').hide();
                                    HTTP_MANAGER.executePost('/subject/add',{subject:new_subject.val().toUpperCase()}).done(function(resp) {
                                        if (resp.data.status === "Success") {
                                            std_subject.append("<option value='"+ resp.data.payload.last_id +"'>" + new_subject.val().toUpperCase() + "</option>");
                                            $('#add-subject-modal').modal('hide');
                                        }
                                    });
                                } else {
                                    not_success('Subject already exist.');
                                }
                            });
                        } else {
                            not_success('Input must not be empty.');
                        }
                        return false;
                    }
                }).modal('show');
            });

            $('#cancel-request').on('click', function(){
                window.location.replace($('meta[name=base-url]').attr("content"));
            });

            /*
             * Semantic UI Initialize.
             *
             * */
            $('.ui.dropdown').dropdown();

            $('#violation-cal').calendar({
                type: 'datetime',
                formatter: {
                    date: function (date, settings) {
                        if (!date) return '';
                        var day = date.getDate() + '';
                        if (day.length < 2) {
                            day = '0' + day;
                        }
                        var month = (date.getMonth() + 1) + '';
                        if (month.length < 2) {
                            month = '0' + month;
                        }
                        var year = date.getFullYear();
                        return year + '-' + month + '-' + day;
                    }
                }
            });

            $('#add-violation-form').form({
                fields: {
                    std_account: {
                        identifier: 'std_account',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please select student account.'
                            }
                        ]
                    },
                    violation_type: {
                        identifier: 'violation_type',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please select violation.'
                            }
                        ]
                    },
                    subject: {
                        identifier: 'subject',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please select violation.'
                            }
                        ]
                    },
                    instructor_name: {
                        identifier: 'instructor_name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please provide instructor name.'
                            }
                        ]
                    },
                    violation_occur: {
                        identifier: 'violation_occur',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Please specified data and time.'
                            }
                        ]
                    }
                },
                onSuccess : function(e){
                    e.preventDefault();
                    HTTP_MANAGER.executePost("/violation/add",{
                        data: {
                            std_account: $("#std-account").find(':selected').val(),
                            violation_type: $('#violation-type').val(),
                            section: $("#std-account").find(':selected').data().std_section,
                            subject: $('#subject').val(),
                            instructor_name: $('#instructor-name').val(),
                            violation_occur: $('#violation-occur').val(),
                            violation_comment: $('#violation-comment').val()
                        }
                    }, function () {
                        $('#submit-request').addClass('disabled').addClass('loading');
                    }).done(function(response){
                        $('#submit-request').removeClass('loading').removeClass('disabled');
                        window.location.replace('{{ route('index') }}');
                    });
                }
            });
        });
    </script>
@endsection