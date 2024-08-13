<?php

namespace Developerawam\GenerateMigration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenerateMigrationRequest extends FormRequest
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
        $rules = [
            'table_name' => 'required|string|max:255', // Adjust based on your needs

            'name' => 'required|array',
            'name.*' => 'required|string|max:255', // Adjust based on your needs

            'type' => 'required|array',
            'type.*' => 'required|string|in:string,text,integer,decimal,float,date,time,timestamp,boolean,enum,json', // Adjust based on valid types
        ];

        // Add conditional rules
        foreach ($this->input('type', []) as $index => $type) {
            if ($type === 'enum') {
                $rules["values.$index"] = 'required|string|regex:/^[^ \s]+(?:,[^ \s]+)*$/'; // Must be required, string, no spaces, only commas allowed
                $rules["default.$index"] = 'required|string|regex:/^[^ ]*$/'; // Must be required, string, no spaces
            } else {
                $rules['values'] = 'required|array';
                $rules['values.*'] = 'nullable|string|regex:/^[^ \s]+(?:,[^ \s]+)*$/'; // Adjusted for format

                $rules['default'] = 'required|array';
                $rules['default.*'] = 'nullable|string|regex:/^[^ ]+$/'; // Adjusted for format
            }
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'table_name.required' => 'The Table Name field is required.',
            'name.required' => 'The name field is required.',
            'name.*.required' => 'Each name is required.',
            'type.required' => 'The type field is required.',
            'type.*.required' => 'Each type is required.',
            'type.*.in' => 'Each type must be one of the allowed values.',
            'values.required' => 'The values field is required when type is enum.',
            'values.*.required' => 'Each value is required when type is enum.',
            'values.*.regex' => 'Each value must not contain spaces and can only contain commas.',
            'default.required' => 'The default field is required when type is enum.',
            'default.*.required' => 'Each default is required when type is enum.',
            'default.*.regex' => 'Each default must not contain spaces.',
        ];
    }
}
