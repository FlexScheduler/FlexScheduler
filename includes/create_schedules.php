<?php
// includes
require "execute_query.php";
require "convert_term.php";

// define database connection
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "flexscheduler");

// check at least one course selected
if (isset($_POST["pCourseData"]) && isset($_POST["pTerm"])) {
    // decode courses data
    $courseData = json_decode(stripcslashes(json_encode($_POST["pCourseData"])), true);

    // decode term
    $term = json_decode(stripcslashes(json_encode($_POST["pTerm"])), true);
    $months = convert_term($term);
    $strtMonth = $months[0];
    $endMonth = $months[1];

    // create time class
    class Time
    {
        public $strtTime;
        public $endTime;

        public function __construct($strtTime, $endTime)
        {
            $this->strtTime = date("H:i:s", strtotime($strtTime));
            $this->endTime = date("H:i:s", strtotime($endTime));
        }
    }

    // create course class
    class Course
    {
        public $deptID;
        public $crseID;
        public $secID;
        public $instrLName;
        public $instrFName;

        public function __construct($deptID, $crseID, $secID, $instrLName, $instrFName)
        {
            $this->deptID = $deptID;
            $this->crseID = $crseID;
            $this->secID = $secID;
            $this->instrLName = $instrLName;
            $this->instrFName = $instrFName;
        }
    }

    // create node class
    class Node
    {
        public $deptID;
        public $crseID;
        public $crseName;
        public $secID;
        public $times = array();
        public $instrLName;
        public $instrFName;
        public $children = array();

        public function __construct(
            $deptID,
            $crseID,
            $crseName,
            $secID,
            $dayID,
            $strtTime,
            $endTime,
            $instrLName,
            $instrFName
        ) {
            $this->deptID = $deptID;
            $this->crseID = $crseID;
            $this->crseName = $crseName;
            $this->secID = $secID;
            $this->instrLName = $instrLName;
            $this->instrFName = $instrFName;
            for ($j = 0; $j<5; ++$j) {
                if (!isset($this->times[$j])) {
                    $this->times[$j] = array();
                }
            }
            $time = new Time($strtTime, $endTime);
            if ($dayID == "M") {
                array_push($this->times[0], $time);
            } elseif ($dayID == "T") {
                array_push($this->times[1], $time);
            } elseif ($dayID == "W") {
                array_push($this->times[2], $time);
            } elseif ($dayID == "R") {
                array_push($this->times[3], $time);
            } elseif ($dayID == "F") {
                array_push($this->times[4], $time);
            }
            if (!isset($this->children)) {
                $this->children = array();
            }
        }
    }

    // create tree class
    class Tree
    {
        public $roots = array();
        public $leaves = array();

        public function __construct()
        {
        }

        public function build_tree($nodeArr, $currLevel)
        {
            if (isset($nodeArr[$currLevel + 1])) {
                foreach ($nodeArr[$currLevel] as $cn=>$currNode) {
                    foreach ($nodeArr[$currLevel + 1] as $nextNode) {
                        $added = false;
                        foreach ($currNode->times as $cd=>$cDay) {
                            foreach ($cDay as $cTime) {
                                foreach ($nextNode->times as $nd=>$nDay) {
                                    foreach ($nDay as $nTime) {
                                        if ($cd == $nd) {
                                            if (
                                                !(($cTime->strtTime >= $nTime->strtTime && $cTime->strtTime <= $nTime->strtTime) ||
                                                ($cTime->strtTime >= $nTime->strtTime && $cTime->strtTime <= $nTime->strtTime))
                                            ) {
                                                array_push($nodeArr[$currLevel][$cn]->children, $nextNode);
                                                $added = true;
                                                break;
                                            }
                                        }
                                    }
                                    if ($added) {
                                        break;
                                    }
                                }
                                if ($added) {
                                    break;
                                }
                            }
                            if ($added) {
                                break;
                            }
                        }
                    }
                }
                $this->build_tree($nodeArr, $currLevel + 1);
            }
        }

        public function get_leaves($root, $currDepth, $maxDepth, $box)
        {
            array_push($box, $root);
            if (empty($root->children)) {
                if ($currDepth == $maxDepth) {
                    array_push($this->leaves, $box);
                }
            } else {
                foreach ($root->children as $child) {
                    $this->get_leaves($child, $currDepth + 1, $maxDepth, $box);
                }
            }
        }
    }

    // establish connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset("utf8mb4");

    // create nodes for each selected course
    $nodeArr = array();
    $maxDepth = 0;
    foreach ($courseData as $crse) {
        // get deptID
        $deptID = $crse["courseDept"];

        // get course ID
        $crseFull = explode(" - ", $crse["courseID"]);
        $crseID = (int)$crseFull[0];

        // get all sessions matching selected courses
        $sql = "
        SELECT
            Sections.deptID AS deptID,
            Sections.crseID AS crseID,
            Sections.crseName AS crseName,
            Sections.secID AS secID,
            SessionInstructors.dayID AS dayID,
            SessionInstructors.strtTime AS strtTime,
            SessionInstructors.endTime AS endTime,
            SessionInstructors.instrLName AS instrLName,
            SessionInstructors.instrFName AS instrFName
        FROM
            Sections, SessionInstructors
        WHERE ";
        if ($crse["courseDept"] != "ALL") {
            $sql .= "Sections.deptID = '" . $deptID . "' AND ";
        }
        if ($crse["courseID"] != "ALL") {
            $sql .= "Sections.crseID = " . $crseID . " AND ";
        }
        if ($crse["courseInstr"] != "ALL") {
            $instrFull = explode(", ", $crse["courseInstr"]);
            $sql .= "SessionInstructors.instrLName = '" . $instrFull[0] . "' AND ";
            $sql .= "SessionInstructors.instrFName = '" . $instrFull[1] . "' AND ";
        }
        $sql .=
            "Sections.deptID = SessionInstructors.deptID AND
            Sections.crseID = SessionInstructors.crseID AND
            Sections.secID = SessionInstructors.secID AND
            MONTH(Sections.strtDate) BETWEEN " . ($strtMonth - 2) % 12 . " AND " . ($strtMonth + 2) % 12 . " AND
            MONTH(Sections.endDate) BETWEEN " . ($endMonth - 2) % 12 . " AND " . ($endMonth + 2) % 12 . ";";
        $resultSections = execute_query($conn, $sql);

        while ($row = $resultSections->fetch_assoc()) {
            // if no sections exist
            if (!isset($nodeArr[$maxDepth])) {
                $nodeArr[$maxDepth] = array();
                $node = new Node(
                    $row["deptID"],
                    $row["crseID"],
                    $row["crseName"],
                    $row["secID"],
                    $row["dayID"],
                    $row["strtTime"],
                    $row["endTime"],
                    $row["instrLName"],
                    $row["instrFName"]
                );
                array_push($nodeArr[$maxDepth], $node);
            }

            // if section exists add day
            elseif (
              $row["deptID"] == $nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->deptID &&
              $row["crseID"] == $nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->crseID &&
              $row["secID"] == $nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->secID
            ) {
                $time = new Time($row["strtTime"], $row["endTime"]);
                $dayID = $row["dayID"];
                if ($dayID == "M") {
                    array_push($nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->times[0], $time);
                } elseif ($dayID == "T") {
                    array_push($nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->times[1], $time);
                } elseif ($dayID == "W") {
                    array_push($nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->times[2], $time);
                } elseif ($dayID == "R") {
                    array_push($nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->times[3], $time);
                } elseif ($dayID == "F") {
                    array_push($nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->times[4], $time);
                }
            }

            // if section does not exist create new section
            elseif (
              $row["deptID"] == $nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->deptID &&
              $row["crseID"] == $nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->crseID &&
              $row["secID"] != $nodeArr[$maxDepth][count($nodeArr[$maxDepth]) - 1]->secID
            ) {
                $node = new Node(
                    $row["deptID"],
                    $row["crseID"],
                    $row["crseName"],
                    $row["secID"],
                    $row["dayID"],
                    $row["strtTime"],
                    $row["endTime"],
                    $row["instrLName"],
                    $row["instrFName"]
                );
                array_push($nodeArr[$maxDepth], $node);
            }
        }
        $resultSections->free_result();
        ++$maxDepth;
    }

    // decode personal data
    $personalData;
    if (isset($_POST["pPersonalData"])) {
        $personalData = json_decode(stripcslashes(json_encode($_POST["pPersonalData"])), true);

        // create personal schedule time table
        $personalTime = array();
        for ($j = 0; $j<5; ++$j) {
            if (!isset($personalTime[$j])) {
                $personalTime[$j] = array();
            }
        }
        foreach ($personalData as $row) {
            $days = str_split($row["personalDays"]);
            $time = new Time($row["personalStartTime"], $row["personalEndTime"]);
            foreach ($days as $day) {
                if ($day == "M") {
                    array_push($personalTime[0], $time);
                } elseif ($day == "T") {
                    array_push($personalTime[1], $time);
                } elseif ($day == "W") {
                    array_push($personalTime[2], $time);
                } elseif ($day == "R") {
                    array_push($personalTime[3], $time);
                } elseif ($day == "F") {
                    array_push($personalTime[4], $time);
                }
            }
        }

        // remove anything instersecting with personal schedule table
        foreach ($nodeArr as $r=>$row) {
            $removed = false;
            foreach ($row as $c=>$col) {
                foreach ($col->times as $d=>$day) {
                    foreach ($day as $time) {
                        foreach ($personalTime as $pd=>$pDay) {
                            foreach ($pDay as $pTime) {
                                if (
                                    (($time->strtTime >= $pTime->strtTime && $time->strtTime <= $pTime->endTime) ||
                                    ($time->endTime >= $pTime->strtTime && $time->endTime <= $pTime->endTime)) &&
                                    ($d == $pd)
                                ) {
                                    unset($nodeArr[$r][$c]);
                                    $removed = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // initialize tree
    $tree = new Tree();
    foreach ($nodeArr[0] as $root) {
        array_push($tree->roots, $root);
    }

    // build trees
    $tree->build_tree($nodeArr, 0);

    // get leaf nodes
    $counter = 1;
    foreach ($tree->roots as $root) {
        $box = array();
        $tree->get_leaves($root, 0, $maxDepth - 1, $box);
    }
    foreach ($tree->leaves as $schedule) {
        // create title for table
        $newDiv =
        '<h3>Schedule ' . $counter . '</h3>';
        echo $newDiv;

        // create table
        $newTable =
        '<div class="table-hover table-striped">
        <table class="table" id="schedule' . $counter . '">
          <thead class="thead-dark">
            <tr>
              <th>Department</th>
              <th>Course</th>
              <th>Section</th>
              <th>Instructor</th>
            </tr>
          </thead>
          <tbody>';

        // add rows to table
        foreach ($schedule as $crse) {
            $newTable .= "<tr>";
            $newTable .= "<td>" . $crse->deptID . "</td>";
            $newTable .= "<td>" . $crse->crseID . "</td>";
            $newTable .= "<td>" . $crse->secID . "</td>";
            $newTable .= "<td>" . $crse->instrLName . ", " . $crse->instrFName . "</td>";
            $newTable .= "</tr>";
        }
        $newTable .=
            '</tbody>
            </table>
            </div><br>
            <hr class="my-5" /><br>';
        echo $newTable;
        ++$counter;
    }
}
