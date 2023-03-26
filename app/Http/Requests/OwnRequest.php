<?php

namespace App\Http\Requests;

use App\Classes\Nif;
use App\Classes\SelectOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class OwnRequest extends FormRequest
{
   /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
   public function authorize()
   {
      return true;
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
   public function rules()
   {

      $maxSex = count(SelectOptions::$SEX_VALUES);
      $maxState = count(SelectOptions::$STATE_VALUES);

      return [
         'name' => 'required',
         'backname' => 'required',
         'nif' => 'required|regex:/([0-9]{8}[A-Za-z])/u',
         'sex' => 'required|numeric|min:0|max:'.$maxSex,
         'state' => 'required|numeric|min:0|max:'.$maxState
      ];
   }

   public function messages()
   {
      return [
         'nif.required' => 'Camp obligatori.',
      ];
   }

   public function withValidator(Validator $validator)
   {
      $nif = $validator->getData()['nif'] ?? '';
      $validator->after(
         function ($validator) use ($nif) {
            if (!Nif::isValid($nif)) {
               $validator->errors()->add(
                  'nif',
                  'El NIF és incorrecte.'
               );
            }else if(Nif::exists($nif, "dataUser", "local")){
               $validator->errors()->add(
                  'nif',
                  'El NIF ja está registrat.'
               );
            }
         }
      );
   }
}
