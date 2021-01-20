<?php
require_once './classes/dao/SubjectDaoImpl.php';
require_once './classes/dao/RoomDaoImpl.php';
require_once './classes/dao/ScheduleDaoImpl.php';
require_once './classes/dao/ScheduleUserDaoImpl.php';
require_once './classes/dao/UserDaoImpl.php';
require_once './classes/dao/GradeDaoImpl.php';

require_once './classes/Helpers.php';

class TeacherPageController
{
    protected $_subjectDao;
    protected $_roomDao;
    protected $_scheduleDao;
    protected $_scheduleUserDao;
    protected $_userDao;
    protected $_gradesDao;

    public function __construct()
    {
        $this->_subjectDao = new SubjectDaoImpl();
        $this->_roomDao = new RoomDaoImpl();
        $this->_scheduleDao = new ScheduleDaoImpl();
        $this->_scheduleUserDao = new ScheduleUserDaoImpl();
        $this->_userDao = new UserDaoImpl();
        $this->_gradesDao = new GradeDaoImpl();
    }

    public function createSubjectTable()
    {
        $headers = array('ID', 'Name', 'Description', 'View', 'Actions');
        $subjects = $this->_subjectDao->getAllSubjects();

        echo '<table id="subjectsTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($subjects as $subject) {
            echo '<tr class="clickable-row" data-subject-id="' . $subject['id'] . '">';
            echo '<td>' . $subject['id'] . '</td>';
            echo '<td>' . $subject['name'] . '</td>';
            echo '<td>' . $subject['description'] . '</td>';

            echo '<td>
                         <a href="?page=TeacherPage&addSchedule=' . $subject['id'] . '" class="view-btn" data-modal-anchor="create-schedule">Create schedule</a>
                  </td>';

            echo '<td><a href="index.php?page=TeacherPage&deleteSubject=' . $subject['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-subject"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=TeacherPage&editSubject=' . $subject['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="subject-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';

            echo '</tr>';
        }

        echo '</table';
    }

    public function createScheduleTable($view)
    {
        $subject = $this->_subjectDao->getSubjectById($view);
        $schedules = $this->_scheduleDao->getSchedulesBySubjectId($subject['id']);

        $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
        $hours = array("07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00",
            "18:00", "19:00", "20:00", "21:00");

        echo '
        <div class="schedule-inner">
                        <h3 class="sch-title">
                            Schedule
                            <br/><br/>
                            Subject:<br/><span>' . $subject['name'] . '</span>
                        </h3>
                        <div class="schedule-table">
                            <div class="st-head flex-box">
                                <div class="col-1">
                                    <span class="time-span">From</span>
                                    <span class="time-span">To</span>
                                </div>';

        for ($i = 0; $i < count($hours) - 1; $i++) {
            echo '<div class="col-1">';
            echo '<span class="time-span">' . $hours[$i] . '</span>';
            echo '<p class="hour-id">' . ($i + 1) . '</p>';
            echo '<span class="time-span">' . $hours[$i + 1] . '</span>';
            echo '</div>';
        }
        echo '</div>'; //Create table header with times


        foreach ($days as $day) {
            echo '<div class="st-row flex-box">';
            echo '<div class="col-1" ><span class="day">' . $day . '</span ></div>';
            foreach ($hours as $hour) {
                $filtered = null;
                $filtered = array_values(array_filter($schedules, function ($element) use ($hour, $day) {
                    $startTime = substr($element['lesson_start'], 0, -3); //From 12:00:00 format to 12:00
                    return $startTime === $hour && $element['day'] === $day;
                }));

                if ($filtered != null) {
                    $start = strtotime($filtered[0]['lesson_start']);
                    $end = strtotime($filtered[0]['lesson_end']);
                    $hourDiff = ($end - $start) / (60 * 60);
                    echo '<div class="col-' . $hourDiff . ' col-subject practice">';
                    echo '<a href="?page=TeacherPage&view=' . $subject['id'] .
                        '&editSchedule=' . $filtered[0]['id'] . '" class="line-overflow">' . $subject['name'] . '</a ></div>';
                } else {
                    echo '<div class="col-1"><span></span></div>';
                } //Check if schedule for this date exists, calculte how long and draw. Otherwise empty div
            }
            echo '</div>';
        }
        echo '</div>';
    }

    public function createStudentsListForSchedule($id)
    {
        $students = array_unique($this->_scheduleUserDao->getScheduleUserByScheduleId($id), SORT_REGULAR);
        $students = array_intersect_key($students, array_unique(array_map(function ($el) {
            return $el['id_user'];
        }, $students))); //Uniqueu user


        echo '<div class="student-list flex-box">
                    <div class="col">
                        <div class="list">';
        foreach ($students as $student) {
            $user = $this->_userDao->geUserById($student['id_user']);
            $url = '?page=TeacherPage&view='
                . $_GET['view'] . '&editSchedule=' . $_GET['editSchedule'];
            echo '<a href="' . $url . '&student=' . $user['id'] . '" class="item ';
            if ($_GET['student'] == $user['id']) echo 'active';
            echo '">' . $user['firstname'] . ' ' . $user['lastname'] . '</a>';

        }
        echo '</div></div>';

    }

    public function createSubject($data)
    {
        $errorMsg = "";
        if ($this->validateSubject($data, $errorMsg)) {
            $this->_subjectDao->insertSubject($data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteSubject($subjectId)
    {
        $this->_subjectDao->deleteSubjectById($subjectId);
    }

    public function getSubject($subjectId)
    {
        return $this->_subjectDao->getSubjectById($subjectId);
    }

    public function updateSubject($data)
    {
        $errorMsg = "";
        if ($this->validateSubject($data, $errorMsg)) {
            $this->_subjectDao->updateSubject($data['id'], $data['name'], $data['description']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function getAllSubjects()
    {
        return $this->_subjectDao->getAllSubjects();
    }

    public function getAllRooms()
    {
        return $this->_roomDao->getAllRooms();
    }

    public function createSchedule($data)
    {
        $errorMsg = "";
        if ($this->validateSchedule($data, $errorMsg)) {
            $this->_scheduleDao->insertSchedule($data['day'], $data['lesson_start'], $data['lesson_end'], $data['subject'], $data['room']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function getSchedule($editSchedule)
    {
        return $this->_scheduleDao->getScheduleById($editSchedule);
    }

    public function deleteSchedule($scheduleId)
    {
        $this->_scheduleDao->deleteScheduleById($scheduleId);
    }


    public function createStudentGrades($studentId, $scheduleId)
    {
        $student = $this->_userDao->geUserById($studentId);
        $studentGrades = $this->_scheduleUserDao->getScheduleUserByScheduleIdAndUserId($scheduleId, $studentId);
        echo '<div class="col">
                        <div class="grades">';
        echo '<a href="?page=TeacherPage&view='
            . $_GET['view'] . '&editSchedule=' . $_GET['editSchedule'] . '&student=' . $_GET['student'] .
            '&expell=' . $student['id'] . '"class="expell" data-modal-anchor="expell-student">Expell the student</a>';

        echo '<p>Name: <span>' . $student['firstname'] . ' ' . $student['lastname'] . '</span>';
        echo '</br></br>Grades:</p>
                            <div class="grade-box">
                                <button class="add-new-grade" data-modal-anchor="create-grade">Add new grade +</button>
                                <table>
                                    <tr>
                                        <th>Task name</th>
                                        <th>Grade</th>
                                        <th>Actions</th>
                                    </tr>
                                ';
        foreach ($studentGrades as $studentGrade) {
            $grade = $this->_gradesDao->getGradeById($studentGrade['id_grade']);
            if($grade != null) {
                echo '<tr><td>' . $grade['type'] . '</td><td>' . $grade['grade'] . '</td>';
                echo '<td><a href="' . $_SERVER['REQUEST_URI'] . '&removeGrade=' . $studentGrade['id'] . '">Delete</a></td></tr>';
            }
        }
        echo '</table>
                            </div>
                        </div>
                    </div>
                </div>';


    }

    public function expellStudent($editSchedule, $expell)
    {
        $this->_scheduleUserDao->deleteScheduleUserByScheduleIdAndUserId($editSchedule, $expell);
    }

    public function deleteGradeFromSchedule($id)
    {
        $this->_scheduleUserDao->deleteScheduleUserById($id);
    }

    public function createGrade($data)
    {
        $errorMsg = "";
        if ($this->validateGrade($data, $errorMsg)) {
            $id = $this->_gradesDao->insertGrade($data['grade'], $data['type']);
            $this->_scheduleUserDao->insertScheduleUser($data['schedule'], $data['student'], $id);
        } else {
            Helpers::alert($errorMsg);
        }


    }

    private function validateGrade($data, &$msg)
    {
        if (empty($data['grade']) ||
            empty($data['type'])) {
            $msg = "Grade or type cannot be empty";
            return false;
        }

        if ($data['grade'] != "A"
            && $data['grade'] != "B"
            && $data['grade'] != "C"
            && $data['grade'] != "D"
            && $data['grade'] != "E"
            && $data['grade'] != "F") {
            $msg = "Grade can be only A/B/C/D/E/F";
            return false;
        }

        return true;
    }

    private function validateSubject($data, &$msg)
    {
        if (empty($data['name'])) {
            $msg = "Subject name cannot be empty";
            return false;
        } else if (strlen($data['name']) > 250
            || strlen($data['description']) > 500) {
            $msg = "Max size exceeded";
            return false;
        }

        if($data['action'] != "editSubject") {
            if ($this->_subjectDao->getSubjectByName($data['name']) != null) {
                $msg = "Subject with same name already exists";
                return false;
            }
        }

        return true;
    }

    private function validateSchedule($data, &$msg)
    {
        if (empty($data['day'])
            || empty($data['lesson_start'])
            || empty($data['lesson_end'])
            || empty($data['subject'])
            || empty($data['room'])) {
            $msg = "Data cannot be empty";
            return false;
        }

        if ($data['day'] != "Monday"
            && $data['day'] != "Tuesday"
            && $data['day'] != "Wednesday"
            && $data['day'] != "Thursday"
            && $data['day'] != "Friday") {
            $msg = "Invalid day";
            return false;
        }

        if ($this->_subjectDao->getSubjectById($data['subject']) == null
            || $this->_roomDao->getRoomById($data['room']) == null) {
            $msg = "Invalid data";
            return false;
        }

        if (!preg_match("/^[0-9]{2}:[0-9]{2}$/", $data['lesson_start'])
            || !preg_match("/^[0-9]{2}:[0-9]{2}$/", $data['lesson_end'])) {
            $msg = "Dates are not in correct format";
            return false;
        }

        $lessonStart = strtotime($data['lesson_start']);
        $lessonEnd = strtotime($data['lesson_end']);
        $hourDiff = ($lessonEnd - $lessonStart) / (60 * 60);
        if ($hourDiff <= 0 || $hourDiff > 4) {
            $msg = "Schedule lesson should be last between 1-4 hours";
            return false;
        }

        return true;
    }
}