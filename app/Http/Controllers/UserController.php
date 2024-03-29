<?php
//BTT7C8FC7GT9U5FCNJHGMQ3A
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\WelcomeEmail;
use App\Mail\WelcomeEmailProfessor;
use App\Mail\ForgotPassword;
use DB;
//added comment
class UserController extends Controller
{
    function apiStatus()
    {
        return "API running successfully";
    }

    public function createOrUpdateUser(Request $request)
    {
        $userId = $request->input('userId', -1);
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $dob = $request->input('dob');
        $userType = $request->input('userType');
        $gradDate = $request->input('gradDate');
        $isReleased = $request->input('isReleased');
        $designation = $request->input('designation', '');
        $isDeleted= $request->input('isDeleted',0);

        $result = DB::select('CALL sproc_CreateOrUpdateUser(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)', [
            $userId,
            $firstName,
            $lastName,
            $email,
            $password,
            $phone,
            $dob,
            $userType,
            $gradDate,
            $isReleased,
            $designation,
            $isDeleted
        ]);
        $response=response()->json($result[0]);
        if($result[0]->status=="success"&&$userId==-1&&$userType==1)
        {
            $details=["name"=>$firstName];
            Mail::to($email)->send(new WelcomeEmail($details));
        }
        else if($result[0]->status=="success"&&$userId==-1&&$userType==2){
            $details=["name"=>$firstName,"password"=>$password];
            Mail::to($email)->send(new WelcomeEmailProfessor($details));
        }
        return $response;
    }
    
    public function login(Request $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $result = DB::select('CALL sproc_LoginUser(?, ?)', [$email, $password]);
            $jsonResult=json_decode($result[0]->v_data,true);
            return response()->json($jsonResult);
        } catch (Exception $e) {
            Log::error('Error occurred during login: ' . $e->getMessage());

            return response()->json([
                'Status' => 'error',
                'Message' => 'An error occurred during login.'
            ], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $result = DB::select('CALL sproc_ForgotPassword(?)', [$request->email]);

            $firstName=$result[0]->first_name ?? null;
            $password = $result[0]->password ?? null;
            $status = $result[0]->status ?? null;
            $message = $result[0]->message ?? null;
            if($status=="success")
            {
                $details=["name"=>$firstName,"password"=>$password];
                Mail::to($request->email)->send(new ForgotPassword($details));
                return json_encode(["status"=>"success","Message"=>"Password has been sent to Email"]);
            }
            else{
                return json_encode(["status"=>"failure","Message"=>"Email not registered with us"]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.',
            ], 500);
        }
    }
}
