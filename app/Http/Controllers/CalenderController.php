<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CalenderController extends Controller
{
    public function getReminders($userId)
    {
        try {
            
            // Call the stored procedure using raw SQL query
            $reminders = DB::select('CALL sproc_GetRemindersByUserId(?)', [$userId]);
            // Check if there are reminders
            if (count($reminders) > 0) {
                // If reminders exist, return them as JSON response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Reminders retrieved successfully',
                    'data' => $reminders,
                ]);
            } else {
                // If no reminders found, return empty response
                return response()->json([
                    'status' => 'failure',
                    'message' => 'No reminders found for the specified user',
                    'data' => [],
                ]);
            }
        } catch (QueryException $e) {
            // If an exception occurs during database query execution
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage(),
                'data' => [],
            ]);
        } catch (\Exception $e) {
            // If any other type of exception occurs
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => [],
            ]);
        }
    }

    public function createReminder(Request $request)
    {
        try {
            // Extract data from the request
            $userId = $request->input('user_id');
            $reminderDate = $request->input('reminder_date');
            $reminder = $request->input('reminder');

            // Call the stored procedure to create a reminder
            $response= DB::select('CALL sproc_CreateReminder(?, ?, ?)', [
                $userId,
                $reminderDate,
                $reminder
            ]);
            if(empty($response))
            {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Something went wrong, try again'
                ]);
            }
            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Reminder created successfully'
            ]);
        } catch (QueryException $e) {
            // If a database error occurs
            return response()->json([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // If any other type of exception occurs
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
