<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Certification;
use App\Models\CertificationAcquisition;
use App\Models\Company;
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
        User::create([ 'user_id' => 'j-sakata', 'name' => 'サカタ', 'email' => 'j-sakata@example.com', 'password' => Hash::make('j-sakata'), 'authority' => AuthorityType::Admin->name]);
        Certification::create(['user_id' => 'j-sakata', 'name' => '基本情報技術者試験', 'certification_number' => '1505', 'expiration' => '100', 'memo' => 'レベル2', 'category' => 'NATIONAL', 'sub_category' => 'IT']);
        $certification = Certification::find(1);
        $certification->acquisition()->create(['acquisition_date' => now(), 'score' => 12]);
        Company::create(['user_id' => 'j-sakata', 'name' => 'test Co.', 'entered_at' => now()]);
    }
}
