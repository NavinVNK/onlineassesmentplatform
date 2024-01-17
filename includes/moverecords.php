<?php

function moveAssessmentToHistory($student_id, $conn) {
    // Fetch values from tbl_assessment_records
    $selectQuery = "SELECT * FROM tbl_assessment_records WHERE student_id = '$student_id'";
    $selectResult = $conn->query($selectQuery);

    if ($selectResult) {
        // Fetch the first row (assuming there is only one row for a student_id)
        $row = $selectResult->fetch_assoc();

        if ($row) {
            // Insert values into tbl_assesment_history
            $insertQuery = "INSERT INTO tbl_assessment_history 
                            (record_id, student_id, student_name, exam_id, exam_name, score, status, next_retake, date) 
                            VALUES ('{$row['record_id']}', '{$row['student_id']}', '{$row['student_name']}', '{$row['exam_id']}', '{$row['exam_name']}', '{$row['score']}', '{$row['status']}', '{$row['next_retake']}', '{$row['date']}')";

            $insertResult = $conn->query($insertQuery);

            if ($insertResult) {
                // Proceed with deletion from tbl_assessment_records
                $deleteQuery = "DELETE FROM tbl_assessment_records WHERE student_id = '$student_id'";
                $deleteResult = $conn->query($deleteQuery);

                if ($deleteResult) {
                    return true; // Success
                } else {
                    return "Error deleting rows from tbl_assessment_records: " . $conn->error;
                }
            } else {
                return "Error inserting values into tbl_assesment_history: " . $conn->error;
            }
        } else {
            return "No records found for student_id: $student_id";
        }
    } else {
        return "Error fetching values from tbl_assessment_records: " . $conn->error;
    }
}

?>
