<?php


namespace vloop\user\entities\interfaces;


interface  AccessCredential
{
    public function name(): string;

    /**
     * @return Rules - правила которые прикреплены к данному разрешению.
    */
    public function rules(): Rules ;
}