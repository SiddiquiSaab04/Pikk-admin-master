<?php

namespace Modules\Media\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MediaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(Request $request): array
    {
        return [
            "name" => "required",
            'cloud' => 'in:on,null',
            'images' => $request->input('oldImages') ? 'nullable|array' : 'required|array',
            'images.*' => $request->input('oldImages') ? '' : 'image',
        ];
        
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'cloud.in' => 'The selected cloud field is invalid.',
            'images.required' => 'The images field is required.',
            'images.array' => 'The images field must be an array.',
            'images.*' => 'The images field is required.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
