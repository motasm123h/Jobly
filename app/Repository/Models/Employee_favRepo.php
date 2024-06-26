<?php

namespace App\Repository\Models;



use App\Models\Employee;
use App\Models\Employee_fav;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Repository\Reapository;
use Illuminate\Support\Facades\Auth;

class Employee_favRepo extends Reapository
{
    use ResponseTrait;
    public function __construct()
    {
        parent::__construct(employee_fav::class);
    }

    public function store($request){
        $Data = [];

        $Data['employee_id'] = Auth::user()->employee->id;
        $Data['jops_section_id'] = $request->job_section_id;
        Employee_fav::create($Data);

        if(!$Data)
            return $this->apiResponse('Failed to create favorite',null,false);

       return $this->apiResponse('success',$Data);

    }

    public function showFav(){
        $employee_id = Auth::user()->employee->id;
        $Data = Employee_fav::where('employee_id',$employee_id)->get();
        return $this->apiResponse('success',$Data);
    }
}
