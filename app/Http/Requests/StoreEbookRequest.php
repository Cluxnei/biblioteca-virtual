<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEbookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'year' => 'required|numeric|min:1|max:' . ((int)date('Y') + 2),
            'description' => 'required|string|min:2|max:65530',
            'cover_file' => 'required|image',
            'pdf_file' => 'required|file',
            'categories' => 'required|array',
            'authors' => 'required|array',
            'genres' => 'required|array',
        ];
    }
}
