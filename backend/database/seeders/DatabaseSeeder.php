<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Certification;
use App\Models\Company;
use App\Models\Experience;
use Illuminate\Support\Facades\Hash;
use App\Models\Type\AuthorityType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([ 'user_id' => 'j-sakata', 'name' => 'サカタ', 'email' => 'j-sakata@example.com', 'password' => Hash::make('j-sakata'), 'authority' => AuthorityType::Admin->name, 'created_id' => 'j-sakata', 'updated_id' => 'j-sakata']);

        Certification::create(['user_id' => 'j-sakata', 'certification_name' => '基本情報技術者試験', 'certification_code' => '1505', 'certification_memo' => 'レベル2', 'certification_category' => 1, 'certification_sub_category' => 1]);
        $certification = Certification::find(1);
        $certification->acquisition()->create(['acquisition_date' => now(), 'score' => 12]);

        Experience::create(['user_id' => 'j-sakata', 'company_name' => 'test Co.']);
        Experience::create(['user_id' => 'j-sakata', 'company_name' => 'test2 Co.']);
        $experience1 = Experience::find(1);
        $experience1->experience_summary()->create(['title' => '100字', 'status' => 0, 'summary' => 'test1']);
        $experience1->experience_summary()->create(['title' => '200字', 'status' => 1, 'summary' => 'test1']);
        $experience1->knowledge_summary()->create(['knowledge' => 'test1', 'category' => 1]);
        $experience1->knowledge_summary()->create(['knowledge' => 'test2', 'category' => 2]);
        $experience1->experience_content()->create(['started_at' => now(), 'ended_at' => now(), 'industry' => '〇〇業界', 'project_name' => '〇〇システム', 'project_summary' => 'test', 'phase' => 'test', 'description' => 'test', 'achievement' => 'test', 'member_count' => 5, 'position' => 'test', 'company_name' => 'test', 'contract_type' => 1]);
        $experience1->technical_skill()->create(['skill_id' => 1]);
        $experience1->technical_skill()->create(['skill_id' => 2]);

        $experience2 = Experience::latest('id')->first();
        $experience2->experience_summary()->create(['title' => '100字', 'status' => 0, 'summary' => 'test1']);
        $experience2->knowledge_summary()->create(['knowledge' => 'test1', 'category' => 3]);
        $experience2->experience_content()->create(['started_at' => now(), 'ended_at' => now(), 'industry' => '〇〇業界3', 'project_name' => '〇〇システム3', 'project_summary' => 'test', 'phase' => 'test', 'description' => 'test', 'achievement' => 'test', 'member_count' => 5, 'position' => 'test', 'company_name' => 'test3', 'contract_type' => 3]);
        $experience2->technical_skill()->create(['skill_id' => 1]);
        $experience2->technical_skill()->create(['skill_id' => 20]);
        $experience2->technical_skill()->create(['skill_id' => 40]);
        $experience2->technical_skill()->create(['skill_id' => 56]);
        $experience2->technical_skill()->create(['skill_id' => 63]);

        Company::create(['user_id' => 'j-sakata', 'name' => 'test Co.', 'entered_at' => now()]);
    }
}
