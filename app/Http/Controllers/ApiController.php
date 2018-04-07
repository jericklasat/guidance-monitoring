<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PHPUnit\Runner\Exception;
use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{
    public function allCourses()
    {
        try {
            $courses = DB::table('courses')->get();
            $response = $this->buildJsonResponse('Success', "Fetching courses", $courses);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function courseExist()
    {
        try {
            $term = Input::get('course');
            $course = DB::table('courses')->where('course_name',$term)->first();
            $response = $this->buildJsonResponse('Success', "Fetching course", $course);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function addCourse()
    {
        try {
            $course = Input::get('course');
            $last_id = DB::table('courses')->insertGetId([
                'course_name' => $course,
                'modified_at' => date('Y-m-d H:m:s'),
                'created_at' => date('Y-m-d H:m:s')
            ]);
            $response = $this->buildJsonResponse('Success', "Adding course.",['last_id' => $last_id]);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function registerStudent()
    {
        $data = Input::get('data');
        try {
            $sn_registered = DB::table('students_data')->where('student_id_number', $data['std_id_num'])->first();
            if (!isset($sn_registered->student_id_number)) {
                /*
                 * Insert the Detail
                 * Get the ID and insert in Data.
                 * */
                $detail_id = DB::table('student_details')->insertGetId(
                    [
                        'firstname' => $data['first_name'],
                        'middlename' => $data['middle_name'],
                        'lastname' => $data['last_name'],
                        'gender' => $data['gender'],
                        'address' => $data['personal_address'],
                        'birth_date' => $data['birth_date'],
                        'mobile_number' => ($data['mobile_number'] != null) ? $data['mobile_number'] : 0,
                        'contact_email' => $data['contact_email'],
                        'student_image_id' => 'NA',
                        'guardian_name' => $data['guardian_name'],
                        'guardian_contact_number' => ($data['guardian_number'] != null) ? $data['mobile_number'] : 0,
                        'guardian_address' => $data['guardian_address'],
                        'guardian_email' => $data['guardian_email'],
                        'modified_at' => date('Y-m-d H:m:s'),
                        'created_at' => date('Y-m-d H:m:s')
                    ]
                );

                $data_id = DB::table('students_data')->insertGetId(
                    [
                        'student_details_id' => $detail_id,
                        'student_id_number' => $data['std_id_num'],
                        'course' => $data['std_course'],
                        'current_section' => $data['std_section'],
                        'modified_at' => date('Y-m-d H:m:s'),
                        'created_at' => date('Y-m-d H:m:s')
                    ]
                );
                $response = $this->buildJsonResponse('Success', "Adding student.",["data_id" => $data_id]);
            } else {
                $response = $this->buildJsonResponse('Failed', "Student Number already in used.");
            }
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function fetchAllStudentsRecord()
    {
        try {
            $std_data = DB::table('students_data')
                ->leftJoin('student_details', 'students_data.student_details_id', '=', 'student_details.student_detail_id')
                ->leftJoin('courses', 'students_data.course', '=', 'courses.course_id')
                ->get();
            $data = [];
            foreach ($std_data as $std) {
                $middlename = ($std->middlename != "N/A") ? $std->middlename : "";
                $build = [
                    "student_id_number" => $std->student_id_number,
                    "fullname" => $std->lastname . ", " . $std->firstname . " " . $middlename,
                    "course" => $std->course_name,
                    "section" => $std->current_section,
                    "action" => $std->student_data_id
                ];
                array_push($data, $build);
            }
            $response = $this->buildJsonResponse('Success', "Fetching all student record.",$data);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function fetchAllSubject()
    {
        try {
            $subjects = DB::table('subjects')->get();
            $response = $this->buildJsonResponse('Success', "Fetching subjects", $subjects);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function subjectExist()
    {
        try {
            $term = Input::get('subject');
            $course = DB::table('subjects')->where('subject_name',$term)->first();
            $response = $this->buildJsonResponse('Success', "Fetching subject", $course);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function addSubject()
    {
        try {
            $subject = Input::get('subject');
            $last_id = DB::table('subjects')->insertGetId([
                'subject_name' => $subject,
                'modified_at' => date('Y-m-d H:m:s'),
                'created_at' => date('Y-m-d H:m:s')
            ]);
            $response = $this->buildJsonResponse('Success', "Adding subject.",['last_id' => $last_id]);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function addViolation()
    {
        try {
            $data = Input::get('data');
            $data_id = DB::table('violations')->insertGetId(
                [
                    'student_data_id' => $data['std_account'],
                    'violation_type' => $data['violation_type'],
                    'section' => $data['section'],
                    'subject' => $data['subject'],
                    'instructor_name' => $data['instructor_name'],
                    'violation_occur' => date_format(date_create($data['violation_occur']), 'Y-m-d H:m:s'),
                    'violation_comment' => ($data['violation_comment'] == null) ? "" : $data['violation_comment'],
                    'modified_at' => date('Y-m-d H:m:s'),
                    'created_at' => date('Y-m-d H:m:s')
                ]
            );
            $response = $this->buildJsonResponse('Success', "Adding violation.",["violation_id" => $data_id]);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;

    }

    public function violationHistory()
    {
        try {
            $data = [];
            $violation_data = DB::table('violations')
                ->leftJoin('students_data', 'violations.student_data_id', '=', 'students_data.student_data_id')
                ->leftJoin('student_details', 'students_data.student_details_id', '=', 'student_details.student_detail_id')
                ->leftJoin('courses', 'students_data.course', '=', 'courses.course_id')
                ->leftJoin('subjects', 'violations.subject', '=', 'subjects.subject_id')
                ->get();
            foreach ($violation_data as $violation) {
                $middlename = ($violation->middlename != "N/A") ? $violation->middlename : "";
                $build = [
                    "name" => $violation->lastname . ", " . $violation->firstname . " " . $middlename,
                    "id_number" => $violation->student_id_number,
                    "course" => $violation->course_name,
                    "section" => $violation->current_section,
                    "violation" => $violation->violation_type,
                    "subject" => $violation->subject_name
                ];
                array_push($data, $build);
            }
            $response = $this->buildJsonResponse('Success', "Fetching all violations history.",$data);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function violationsTotal()
    {
        try {
            $data = [
                "Behaviour" => 0,
                "Tardiness" => 0,
                "Absent" => 0
            ];
            $violation_data = DB::table('violations')->get();
            foreach ($violation_data as $violation) {
                $data[$violation->violation_type] += 1;
            }
            $response = $this->buildJsonResponse('Success', "Fetching total violations.", $data);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    public function fetchStudentById()
    {
        try {
            $data_id = Input::get('data_id');
            $students_data = DB::table('students_data')
                ->leftJoin('student_details', 'students_data.student_details_id', '=', 'student_details.student_detail_id')
                ->leftJoin('courses', 'students_data.course', '=', 'courses.course_id')
                ->where('student_data_id', $data_id)->first();
            $response = $this->buildJsonResponse('Success', "Fetching student data.", $students_data);
        } catch (Exception $exception) {
            $response = $this->buildJsonResponse('Error', $exception->getMessage());
        }
        return $response;
    }

    /**
     * Build and handle json response
     *
     * @param $type
     * @param $message
     * @param array $data
     * @return string
     */
    public function buildJsonResponse($type, $message, $data = [])
    {
        /*
         * The type ('Success', 'Failed', 'Error') and message parameters must be string
         * while data must be an array
         */
        $response = [
            'status' => $type,
            'message' => 'Request ' . $type . ': ' . $message,
        ];

        if ($type == 'Success') {
            $response['payload'] = $data;
        }
        return json_encode($response);
    }
}
