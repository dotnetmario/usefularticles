<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

use App\Article;
use App\Helper;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!isset($this->comment) || !isset($this->article))
            return false;

        $art = new Article;
        $article = Helper::getRealVariableValue($this->article);

        $type = gettype($article) === "string" ? "permalink" : "id";

        if($art->exists(urldecode($article), $type))
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "comment" => "required",
            "article" => "required"
        ];
    }
}
