<?php

namespace App\Exports;

use App\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendanceExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $query_info;
    protected $full_info;
    	function __construct($full_info,$query_info){
    		$this->full_info = $full_info;
    		$this->query_info = $query_info;
    	}
    public function view(): View
    {
    	return view('print.print_to_excel',[
    		'full_info'=>$this->full_info,
    		'query_info'=>$this->query_info]);
    }

}
