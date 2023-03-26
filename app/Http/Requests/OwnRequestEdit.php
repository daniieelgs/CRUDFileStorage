<?php

namespace App\Http\Requests;

use App\Classes\Nif;
use App\Classes\SelectOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class OwnRequestEdit extends FormRequest
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
         'state' => 'required|numeric|min:0|max:'.$maxState,
         'user' => 'required'
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
      $nif = strtoupper($validator->getData()['nif'] ?? '');
      $user = strtoupper($validator->getData()['user'] ?? '');
      $validator->after(
        function ($validator) use ($user){
            if (!Nif::isValid($user)) {
                $validator->errors()->add(
                    'user',
                    'El usuari és incorrecte.'
                );
            }
        }
      );
      $validator->after(
         function ($validator) use ($nif, $user) {
            if (!Nif::isValid($nif)) {
               $validator->errors()->add(
                  'nif',
                  'El NIF és incorrecte.'
               );
            }else if($user != $nif && Nif::exists($nif, "dataUser", "local")){
               $validator->errors()->add(
                  'nif',
                  'El NIF ja está registrat.'
               );
            }
         }
      );
   }
}
