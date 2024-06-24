<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\DistanceUnit;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class ApiStoreActivityRequest extends FormRequest
{
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
            'user_id' => 'required|integer|exists:users,id',
            'activity_type_id' => 'required|integer|exists:activity_types,id',
            'activity_date' => 'required|date_format:Y-m-d H:i',
            'name' => 'required|string',
            'distance' => 'required|integer',
            'distance_unit' => [Rule::enum(DistanceUnit::class)->only([DistanceUnit::MILES, DistanceUnit::KILOMETERS, DistanceUnit::METERS])],
            'elapsed_time' => 'required|integer',
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
            'message'   => 'Fields validation errors',
            'data'      => $validator->errors()
        ], 400));
    }

    /**
     * prepareForValidation function
     * 
     * Add user_id field to validation before persisting into DB
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }
    
}
