<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:99',
            'description' => 'required|string',
            'start_date' => 'required|date:Y-m-d',
            'end_date' => 'required|date:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "Title is required, Please Enter Title",
            "description.required" => "Description is required, Please Enter Description",
            "start_date.required" => "Start Date is required, Please Enter Start Date",
            "end_date.required" => "End Date is required, Please Enter End Date",
            "title.max" => "Max character is 99",
            "title.string" => "Title must be string type!",
            "description.string" => "Description must be string type!",
            "start_date.date" => "Start Date must be Y-m-d format!",
            "end_date.date" => "End Date must be Y-m-d format!",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
