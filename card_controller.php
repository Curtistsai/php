<?php  
namespace App\Exports;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
class CreaitCardController  extends Controller
{
	use AuthorizesRequests,DispatchesJobs,ValidatesRequests;
	public function index()
	{
		return view(credit_card.index);
	}
	public function export()
	{
		return Excel::download(new CreditCardExport,'creditCards.xlsx');
	}
	public function import(Request $request)
	{
		$temPath = $request->all()['file']->store('temp');
		$path = storage_path('app').'/'.$temPath;
		$import = new CreditCardImport;
		Excel::import($import,$path);
		return true;
	}
}
?>