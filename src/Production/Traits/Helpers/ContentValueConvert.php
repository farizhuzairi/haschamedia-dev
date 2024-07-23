<?php

namespace HaschaDev\Production\Traits\Helpers;

use HaschaDev\Enums\DataType;

trait ContentValueConvert
{
    /**
     * data content value
     * 
     */
    public function dataContentValue(string $dataType, string $contentValue): mixed
    {
        $data = (string) $contentValue;
        if($dataType === DataType::ARR->value){
            return json_decode($data, true);
        }
        elseif($dataType === DataType::STR->value){
            return (string) $data;
        }
        elseif($dataType === DataType::BOOL->value){
            $result = null;
            switch ($data) {
                case 'true':
                    $result = true;
                    break;
                case 'false':
                    $result = false;
                    break;
                case '1':
                    $result = true;
                    break;
                case '0':
                    $result = false;
                    break;
                default:
                    throw new \Exception("Error Processing Data: kesalahan tipe data pada content value.");
                    break;
            }
            return (bool) $result;
        }
        elseif($dataType === DataType::INT->value){
            return (int) $data;
        }
        return null;
    }
}