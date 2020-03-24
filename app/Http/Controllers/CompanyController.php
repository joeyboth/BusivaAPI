<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function rules()
    {
        return [
            'company_name' => 'required|string|max:100',
            'coc' => 'required|string|max:50',
            'street' => 'required|string|max:150',
            'nr' => 'required|numeric|min:1',
            'zipcode' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'phone' => 'required|numeric|min:11'
        ];
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            return Company::where('user_id',Auth::id())->get();
        } 
    }

    public function show(Request $request, Company $company)
    {
        if(Auth::id() == $company->user_id){
            return $company;
        }
    }

    public function store(Request $request)
    {
        if(Auth::check())
        {
            $validationData = Validator::make($request->all(), $this->rules());
            if ($validationData->fails()){
                return response(['errors'=>$validationData->errors()], 401);
            }

            $data['user_id'] = Auth::id();
            $data['company_name'] = $request->company_name;
            $data['coc'] = $request->coc;
            $data['street'] = $request->street;
            $data['nr'] = $request->nr;
            $data['zipcode'] = $request->zipcode;
            $data['province'] = $request->province;
            $data['country'] = $request->country;
            $data['phone'] = $request->phone;

            $company = Company::create($data);

            return response()->json($company, 201);
        }
        else
        {
            return  response(null, 401);
        }
    }

    public function update(Request $request, Company $company)
    {
        if(Auth::check()){
            if(Auth::id() == $company->user_id){
                $validationData = Validator::make($request->all(), $this->rules());
                if ($validationData->fails()){
                    return response(['errors'=>$validationData->errors()], 401);
                }

                $data['company_name'] = $request->company_name;
                $data['coc'] = $request->coc;
                $data['street'] = $request->street;
                $data['nr'] = $request->nr;
                $data['zipcode'] = $request->zipcode;
                $data['province'] = $request->province;
                $data['country'] = $request->country;
                $data['phone'] = $request->phone;

                $companyData = Company::where(["user_id" => Auth::id()])->where(["id" => $company->id])->update($data);
    
                return response()->json($companyData, 200);
            }
        }   
    }

    public function delete($id)
    {
        if(Auth::check()){
            $company = Company::find($id);
            if(Auth::id() == $company->user_id){
                $company->delete();
                return response()->json(null, 204);
            }
        }
    }
}
