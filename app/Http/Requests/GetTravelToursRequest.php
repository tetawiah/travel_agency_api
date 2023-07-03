<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTravelToursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "startDate" => ['date'],
            "endDate" => ['date'],
            "priceFrom" => ['numeric'],
            "priceTo" => ['numeric'],
            "sortby" => ['string'],
            "sortOrder" => Rule::in(['asc', 'desc']),
            ];
    }

    public  function  messages()
    {
        return ['sortOrder.in' => "The sort order given is invalid ooo"];
    }
}
