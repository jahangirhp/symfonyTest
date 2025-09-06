<?php

namespace App\Service;

use App\DTO\ValidationDTO;

class BankAccount
{
  private
  function validateIBAN($iban):bool
    {
        $iban = str_replace(' ', '', strtoupper($iban));

        $countryCode = substr($iban, 0, 2);
        $checkDigits = substr($iban, 2, 2);
        $bankCode = substr($iban, 4, 4);
        $accountNumber = substr($iban, 8);

        $ibanCheck = $checkDigits . $bankCode . $accountNumber . $countryCode;
        $ibanCheck = str_replace(
            range('A', 'Z'),
            range(10, 35),
            $ibanCheck
        );

        $checksum = intval(substr($ibanCheck, 0, 1));
        for ($i = 1; $i < strlen($ibanCheck); $i++) {
            $checksum *= 10;
            $checksum += intval(substr($ibanCheck, $i, 1));
            $checksum %= 97;
        }

        return ($checksum === 1);
    }

    public function IBANValidation($IBAN): ValidationDTO
    {

        $res=new ValidationDTO();
       $isValid= $this->validateIBAN($IBAN);

       if($isValid)
       {
        $res->success=true;
        $res->message="That is Cool";
       }
       else
       {
           $res->message="Wrong IBAN";
       }
       return $res;
    }

}
