@extends('layouts.app')

@section('on_page_css')
    <style>
        .form-container {
            margin-top: 5em;
            display: flex;
            justify-content: center;
        }

        .card-container {
            box-shadow: 0 1px 3px 0 #D4D4D5, 0 0 0 1px #D4D4D5;
            width: 600px;
            padding: 10px;
        }

        .card-container h3 {
            margin-bottom: 10px;
        }

        .card-container .meta {
            font-size: 1em;
            color: rgba(0, 0, 0, 0.4);
        }
    </style>
@endsection

@section('content')
    <div class="main ui container" id="main-container">
        <div class="segment form-container">
            @if($id_number)
                <div class="card-container" style="display: none;">
                    <div class="fluid card">
                        <div class="content">
                            <h3 class="ui dividing header" id="fullname">Emiya, Shirou Archer</h3>
                            <table>
                                <tbody>
                                    <tr class="meta">
                                        <td><strong>ID Number: </strong></td>
                                        <td id="std_id"></td>
                                    </tr>
                                    <tr class="meta">
                                        <td><strong>Course: </strong></td>
                                        <td id="std_course"></td>
                                    </tr>
                                    <tr class="meta">
                                        <td><strong>Section: </strong></td>
                                        <td id="std_section"></td>
                                    </tr>
                                    <tr class="meta">
                                        <td><strong>Violation: </strong></td>
                                        <td id="std_violation"></td>
                                    </tr>
                                    <tr class="meta">
                                        <td><strong>Subject: </strong></td>
                                        <td id="subject"></td>
                                    </tr>
                                    <tr class="meta">
                                        <td><strong>Date/Time: </strong></td>
                                        <td id="dt_occur"></td>
                                    </tr>
                                    <tr class="meta">
                                        <td><strong>Commen: </strong></td>
                                        <td id="comment"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ui bottom attached" style="margin-top: 15px;">
                        <button class="ui inverted red button" style="width: 100%;" id="remove-violation-btn">Remove Violation</button>
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
        <script type="application/javascript">
            $(document).ready(function() {
                HTTP_MANAGER.executePost("/violation/id",{vid: "{{ $id_number }}" }).done(function(response){
                    if (response.data.status !== "Success") {
                        $('.form-container').html('<h2>No data available.</h2>');
                        return true;
                    }

                    if (response.data.payload.length <= 0) {
                        $('.form-container').html('<h2>No data available.</h2>');
                        return true;
                    }
                    $('.card-container').show();
                    var data = response.data.payload;
                    $('#std_id').html(data.id_number);
                    $('#std_course').html(data.course);
                    $('#std_section').html(data.section);
                    $('#std_violation').html(data.violation);
                    $('#subject').html(data.subject);
                    $('#dt_occur').html(data.violation_occur);
                    $('#comment').html(data.violation_comment);
                });

                $('#remove-violation-btn').on('click', function(){
                    HTTP_MANAGER.executePost("/violation/remove",{vid: "{{ $id_number }}" }).done(function(){
                        window.location.replace("{{ route('index') }}");
                    });
                });
            });
        </script>
    @endsection
@endif