<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorAuthenticationMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthenticationControllerOld extends Controller
{
    /*
    
curl -i -X POST `
  https://graph.facebook.com/v17.0/132286483301071/messages `
  -H 'Authorization: Bearer EAAEGnLzm0HQBO4YtuKKJS12aplZAl4vkyuDSJZCqketNmcPj8wfluQFVpOqFZACLTPoNDZBp5LFmtZCVaZCb3oTkHVHlY9C3wAHzY3yh69pXZB2hh3V2or6s71ijzPJV73q3GNfNPK8l1jycM6dGUJpZBMEhilsG3qt3RZAoSG5wT2hX8rOknFES6QeWa7C9OoAR5enBOxOLo5eUxnklGxEsZD' `
  -H 'Content-Type: application/json' `
  -d '{ \"messaging_product\": \"whatsapp\", \"to\": \"201096512673\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }'

    

     */

     /*
     
curl -i -X POST `
  https://graph.facebook.com/v17.0/132286483301071/messages `
  -H 'Authorization: Bearer EAAEGnLzm0HQBO5eZAdWnrvT0neialEFGOqUZB2gXFG2coygftpZBfxglXTWiNfqedG8axBX9zK5EqdOfCPkKYMyZAICGUDeZATZB8DiMVafV1jAFHS' `
  -H 'Content-Type: application/json' `
  -d '{ \"messaging_product\": \"whatsapp\", \"to\": \"967770840891\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }'


     */

/*

curl -i -X POST `
  https://graph.facebook.com/v17.0/148591154993991/messages `
  -H 'Authorization: Bearer EAAWSDZBcqVZBsBO8HvZC2dKumJ3xJJVKS6dxirXe9muoCjdITEaLQIyhoVCzMxNEdZAOtPzTlLTBtfjCQUEYWgKqA9l6HGiICiDTLmHlnuOfiniDYooPW1sQlyXdmam9oOiFnZCenal5n3FMBAcZCfnw7FF0WK75ZC8Vwa6gUSQA1lLvqQ5egevlReaVeLpDmrkIrsql1ZADlmCZBLZBIzercZD' `
  -H 'Content-Type: application/json' `
  -d '{ \"messaging_product\": \"whatsapp\", \"to\": \"967773672171\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }'



*/



    public function sendMessage() 
    {
        $verfiyCode = rand(100000, 999999);
        $phone = '+967770840891';
        $message = "He clinet your code is " . $verfiyCode;

        // echo $message;





        // $params=array(
        // 'token' => '90lx7b23p0rbkigg',
        // 'to' => $phone,
        // 'body' => 'WhatsApp API on UltraMsg.com works good'
        // );
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://graph.facebook.com/v17.0/148591154993991/messages",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        // CURLOPT_SSL_VERIFYHOST => 0,
        // CURLOPT_SSL_VERIFYPEER => 0,
        // CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_POSTFIELDS => '{ 
            "messaging_product" : "whatsapp",
             "to" : "967773672171",
             "type" : "template",
             "template" : { 
                "name" : "hello_world",
                 "language" : {
                     "code" : "en_US"
                     }
                 }
             }',
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer EAAWSDZBcqVZBsBO8HvZC2dKumJ3xJJVKS6dxirXe9muoCjdITEaLQIyhoVCzMxNEdZAOtPzTlLTBtfjCQUEYWgKqA9l6HGiICiDTLmHlnuOfiniDYooPW1sQlyXdmam9oOiFnZCenal5n3FMBAcZCfnw7FF0WK75ZC8Vwa6gUSQA1lLvqQ5egevlReaVeLpDmrkIrsql1ZADlmCZBLZBIzercZD",
            "Content-Type: application/json"
        ),
        ));

        $response = curl_exec($curl);
        echo $response;
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }










        return;
        // $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);

        // $admin = Admin::where('email', $request->email)->first();

        // if ($admin && Hash::check($request->password, $admin->password)) {
        //     $code = rand(100000, 999999);
        //     $admin->two_factor_authentication_code = $code;
        //     $admin->save();

        //     Mail::to($admin->email)->send(new TwoFactorAuthenticationMail($code));

        //     return response(['message' => 'Code sent to email']);
        // }

        // return response(['message' => 'Invalid credentials'], 401);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $code = rand(100000, 999999);
            $admin->two_factor_authentication_code = $code;
            $admin->save();

            Mail::to($admin->email)->send(new TwoFactorAuthenticationMail($code));

            return response(['message' => 'Code sent to email']);
        }

        return response(['message' => 'Invalid credentials'], 401);
    }

    public function verify(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'code' => 'required|string',
        ]);

        $user = Admin::where('email', $request->email)
                    ->where('two_factor_authentication_code', $request->code)
                    ->firstOrFail();

        $token = $user->createToken('AdminToken')->plainTextToken;

        $user->two_factor_authentication_code = null;
        $user->save();

        return response([
            'user' => $user,
            'token' => $token,
            'message' => 'Login Successful'
        ]);
    }
}