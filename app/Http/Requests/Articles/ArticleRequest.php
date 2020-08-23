<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

use App\Article;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // validation 
        // article has to exist
        $art = new Article;

        if($art->exists($this->article, "permalink"))
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
            
        ];
    }
}
