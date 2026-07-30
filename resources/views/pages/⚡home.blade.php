<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Technology;
use App\Models\Project;
use Livewire\Attributes\Computed;

//new class extends Component

new #[Layout('layouts::site'), Title('Főoldal - PeterDev')] class extends Component {
    /*public function render()
    {
        return $this->view([
            'technology' => Technology::all(),
            'projects' => Project::with('categories')->get(),
        ]);
    }*/

    #[Computed]
    public function pageDatas()
    {
        return [
            'technology' => Technology::all(),
            'projects' => Project::with('categories')->get(),
        ];
    }
};

?>

<main class="pt-24">

    <!-- 01. HOME / HERO SZEKCIÓ -->
    <x-sections.hero/>

    <!-- 02. RÓLAM / BUSINESS LOGIC -->
    <x-sections.about-me/>

    <!-- 03. STACK SZEKCIÓ -->
    <x-sections.stack :technology="$this->pageDatas['technology']"/>

    <!-- 04. PROJECTS SZEKCIÓ -->
    <x-sections.projects :projects="$this->pageDatas['projects']"/>

    <!-- 05. CONTACT SZEKCIÓ -->
    <livewire:sections.contact-form />

</main>
          