<?php

namespace App\Exports;

// use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;

class UsersExport implements FromArray
{
    // public function collection()
    // {
    //     // return User::all();
    //     // return $data;
    // }
    protected $dataInformation;

    public function __construct(array $data)
    {
        $this->dataInformation = $data;
    }

    public function array(): array
    {
        return $this->dataInformation;
    }
    // public function data($data){
    //     // dd($data);
    //     return $data;
    // }
}
