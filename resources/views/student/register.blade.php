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
        .ui.small.image {
            height: 150px;
        }
    </style>
@endsection
@section('content')
    <div class="main ui container" id="main-container">
        <div class="segment form-container">
            <div class="ui one cards">
                <form class="ui form" id="registration-form" method="post" style="width: 100%;">
                    <div class="ui card" style="width: 100%;">
                        <div class="content">
                            {{--<div class="header">--}}
                                {{--<img id="profile-picture" src="https://semantic-ui.com/examples/assets/images/wireframe/square-image.png" class="ui small centered fluid image" style="display: block;">--}}
                                {{--<div class="ui middle aligned center aligned grid container">--}}
                                        {{--<input type="file" (change)="fileEvent($event)" class="inputfile" id="embedpollfileinput" accept="image/x-png,image/gif,image/jpeg" />--}}
                                        {{--<label for="embedpollfileinput" class="ui small primary button">--}}
                                            {{--<i class="ui upload icon"></i>--}}
                                            {{--Upload image--}}
                                        {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <h3 class="ui dividing header">Student Information</h3>
                            <div class="description">
                                <div class="field">
                                    <label for="school-data">School Data</label>
                                    <div class="three fields" id="school-data">
                                        <div class="field">
                                            <input type="text" name="std_id_num" id="std-id-num" placeholder="Student ID Number" />
                                        </div>
                                        <div class="field">
                                            <select class="ui search dropdown" name="std_course" id="std-course">
                                                <option value="">Course</option>
                                            </select>
                                            <a href="#" id="add-course-trigger" class="ui blue basic pointing label">Not in the list?</a>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="std_section" id="std-section" placeholder="Current Section" />
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="name">Name</label>
                                    <div class="four fields" id="name">
                                        <div class="field">
                                            <input type="text" name="first_name" id="first-name" placeholder="First name" autofocus/>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="middle_name" id="middle-name" placeholder="Middle name" />
                                            <span class="ui label blue pointing basic">If no middle name please type <strong>N/A</strong></span>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="last_name" id="last-name" placeholder="Last name" />
                                        </div>
                                        <div class="field">
                                            <select class="ui search dropdown" name="gender" id="gender">
                                                <option value="">Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="personal-data">Personal Data</label>
                                    <div class="four fields" id="personal-data">
                                        <div class="field">
                                            <div class="ui calendar" id="birth-date-cal">
                                                <div class="ui input left icon">
                                                    <i class="calendar icon"></i>
                                                    <input type="text" name="birth_date" id="birth-date" placeholder="Birth Date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <input type="text" name="personal_address" id="personal-address" placeholder="Address" />
                                        </div>
                                        <div class="field">
                                            <input type="text" name="mobile_number" id="mobile-number" placeholder="Mobile Number" />
                                        </div>
                                        <div class="field">
                                            <input type="text" name="contact_email" id="contact-email" placeholder="Email Address" />
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label for="guardian-data">Guardian's Data</label>
                                    <div class="four fields" id="guardian-data">
                                        <div class="field">
                                            <input type="text" name="guardian_name" id="guardian-name" placeholder="Full Name" />
                                        </div>
                                        <div class="field">
                                            <input type="text" name="guardian_address" id="guardian-address" placeholder="Address" />
                                        </div>
                                        <div class="field">
                                            <input type="text" name="guardian_number" id="guardian-number" placeholder="Mobile Number" />
                                        </div>
                                        <div class="field">
                                            <input type="text" name="guardian_email" id="guardian-email" placeholder="Email Address" />
                                        </div>
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
            </div>
        </div>
        <div class="ui tiny modal" id="add-course-modal">
            <div class="header">New Course</div>
            <div class="content">
                <div class="ui form">
                    <div class="field">
                        <label>Name of Course</label>
                        <input type="text" name="new_course" id="new-course" placeholder="Course Name" />
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
@endsection
@section('on_page_js')
    <script src="{{ asset('js/calendar.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            /*
             * Basic initialization.
             *
             * */
            $('#cancel-request').on('click', function () {
                window.location.replace($('meta[name=base-url]').attr("content"));
            });

            /*
             * Drop down functionality
             *
             * */
            var std_course = $('#std-course');
            var approve_request = $("#approve-request");
            var new_course = $('#new-course');
            HTTP_MANAGER.executeGet('/courses/all').done(function(response){
                if (response.data.status === "Success") {
                    response.data.payload.forEach(function(data) {
                        std_course.append("<option value='"+ data.course_id +"'>" + data.course_name + "</option>");
                    });
                }
            });
            $('#add-course-trigger').on('click', function (e) {
                e.preventDefault();
                var not_success = function (message) {
                    new_course.parent().addClass('error');
                    approve_request.removeClass('loading').removeClass('disabled');
                    $('#request-error').show().text(message);
                };
                var reset_fill = function () {
                    approve_request.removeClass('loading').removeClass('disabled');
                    new_course.val('').parent().removeClass('error');
                    $('#request-error').hide()
                }
                $('#add-course-modal').modal({
                    onHide: function(){
                        reset_fill();
                    },
                    onApprove: function() {
                        approve_request.addClass('disabled').addClass('loading');
                        if (new_course.val() !== "" && new_course.val() !== undefined) {
                            new_course.parent().removeClass('error');
                            HTTP_MANAGER.executePost('/courses/search',{course:new_course.val()}).done(function(response) {
                                if (response.data.payload == undefined) {
                                    new_course.parent().removeClass('error');
                                    $('#request-error').hide();
                                    HTTP_MANAGER.executePost('/courses/add',{course:new_course.val().toUpperCase()}).done(function(resp) {
                                        if (resp.data.status === "Success") {
                                            std_course.append("<option value='"+ resp.data.payload.last_id +"'>" + new_course.val().toUpperCase() + "</option>");
                                            $('#add-course-modal').modal('hide');
                                        } else {
                                            not_success(resp.data.message);
                                        }
                                    });
                                } else {
                                    not_success('Course already exist.');
                                }
                            });
                        } else {
                            not_success('Input must not be empty.');
                        }
                        return false;
                    }
                }).modal('show');
            });

            /*
             * Handle image upload.
             *
             * */
            $('#embedpollfileinput').on('change', function(){
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profile-picture').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });


            /*
             * Semantic UI Initialize.
             *
             * */
            $('.ui.dropdown').dropdown();

            $('#birth-date-cal').calendar({
                type: 'date',
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
            $('#registration-form').form({
                fields: {
                    first_name: {
                        identifier: 'first_name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'First name must not be empty.'
                            }
                        ]
                    },
                    middle_name: {
                        identifier: 'middle_name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Middle name must not be empty.'
                            }
                        ]
                    },
                    last_name: {
                        identifier: 'last_name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Last name must not be empty.'
                            }
                        ]
                    },
                    gender: {
                        identifier: 'gender',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Gender name must not be empty.'
                            }
                        ]
                    },
                    std_id_num: {
                        identifier: 'std_id_num',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Student ID is required.'
                            }
                        ]
                    },
                    std_course: {
                        identifier: 'std_course',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Course is required.'
                            }
                        ]
                    },
                    std_section: {
                        identifier: 'std_section',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Section is required.'
                            }
                        ]
                    },
                    birth_date: {
                        identifier: 'birth_date',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Birth Date is required.'
                            }
                        ]
                    },
                    personal_address: {
                        identifier: 'personal_address',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Personal address is required.'
                            }
                        ]
                    },
                    contact_email: {
                        identifier: 'contact_email',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Personal email is required.'
                            },
                            {
                                type   : 'email',
                                prompt : 'Personal email must be valid.'
                            }
                        ]
                    },
                    guardian_name: {
                        identifier: 'guardian_name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Guardian name is required.'
                            }
                        ]
                    },
                    guardian_address: {
                        identifier: 'guardian_address',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Guardian address is required.'
                            }
                        ]
                    },
                    guardian_email: {
                        identifier: 'guardian_email',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : 'Guardian email is required.'
                            },
                            {
                                type   : 'email',
                                prompt : 'Guardian email must be valid.'
                            }
                        ]
                    },
                    mobile_number: {
                        identifier: 'mobile_number',
                        rules: [
                            {
                                type   : 'number',
                                prompt : 'Must be valid number.'
                            }
                        ]
                    },
                    guardian_number: {
                        identifier: 'guardian_number',
                        rules: [
                            {
                                type   : 'number',
                                prompt : 'Must be valid number.'
                            }
                        ]
                    }
                },
                onSuccess : function(e){
                    e.preventDefault();
                    HTTP_MANAGER.executePost("/register/",{
                        data: {
                            first_name: $('#first-name').val(),
                            middle_name: $('#middle-name').val(),
                            last_name: $('#last-name').val(),
                            gender: $('#gender').val(),
                            std_id_num: $('#std-id-num').val(),
                            std_course: $('#std-course').val(),
                            std_section: $('#std-section').val(),
                            birth_date: $('#birth-date').val(),
                            personal_address: $('#personal-address').val(),
                            contact_email: $('#contact-email').val(),
                            guardian_name: $('#guardian-name').val(),
                            guardian_address: $('#guardian-address').val(),
                            guardian_email: $('#guardian-email').val(),
                            mobile_number: $('#mobile-number').val(),
                            contact_email: $('#contact-email').val(),
                            guardian_number: $('#guardian-number').val(),
                        }
                    },function () {
                        $('#submit-request').addClass('disabled').addClass('loading');
                    }).done(function (response) {
                        if (response.data.status === "Success") {
                            $('#submit-request').removeClass('loading').removeClass('disabled');
                            $('#error-messages').html('').hide();
                            window.location.replace('{{ route("student_view") }}');
                        } else {
                            $('#submit-request').removeClass('loading');
                            $('#error-messages').html('<ul class="list"><li>' + response.data.message + '</li></ul>').show();
                        }
                    });
                }
            });
        });
    </script>
@endsection