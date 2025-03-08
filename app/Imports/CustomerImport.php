<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerImport implements ToModel, WithValidation, WithHeadingRow
{
    public function model(array $row)
    {
        return Customer::updateOrCreate(
            [
                'email' => $row['email'], 
                'phone_number' => $row['phone'] ?? null
            ], 
            [
                'name' => $row['customer_name'],
                'customer_id' => $this->generateUniqueUserId($row['email']),
                'password' => Hash::make($this->generateRandomPassword()),
            ]
        );
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'email', 
                Rule::unique('customers', 'email')->ignore(request()->id) 
            ],
            'phone' => [
                'nullable', 
                'regex:/^[0-9]{10,15}$/',
                Rule::unique('customers', 'phone_number')->ignore(request()->id)
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'customer_name.required' => 'The customer name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'The email ":input" is already taken.',
            'phone.regex' => 'The phone number must be between 10 to 15 digits.',
            'phone.unique' => 'The phone number ":input" is already taken.',
        ];
    }

    private function generateUniqueUserId($email){
        $userId = strtoupper(Str::random(6)) . substr($email, 0, 4);
        do {
            $userId = strtoupper(Str::random(6)) . substr($email, 0, 4);
        } while (Customer::where('customer_id', $userId)->exists());

        return $userId;
    }

    private function generateRandomPassword()
    {
        return Str::random(8);
    }
}
