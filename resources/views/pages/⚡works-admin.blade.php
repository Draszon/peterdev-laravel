<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Models\Project;
use Livewire\Attributes\Validate;

new #[Title('Projects')] class extends Component
{
    public ?Project $project = null;
    public ?int $editingProjectId = null;

    #[Validate('required', message: 'Add meg a projekt címét!')]
    public $title = '';

    #[Validate('required', message: 'Add meg a projekt leírását!')]
    public $description = '';

    #[Validate('required', message: 'Add meg a projekt linkjét!')]
    public $url = '';

    #[Validate('required', message: 'Add meg a projekt státuszát!')]
    public $status = '';

    public bool $isEditing = false;

    #[Computed]
    public function projects()
    {
        return Project::with('categories')->get();
    }

    public function getUpdate(Project $updateProject)
    {
        $this->project = $updateProject;
        $this->editingProjectId = $updateProject->id;

        $this->title = $updateProject->title;
        $this->description = $updateProject->description;
        $this->url = $updateProject->url;
        $this->status = $updateProject->status;
    }

    public function save()
    {
        $this->validate();

        Project::create($this->only(['title', 'description', 'url', 'status']));
        $this->reset();
        session()->flash('status', 'Sikeres feltöltés!');
    }

    public function update()
    {
        $this->validate();

        $this->project->update($this->only(['title', 'description', 'url', 'status']));
        $this->reset();
        session()->flash('status', 'Sikeres frissítés');
    }

    public function cancel()
    {
        $this->project = null;
        $this->editingProjectId = null;
        $this->reset();
    }

    public function delete(Project $project)
    {
        $project->delete();
        $this->reset();
    }
};
?>

<div class="max-w-5xl mx-auto p-3 sm:p-6 space-y-6 sm:space-y-10 font-sans text-slate-800">

    <!-- ==================== PROJEKTEK KEZELÉSE ==================== -->
    <section class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 space-y-8">
        
        <!-- Fejléc -->
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Projektek Kezelése</h2>
            <p class="text-xs sm:text-sm text-slate-500">Új projektek hozzáadása, meglévők szerkesztése és törlése</p>
        </div>

        <!-- 1. ÚJ PROJEKT HOZZÁADÁSA (Űrlap a lista felett) -->
        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 sm:p-6 space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Új Projekt Hozzáadása</span>
                @if (session('status'))
                    <span>{{ session('status') }}</span>
                @endif
            </h3>

            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Title -->
                    <div>
                        <label for="new_title" class="block text-xs font-medium text-slate-700 mb-1">Cím (Title)</label>
                        <input wire:model="title" type="text" id="new_title" name="title" placeholder="Pl. E-commerce Webshop" class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        @error('title')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div>
                        <label for="new_url" class="block text-xs font-medium text-slate-700 mb-1">Projekt URL</label>
                        <input wire:model="url" type="url" id="new_url" name="url" placeholder="https://example.com" class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        @error('url')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="new_status" class="block text-xs font-medium text-slate-700 mb-1">Státusz (Status)</label>
                        <input wire:model="status" type="text" id="new_url" name="url" placeholder="éles & aktív" class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="new_description" class="block text-xs font-medium text-slate-700 mb-1">Leírás (Description)</label>
                    <textarea wire:model="description" id="new_description" name="description" rows="3" placeholder="Projekt részletes leírása..." class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"></textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mentés Gomb -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="cursor-pointer w-full sm:w-auto px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Projekt Létrehozása</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. PROJEKTEK LISTÁJA ÉS SZERKESZTÉSE -->
        <div class="space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-slate-900">Meglévő Projektek</h3>
            @if (session('status'))
                {{ session('status') }}
            @endif

            <div class="divide-y divide-slate-100 border border-slate-200 rounded-lg overflow-hidden">
                
                @foreach ($this->projects as $project)
                    <div class="p-3.5 sm:p-4 bg-slate-50/50 transition-colors">

                        <!-- Lista Sor (Alapadatok + Gombok) -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3">
                                <span class="text-xs font-mono font-bold text-slate-400">#{{ $project->id }}</span>
                                <span class="font-semibold text-slate-900 text-sm sm:text-base">{{ $project->title }}</span>
                            </div>

                            <div class="flex items-center gap-2 pt-2 sm:pt-0 border-t border-slate-100 sm:border-0 justify-end">
                                @if ($this->editingProjectId === $project->id)
                                    <!-- MÉGSE GOMB (szerkesztési módban) -->
                                    <button 
                                        wire:click="cancel" 
                                        type="button" 
                                        class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-md shadow-sm transition-colors flex items-center gap-1"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span>Mégse</span>
                                    </button>
                                @else
                                    <!-- SZERKESZTÉS GOMB (alapértelmezett módban) -->
                                    <button 
                                        wire:click="getUpdate({{ $project->id }})" 
                                        type="button" 
                                        class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-md shadow-sm transition-colors flex items-center gap-1"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span>Szerkesztés</span>
                                    </button>
                                @endif
                                <button wire:click="delete({{ $project }})" type="button" class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-md border border-rose-200/60 transition-colors flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Törlés</span>
                                </button>
                            </div>
                        </div>

                        <!-- Szerkesztő Felület (A szerkesztés gombra nyílik le) -->
                        @if ($this->editingProjectId === $project->id)
                        <form wire:submit="update" class="mt-4 pt-4 border-t border-slate-200/80 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Title Edit -->
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Cím (Title)</label>
                                    <input wire:model="title" type="text" name="title" value="Portfolio Weboldal" class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    @error('title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- URL Edit -->
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Projekt URL</label>
                                    <input wire:model="url" type="url" name="url" value="https://myportfolio.com" class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    @error('url')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status Edit -->
                                <div>
                                    <label class="block text-xs font-medium text-slate-700 mb-1">Státusz (Status)</label>
                                    <input wire:model="status" type="text" name="category" value="éles & aktív" class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                    @error('status')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description Edit -->
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Leírás (Description)</label>
                                <textarea wire:model="description" name="description" rows="3" class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">Modern, reszponzív személyes portfolio oldal Tailwind CSS és JS használatával.</textarea>
                                @error('description')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Frissítés Gomb -->
                            <div class="flex justify-end pt-1">
                                <button type="submit" class="cursor-pointer w-full sm:w-auto px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md shadow-sm transition-colors flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <span>Frissítés</span>
                                </button>
                            </div>
                        </form>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </section>
</div>