<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    public function createOrUpdateRecommendation(Request $request)
    {
        try{
            $id = $request->input('id', -1);
            $student_id = $request->input('student_id');
            $professor_id = $request->input('professor_id');
            $status = $request->input('status');
            $supported_doc_url = $request->input('supported_doc_url');
            $request_type = $request->input('request_type');
            $student_comments = $request->input('student_comments');
            $professor_comments = $request->input('professor_comments');

            $result = DB::select('CALL sproc_CreateOrUpdateRecommendationRequest(?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $student_id,
                $professor_id,
                $status,
                $supported_doc_url,
                $request_type,
                $student_comments,
                $professor_comments
            ]);
            if(!empty($result))
                return response()->json($result);
            else{
                return json(['status'=>'failure','message'=>'Something went wrong'],500);
            }
        }
        catch(Exception $e){
            return json(['status'=>'error','message'=>$e->getMessage()],500);
        }

        
    }



    public function downloadRecommendationLetter(Request $request)
    {
        try{
            $student_name=$request->input('student_name');
            $professor_name=$request->input('professor_name');
            $professor_designation=$request->input('professor_designation');
            $today_date = now()->format('D, m/d/Y');
            $data=[
                'student_name'=>$student_name,
                'professor_name'=>$professor_name,
                'professor_designation'=>$professor_designation,
                'today_date'=>$today_date
            ];
            $pdf = Pdf::loadView('RecommendationLetter', ['data' => $data]);
            return $pdf->download('RL_'.$student_name.'pdf');
        }
        catch(Exception $e)
        {
            return json(['status'=>'error','message'=>$e->getMessage()],500);
        }
    }


    public function getRecommendationRequests(Request $request)
{
    try {
        // Extract parameters from the request
        $professorId = $request->input('professor_id');
        $studentId = $request->input('student_id');
        $status = $request->input('status');

        // Call the stored procedure using the DB facade
        $results = DB::select('CALL sproc_GetAllRecommendationRequests(?, ?, ?)', [$professorId, $studentId, $status]);

        // Check if there are no results
        if (empty($results)) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No recommendation requests found',
                'data' => []
            ]);
        }

        // Return success response with data
        return response()->json([
            'status' => 'success',
            'message' => 'Recommendation requests retrieved successfully',
            'data' => $results
        ]);
    } catch (Exception $e) {
        // Return error response
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve recommendation requests',
            'data' => null
        ], 500);
    }
}

}
