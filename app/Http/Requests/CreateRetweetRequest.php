<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRetweetRequest extends FormRequest
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
            'url' => [
                'required',
                'regex:/^(?:http(?:s)?:\/\/)?(?:[^\.]+\.)?twitter\.com.*$/',
            ],
        ];
    }

    public function tweet_id(){
        $arr = explode("/", $this->url);
        return end($arr);
    }
}
