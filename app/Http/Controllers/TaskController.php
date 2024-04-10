<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function createOrUpdateTaskAndAssignStudents(Request $request)
    {
        try {
            $taskId = $request->input('task_id');
            $taskTitle = $request->input('task_title');
            $taskDescription = $request->input('task_description');
            $taskStatus = $request->input('task_status');
            $professorId = $request->input('professor_id');
            $studentIds = $request->input('student_ids');
            $taskPriority = $request->input('task_priority');
            $taskDeadline = $request->input('task_deadline');
            $taskSubmittedStatus = $request->input('task_submitted_status');
            $isDeleted = $request->input('is_deleted');
            
            $result = DB::select('CALL sproc_CreateOrUpdateTaskAndAssignStudents(?, ?, ?, ?, ?, ?, ?, ?, ?,?)', [
                $taskId,
                $taskTitle,
                $taskDescription,
                $taskStatus,
                $professorId,
                $studentIds,
                $taskPriority,
                $taskDeadline,
                $taskSubmittedStatus,
                $isDeleted
            ]);

            $status = $result[0]->status ?? 'error';
            $message = $result[0]->message ?? 'An error occurred.';
            
            return response()->json(['status' => $status, 'message' => $message], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getTasks(Request $request)
    {
        
        $filter_professor_id = $request->input('filter_professor_id');
        $filter_student_id = $request->input('filter_student_id');

        try {
            
            $tasks = DB::select('CALL sproc_GetTasks(?, ?)', [$filter_professor_id, $filter_student_id]);
            if (!empty($tasks)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $tasks
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'No tasks found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function insertWeeklyReport(Request $request)
    {
        try {
            $assignmentId = $request->input('assignment_id');
            $docUrl = $request->input('doc_url');
            $justificationComments = $request->input('justification_comments');
            $plagPercentage = $request->input('plag_percentage');

            $result = DB::select('CALL sproc_InsertWeeklyReport(?, ?, ?, ?)', array($assignmentId, $docUrl, $justificationComments, $plagPercentage));

            if (!empty($result)) {
                $status = $result[0]->status;
                $message = $result[0]->message;
            // Handle the response as needed
                return response()->json(['status' => $status, 'message' => $message]);
            } else {
            // Handle case where no result is returned
                return response()->json(['status' => 'error', 'message' => 'No response from the stored procedure']);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getWeeklyReports(Request $request)
    {
        try {
            // Retrieve parameters from the request
            $studentId = $request->input('student_id');
            $taskId = $request->input('task_id');
            $professorId = $request->input('professor_id');
            // Call the stored procedure and retrieve the result
            $reports=DB::select("CALL sproc_getWeeklyReports(?, ?, ?)", [$studentId, $taskId, $professorId]);

            if (count($reports) > 0) {
                // Return the result as JSON response with status, message, and data
                return response()->json([
                    'status' => 'success',
                    'message' => 'Weekly reports retrieved successfully',
                    'data' => $reports
                ]);
            } else {
                // Return a message indicating no data found
                return response()->json([
                    'status' => 'failure',
                    'message' => 'No weekly reports found for the specified task ID',
                    'data' => null
                ]);
            }
        } catch (Exception $e) {
            // Return error message if an exception occurs
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve weekly reports',
                'data' => null
            ], 500);
        }
    }

}
