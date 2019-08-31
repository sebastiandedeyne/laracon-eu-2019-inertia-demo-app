<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required',
            'status' => 'required|in:published,draft',
        ];
    }
}
