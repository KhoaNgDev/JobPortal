<?php

namespace App\Services;

use App\Models\Skill;
use App\Models\JobSkills;
use App\Models\CandidateSkill;
use Illuminate\Http\Request;

class SkillService
{
    /**
     * Get all skills with optional search filters.
     */
    public function getAllSkills(array $search = [])
    {
        $query = Skill::query();

        foreach ($search as $column) {
            if ($value = request()->get($column)) {
                $query->orWhere($column, 'like', "%$value%");
            }
        }

        return $query->paginate(20);
    }

    /**
     * Create a new skill.
     */
    public function createSkill(array $data)
    {
        return Skill::create($data);
    }

    /**
     * Update an existing skill.
     */
    public function updateSkill(Skill $skill, array $data)
    {
        return $skill->update($data);
    }

    /**
     * Delete a skill after checking usage in other tables.
     */
    public function deleteSkill(string $id)
    {
        $skillExist = JobSkills::where('skill_id', $id)->exists();
        $candidateSkillExist = CandidateSkill::where('skill_id', $id)->exists();

        if ($skillExist || $candidateSkillExist) {
            return false;
        }

        return Skill::findOrFail($id)->delete();
    }
}
