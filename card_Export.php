<?php

namespace App\Exports;

use Illumiate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CreditCardsExport implements FromCollection,WithTitle,WithHeadings,WithColumnFormatting
{
	public function collection()
	{
		$data = array([
			"amount" => 1000,
			"pid"    => "Q12345"],
			[
				"amount" => 2000,
				"pid"    => "Q12346",
				"id" 	 => "B12345678"
			],);
		$result = collect();
		foreach ($data as $item) {
			$result->push([
				'MERCH_ID'    => '000100010100916',
				'CARD_NO'     => null,
				'EXPIRE_DATE' => null,
				'TXN_AMT'     => intval($item['amount']),
				'PID'         => $item['pid'],
				'TXN_TYPE'    => null,
				'CVV'		  => null,
				'ID'		  => $item['id'],
				'BILL_DESC'   => null,
				'CALL_BANK'   => null,
			]);
		}
		return $result;
	}

	public function headings(): array
	{
		return [
			'MERCH_ID','CARD_NO','EXPIRE_DATE','TXN_AMT','PID','TXN_TYPE','CVV','ID','BILL_DESC','CALL_BANK',
		];
	}

	public function columnFormats(): array
	{
		return [
			'A' => '@',
			'B' => '@',
			'C' => '@',
			'D' => '@',
			'E' => '@',
			'F' => '@',
			'G' => '@',
			'H' => '@',
			'I' => '@',
			'J' => '@',
		];
	}

	public function title(): string
	{
		return 'UBBPS';
	}
}
?>