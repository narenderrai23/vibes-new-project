<?php

namespace Modules\Center\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCenterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'        => ['required', 'string', 'max:20', 'unique:centers,code'],
            'name'        => ['required', 'string', 'max:255'],
            'mobile'      => ['required', 'string', 'max:15'],
            'mobile_alt'  => ['nullable', 'string', 'max:15'],
            'email'       => ['nullable', 'email', 'max:255'],
            'address'     => ['nullable', 'string', 'max:500'],
            'google_link' => ['nullable', 'url', 'max:500'],
            'city'        => ['nullable', 'string', 'max:100'],
            'gst_no'      => ['nullable', 'string', 'max:15'],
            'state_id'    => ['required', 'integer', 'exists:states,id'],
            'regional_id' => ['nullable', 'integer', 'exists:regionals,id'],
            'status'      => ['required', 'integer', 'in:0,1,2'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Center code is required.',
            'code.unique'   => 'This center code is already taken.',
            'name.required' => 'Center name is required.',
            'mobile.required' => 'Mobile number is required.',
            'state_id.required' => 'State is required.',
            'status.required' => 'Status is required.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->code) {
            $this->merge(['code' => strtoupper(trim($this->code))]);
        }
        if ($this->gst_no) {
            $this->merge(['gst_no' => strtoupper(trim($this->gst_no))]);
        }
    }
}
