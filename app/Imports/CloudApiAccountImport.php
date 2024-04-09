<?php

namespace App\Imports;

use App\CloudApiAccount;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;




class CloudApiAccountImport implements ToCollection, WithValidation, WithStartRow
{
    private $numRows = 0;
    private $ids = array();

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $test = CloudApiAccount::create([
                'company_name' => $row[0],
                'address' => $row[1],
                'city' => $row[2],
                'country' => $row[3],
                'zip_code' => $row[4],
                'contact_name' => $row[5],
                'email' => $row[6],
                'phone' => $row[7],
            ]);
            //dd($test);
            ++$this->numRows;
            array_push($this->ids, $test->id);
        }
    }
    public function rules(): array
    {
        return [
            '0' => 'required|max:150',
            '1' => 'required|max:150',
            '2' => 'required|max:50',
            '3' => 'required|max:50',
            '4' => 'required|max:10',
            '5' => 'required|max:150',
            '6' => 'required|max:200',
            '7' => 'required|max:30',
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
    public function getInsertedId(): array
    {
        return $this->ids;
    }
    public function startRow(): int
    {
        return 2;
    }

}
