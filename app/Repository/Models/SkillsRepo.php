<?php

namespace App\Repository\Models;

use App\Models\Employee;
use App\Repository\Reapository;
use App\Models\Skill;
use App\Traits\ResponseTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class SkillsRepo extends Reapository
{
    use UploadTrait;
    use ResponseTrait;
    public function __construct()
    {
        parent::__construct(Skill::class);
    }

    public function store($request){
        $Data = [];

        $Data['employee_id'] = Employee::where('user_id', Auth::id())->first()->id;
        if ($request->has('skills'))
            $Data['skills'] = $request->skills;

        if ($request->has('cv')){
            $file = $request->file('cv');
            $name = \Str::slug($request->input('name'));
            $filename = time() . '-' .$name.  '.' . $file->getClientOriginalExtension();

            $Data['cv'] = $filename;

            $this->UploadPDF($request,'cv','CVs','upload_file',$filename);

        }


        $skill = Skill::create($Data);

        if (!$skill)
            return $this->apiResponse('Failed to create Skill',null,false);

        return $this->apiResponse('Skill created successfully',$skill);


    }

    public function showSkill(){
        $employee_id = Employee::where('user_id', Auth::id())->first()->id;
        $skill = Skill::find($employee_id);
        return $this->apiResponse('success',$skill);
    }


}
