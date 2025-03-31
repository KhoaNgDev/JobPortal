<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:skills,name,' . $this->route('id'), // Đảm bảo rằng tên là duy nhất và không trùng với bản ghi hiện tại
        ];
    }

    /**
     * Lấy các thông báo lỗi tùy chỉnh.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên kỹ năng là bắt buộc.',
            'name.max' => 'Tên kỹ năng không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên kỹ năng đã tồn tại.',
        ];
    }
}
