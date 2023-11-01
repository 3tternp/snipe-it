<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreAssetRequest extends ImageUploadRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // TODO: make sure this works
        return Gate::allows('create', new Asset);
    }

    public function prepareForValidation(): void
    {
        //
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = array_merge(
            (new Asset)->getRules(),
            parent::rules(),
        );

            // unsets unique check here, that check cannot run twice.
            $rules['asset_tags.*'] = $rules['asset_tag'];
            unset($rules['asset_tag']);
            $rules['serials.*'] = $rules['serial'];
            unset($rules['serial']);

        return $rules;
    }
}
