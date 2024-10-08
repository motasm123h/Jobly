<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\VacancyRequest;
use App\Models\Vacancy;
use App\Models\User;
use App\Models\Jobs_Request;
use App\Repository\Models\VacancyRepo;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    use ResponseTrait;
    private $repo;
    public function __construct()
    {
        $this->repo = new VacancyRepo();
    }

    public function index()
    {
        return $this->repo->index();
    }

    public function s_index($vacancy_id)
    {
        $Vacancy = Vacancy::where('id', '=', $vacancy_id)->with(['user.company', 'location', 'section'])->first();

        return $this->apiResponse('Failed to create user', $Vacancy, true);
    }

    public function getAllJobsForCompany(){
        return $this->repo->getAllJobsForCompany();
    }

    public function getAllJobsForOneCompany($id){
        return $this->repo->getAllJobsForOneCompany($id);

    }

    public function getMyJobs(){
        return $this->repo->getMyJobs();
    }

    public function getAllFreeLanceJobs(){
        return $this->repo->getAllJobsForEmployee();
    }

    public function getJobsByFavorite(){
        return $this->repo->getJobsByFavorite();
    }

    public function getJob($id){
        return $this->repo->getJob($id);
    }

    public function getFilteredVacancies(Request $request){
        return $this->repo->getFilteredVacancies($request);
    }

    public function search(Request $request){
        return $this->repo->search($request);

    }

    public function create(VacancyRequest $request)
    {
        $atter = $request->validated();
        return $this->repo->create($atter);
    }

    public function create_app(VacancyRequest $request){
        return $this->repo->create_app($request);
    }

    public function update(Request $request, int $id)
    {

        $vacancy = Vacancy::where('id', $id)->first();

        $vacancy->update([
            'description' => $request->input('description') ?? $vacancy['description'],
            'image' => $request->input('image') ?? $vacancy['image'],
            'job_type' => $request->input('job_type') ?? $vacancy['job_type'],
            'requirements' => $request->input('requirements') ?? $vacancy['requirements'],
            'salary_range' => $request->input('salary_range') ?? $vacancy['salary_range'],
            'application_deadline' => $request->input('application_deadline') ?? $vacancy['application_deadline'],
            'status' => $request->input('status') ?? $vacancy['status'],
            'jops_section_id' => $request->input('jops_section_id') ?? $vacancy['jops_section_id'],
            'user_id' => $request->input('user_id') ?? $vacancy['user_id'],
        ]);

        $user = User::with(['vacancy.section', 'address', 'company'])->findOrFail(auth()->user()->id);

        $vacancies = $user->vacancy->where('id', $id)->map(function ($vacancy) use ($user) {
            return [
                'company_name' => $user->company->company_name,
    
                'section' => $vacancy->section->section,
                'user_id' => $vacancy->user_id,
                'vacancy_id' => $vacancy->id,
                'description' => $vacancy->description,
                'vacancy_image' => $vacancy->image,
                'job_type' => $vacancy->job_type,
                'status' => $vacancy->status,
                'requirements' => $vacancy->requirements,
                'salary_range' => $vacancy->salary_range,
                'application_deadline' => $vacancy->application_deadline,
            ];
        })->first();

        return response()->json([
            'data' => $vacancies,
        ]);
    }

    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }

    public function applayJobs(int $id)
    {
        $userId = auth()->user()->id;

        $existingRequest = Jobs_Request::where('user_id', $userId)
                                       ->where('vacancy_id', $id)
                                       ->first();

        if ($existingRequest) {
            return $this->apiResponse('You have already applied for this job', null, false);
        }

        $atter['user_id'] = $userId;
        $atter['vacancy_id'] = $id;

        $request = Jobs_Request::create($atter);

        return $this->apiResponse('success', $request);
    }
}
