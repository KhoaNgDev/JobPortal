<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Models\Skill;
use App\Services\SkillService;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    use Searchable; 

    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->middleware(['permission:job attributes']);
        $this->skillService = $skillService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $query = Skill::query();
        $this->search($query, ['name']); 
        $skills = $query->paginate(20);

        return view('admin.skill.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.skill.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkillRequest $request): RedirectResponse
    {
        $this->skillService->createSkill($request->validated());

        Notify::createdNotification();

        return to_route('admin.skills.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $skill = Skill::findOrFail($id);
        return view('admin.skill.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkillRequest $request, string $id): RedirectResponse
    {
        $skill = Skill::findOrFail($id);

        $this->skillService->updateSkill($skill, $request->validated());

        Notify::updatedNotification();

        return to_route('admin.skills.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->skillService->deleteSkill($id);

        if (!$result) {
            return response(['message' => 'This item is already been used, can\'t delete!'], 500);
        }

        Notify::deletedNotification();

        return response(['message' => 'success'], 200);
    }
}
