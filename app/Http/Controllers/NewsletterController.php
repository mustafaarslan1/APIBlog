<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Models\Newsletter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends APIController
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(): JsonResponse
    {

        $data = Newsletter::orderBy('created_at', 'desc')->get();

        return $this->success([
            'data' => $data
        ]);
    }

    public function add(): JsonResponse
    {

        $data = $this->request->all();

        if (Newsletter::where('email', $data['email'])->exists()){

            $validator = Validator::make($data, [
                'name' => 'required|string|min:2|max:100',
                'surname' => 'required|string|min:2|max:100',
                'email' => 'required|email:rfc,dns'
            ]);

            if ($validator->fails()){
                return $this->error([
                    'msg' => 'Hatalı alan',
                    'errors' => $validator->errors(),
                ],400);
            }

            $rejoin = Newsletter::where('email', $data['email']);
            $rejoin->update([
                "name" => $data['name'],
                "surname" => $data['surname'],
                "is_active" => "1",
            ]);

            return $this->success([
                'msg' => 'Aboneliğiniz tekrar aktif edilmiştir',
            ]);

        }else{

            $validator = Validator::make($data, [
                'name' => 'required|string|min:2|max:100',
                'surname' => 'required|string|min:2|max:100',
                'email' => 'required|unique:newsletters,email|email:rfc,dns'
            ]);

            if ($validator->fails()){
                return $this->error([
                    'msg' => 'Hatalı alan',
                    'errors' => $validator->errors(),
                ],400);
            }

            $newsletter = new Newsletter();
            $newsletter->name = $data['name'];
            $newsletter->surname = $data['surname'];
            $newsletter->email = $data['email'];
            $newsletter->save();

            return $this->success([
                'data' => $newsletter
            ]);
        }




    }

    public function disable($newsletter_id): JsonResponse
    {

        $disable = Newsletter::find($newsletter_id);
        $disable->update([
            "is_active" => "0",
        ]);

        return $this->success([
            'msg' => "Aboneliğiniz iptal edilmiştir."
        ]);
    }
}
