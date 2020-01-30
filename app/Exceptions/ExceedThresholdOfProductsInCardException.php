<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 14:44
 */

namespace App\Exceptions;


use Throwable;

class ExceedThresholdOfProductsInCardException extends \Exception
{

    public function  __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
