<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function createQuery(Request $request)
    {
        try{
            $result = DB::select('CALL sproc_CreateUserQuery(?, ?, ?)', [
            $request->input('name'),
            $request->input('email'),
            $request->input('description'),
        ]);

            
        return response()->json([
            'status' => 'success',
            'message' => $result[0]->message,
        ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
             ], 500);
        }
    }

    public function getQueries()
    {
        try {
            $queries = DB::select('CALL sproc_GetAllQueries()');
            if (empty($queries)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'No data found',
                    'data' => [],
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message'=>'Queries retrieved successfully',
                'data' => $queries,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function updateQueryStatus(Request $request)
    {
        try {
            $queryId = $request->input('query_id');
            $status = $request->input('status');
            $result = DB::select('CALL sproc_UpdateQueryStatus(?, ?)', [$queryId, $status]);
            if (!empty($result)) {
                $response = [
                    'status' => $result[0]->status,
                    'message' => $result[0]->message
                ];
                return response()->json($response);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update query status'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

