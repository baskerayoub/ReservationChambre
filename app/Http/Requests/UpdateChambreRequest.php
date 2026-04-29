<?php

namespace App\Http\Requests;

use App\Models\Chambre;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChambreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $chambre = $this->route('chambre');

        return [
            'numero' => ['required', 'string', 'max:20', Rule::unique('chambres', 'numero')->ignore($chambre)],
            'type' => ['required', Rule::in(Chambre::TYPES)],
            'prix' => ['required', 'numeric', 'min:0'],
            'confort' => ['required', Rule::in(Chambre::CONFORTS)],
            'equipements' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:2048'],
            'status' => ['required', Rule::in(Chambre::STATUSES)],
        ];
    }
}
