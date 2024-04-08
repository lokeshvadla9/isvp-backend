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
}
