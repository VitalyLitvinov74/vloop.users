<?php


namespace vloop\users\entities\interfaces;


interface  AccessCredential
{
    public function name(): string;

    /**
     * @return Rules - правила которые прикреплены к данному разрешению.
    */
    public function rules(): Rules ;
}