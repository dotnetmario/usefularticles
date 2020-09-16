<?php

namespace App\Http\Requests\Replies;

use Illuminate\Foundation\Http\FormRequest;
use App\Comment;

class ReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!isset($this->comment) || !isset($this->reply))
            return false;

        if(!(new Comment)->exists($this->comment))
            return false;

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
            "comment" => "required|numeric",
            "reply" => "required"
        ];
    }
}
