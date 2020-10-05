<?php

namespace App\Exports;

use App\Transaction;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Transaction::all();
    // }

    protected $transaction;
    protected $month;
    protected $year;
  
    //KITA MEMINTA DATA TRANSAKSI, DATA BULAN DAN TAHUN YANG DI REQUEST
    public function __construct($transaction, $month, $year)
    {
        $this->transaction = $transaction;
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        //LOAD VIEW transaction.blade.php DAN PASSING DATA YANG DIMINTA DIATAS
        return view('exports.transactions', [
            'transaction' => $this->transaction,
            'month' => $this->month,
            'year' => $this->year
        ]);
    }
}
