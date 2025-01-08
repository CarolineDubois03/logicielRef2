<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AdditionalColumn;

class CourierFormRequest extends FormRequest
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
        'object' => ['required', 'string', 'max:255'],
        'nature' => ['required', 'string', 'max:255'],
    ];

    // Récupérer les champs supplémentaires
    
    
    //dd($rules);
    return $rules;
}



}
