@extends('layouts.app')
@section('on_page_css')
    <style>
        .update-text-field {
            border:none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.4);
            color: rgba(0, 0, 0, 0.5);
            margin-left: 5px;
        }
        .update-text-field:focus {
            outline: none;
            border-bottom: 2px solid #bebebe;
        }
    </style>
@endsection
@section('content')
    <div class="main ui container" id="main-container">
        <div class="segment form-container" style="margin-top: 4rem;">
            @if($id_number)
                <form action="#" onsubmit="return false">
                    <div class="ui three column stackable grid" id="single-information">
                        <div class="column">
                            <div class="ui fluid card">
                                <div class="content">
                                    <span class="header" id="fullname"></span>
                                    <div class="meta">
                                        <input type="email" class="update-text-field" id="email"/>
                                    </div>
                                    <div class="meta">
                                        <input type="text" class="update-text-field" id="mobile-number"/>
                                    </div>
                                </div>
                                <div class="extra content">
                                    <div>
                                        <strong>ID Number: </strong> <input type="text" class="update-text-field" id="id-number"/>
                                    </div>
                                    <div>
                                        <strong>Course: </strong> <span id="course"></span>
                                    </div>
                                    <div>
                                        <strong>Section: </strong> <input type="text" class="update-text-field" id="section"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="two column" style="width: 66.66%;">
                            <h3 class="ui dividing header">Full Information</h3>
                            <div class="ui two column row grid">
                                <div class="column">
                                    <strong>Guardian Name: </strong> <input type="text" class="update-text-field" id="guardian-name"/>
                                </div>
                                <div class="column">
                                    <strong>Personal Address: </strong> <input type="text" class="update-text-field" id="personal-address"/>
                                </div>

                            </div>
                            <div class="ui two column row grid">
                                <div class="column">
                                    <strong>Guardian Address: </strong> <input type="text" class="update-text-field" id="guardian-address"/>
                                </div>
                                <div class="column">
                                    <strong>Gender: </strong> <input type="text" class="update-text-field" id="gender"/>
                                </div>
                            </div>
                            <div class="ui two column row grid">
                                <div class="column">
                                    <strong>Guardian Contact: </strong> <input type="text" class="update-text-field" id="guardian-contact"/>
                                </div>
                                <div class="column">
                                    <strong>Birth Date: </strong> <input type="text" class="update-text-field" id="birth-date"/>
                                </div>
                            </div>
                            <div class="ui two column row grid">
                                <div class="column">
                                    <strong>Guardian Email: </strong> <input type="text" class="update-text-field" id="guardian-email"/>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 2rem;float:right;">
                                <button class="ui labeled icon button" id="update-data">
                                    <i class="check green icon"></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <h2>No data available.</h2>
            @endif
        </div>
    </div>
@endsection

@if($id_number)
    @section('on_page_js')
        <script type="text/javascript">
            var elements = ["fullname","email","mobile-number","id-number","section","course","guardian-name","personal-address","guardian-address","gender","guardian-contact","birth-date","guardian-email"];
            var dynamic_append = function (elements, values) {
                elements.forEach(function(element, i){
                    if (element === "fullname" || element === "course" ) {
                        $('#'+element).html(values[i]);
                        return true;
                    }
                    $('#'+element).val(values[i]);
                });
            };
            HTTP_MANAGER.executePost("/students/single",{data_id: "{{ $id_number }}" }).done(function(response){
                if (response.data.status !== "Success") {
                    $('#single-information').hide();
                    $('.form-container').html('<h2>No data available.</h2>');
                    return true;
                }

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

                //Update Information
                $('#update-data').on('click', function() {
                    //Create the data request
                    var data_request = {};
                    elements.forEach(function(element, i){
                        if (element === "fullname") {
                            data_request[element.replace('-','_')] = $('#'+element).text();
                            return true;
                        }
                        data_request[element.replace('-','_')] = $('#'+element).val();
                    });
                    data_request['student_data_id'] = payload.student_data_id;
                    data_request['student_detail_id'] = payload.student_detail_id;

                    HTTP_MANAGER.executePost("/students/update", {data: data_request }).done(function(update_response){
                        location.replace('{{ route('student_view') }}');
                    });
                });
            });
        </script>
    @endsection
@endif