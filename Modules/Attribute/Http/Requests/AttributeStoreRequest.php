<?php

namespace Modules\Attribute\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Modules\Attribute\Entity\Attribute;

class AttributeStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'string|required|min:3|max:50|unique:attributes,code',
            'label' => 'string|required|min:3|max:50|',
            'type' => 'string|required|in:' . implode(',', Attribute::getTypes()),
            'is_filterable' => 'boolean|nullable',
            'is_required' => 'boolean|nullable'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'string' => __('attribute::general.attribute.string'),
            'required' => __('attribute::general.attribute.required'),
            'min' => __('attribute::general.attribute.min'),
            'max' => __('attribute::general.attribute.max'),
            'unique' => __('attribute::general.attribute.unique')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            )
        );
    }
}
