<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laravel = Category::create([
            'name' => 'Laravel + Livewire',
        ]);

        $egeszsegugy = Category::create([
            'name' => 'Egészségügyi Szektor',
        ]);

        $oktatas = Category::create([
            'name' => 'Oktatás',
        ]);

        $tailWind = Category::create([
            'name' => 'TailwindCSS',
        ]);

        $interaktivUi = Category::create([
            'name' => 'Interaktív UI'
        ]);

        $radiologusProject = Project::create([
            'title' => 'Radiológus Magánrendelő Weboldal',
            'description' => 'Teljesen egyedi felépítésű orvosi bemutató oldal integrált funkciókkal, magánrendelési fókusszal, optimalizált betöltési sebességgel és letisztult, prémium megjelenéssel.',
            'status' => 'ÉLESÍTVE & AKTÍV',
            'url' => 'https://ultrahangeger.hu',
        ]);

        $portfolioProject = Project::create([
            'title' => 'Modern Rendszerközpontú Portfólió',
            'description' => ' A jelenleg is látható, nem szokványos, terminál-ihlette felület, amely reszponzív módon, fluid rácselrendezéssel és egyedi komponensekkel mutatja be a mérnöki szemléletet.',
            'status' => 'ÉLESÍTVE & AKTÍV',
            'url' => 'https://peterdev.hu',
        ]);

        $radiologusProject->categories()->attach([
            $laravel->id,
            $egeszsegugy->id,
            $tailWind->id,
        ]);

        $portfolioProject->categories()->attach([
            $laravel->id,
            $tailWind->id,
        ]);
    }
}
