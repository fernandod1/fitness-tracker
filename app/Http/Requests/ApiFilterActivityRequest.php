<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\DistanceUnit;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Request;

class ApiFilterActivityRequest extends FormRequest
{

    /**
     * validationData method
     * 
     * Inject data parameters from GET url for validation
     * 
     * @return array
     */    
    public function validationData()
    {
        return $this->route()->parameters();
    }

    /**
     * authorize method
     * 
     * Determine if the user is authorized to make this request.
     * 
     * @return true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * rules method
     * 
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'activity_type' => 'required|integer|exists:activity_types,id'
        ];
    }

    /**
     * failedValidation method
     * 
     * Throws HTTP exception with json data details.
     *
     * @return HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Activity type not valid',
            'data'      => $validator->errors()
        ], 400));
    }
    
}
