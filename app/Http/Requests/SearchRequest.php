<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
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
            'squery' => 'required',
            'artsPerPage' => 'number|nullable',
            'page' => 'number|nullable',
            'inTitle' => 'nullable',
            'source' => 'nullable',
            'domain' => 'nullable',
            'exDomain' => 'nullable',
            'from' => 'date_format:Y-m-d|nullable',
            'to' => 'date_format:Y-m-d|nullable',
            'lang' => ['nullable', Rule::in(config('apis.news_api.languages'))],
            'sortBy' => ['nullable', Rule::in(config('apis.news_api.sorting'))]
        ];
    }

    /**
     * custom error messages
     * 
     * @return array
     */
    public function messages()
    {
        return [
            
        ];
    }
}
