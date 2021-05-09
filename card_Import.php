<?php
namespace App\Exports;

use Illumiate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\Importable;

class CreditCardImport implements ToCollection, WithCustomCsvSettings
{
  use Importable;

  public function __construct()
  {
  	$this->data = collect();
  	$this->header = '';
  	$this->footer = '';
  }

  public function collection(Collection $rows)
  {
  	$rows = $rows->collaspe();
  	$header = $rows->shift();
  	$footer = $rows->pop();
  	$rows = $this->getFormatRows($rows);
  	return true;
  }

  public function getFormatRows(Collection $rows)
  {
  	$data = collect();
  	foreach ($rows as $row)
  	{
  		$row = [
  			'char' => substr($row,0,1),
  			'id' => ltrim(substr($row,1,5),0),
  			'number' => rtrim(substr($row,6,19)),
  			'expiry_date' => substr($row,25,4),
  			'amount' => ltrim(substr($row,29,13),0),
  			'status_code' => substr($row,42,2),
  			'order_id' => rtrim(substr($row,44,15)),
  			'read_id' => substr($row,59,6),
  			'type' => substr($row,65,1),
  			'approve_code' => substr($row,66,6),
  			'last_status_code' => substr($row,72,2),
  			'cvv' => substr($row,74,3),
  			'identity_number' => rtrim(substr($row,77,10)),
  			'blank' => substr($row,87,11),
  			'bps_status_code' => substr($row,98,2),
  			'comment' => rtrim(mb_substr($row,100,19)),
  			'call_bank' => rtrim(substr($row,140,38)),
  		];
  		$data->push(collect($row));
  	}
  	return $data;
  }

  public function getCsvSettings(): array
  {
  	return [
  		'input_encoding' => 'Bigs'
  	];
  }
}
?>