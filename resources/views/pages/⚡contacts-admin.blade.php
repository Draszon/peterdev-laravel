<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Contact;
use Livewire\Attributes\Validate;

new class extends Component
{
    public ?Contact $contact = null;

    #[Validate('required', message: 'Meg kell adni a kapcsolat nevét!')]
    public $contact_name = '';

    #[Validate('required', message: 'Meg kell adni egy linket!')]
    public $contact_link = '';

    #[Computed]
    public function getData()
    {
        return [
            'contacts' => Contact::all(),
        ];
    }

    //Ha a szerkesztés gomb lett kiválasztva, akkor frissíti az adott rekordot,
    //ha nincs ilyen rekord, akkor pedig létrehoz egy újat
    public function save()
    {
        $this->validate();

        if($this->contact) {
            $this->contact->update($this->only(['contact_name', 'contact_link']));
            session()->flash('status', 'Sikeres frissítés!');
        } else {
            Contact::create($this->only(['contact_name', 'contact_link']));
            session()->flash('status', 'Sikeres feltöltés!');
        }

        $this->reset();
    }

    //kiválasztott kontakt törlése
    public function delete(Contact $contact)
    {
        $contact->delete();
        $this->reset();
    }

    //kiválasztott kontakt betöltése a formba
    public function selectedData(Contact $contact)
    {
        $this->contact = $contact;

        $this->contact_name = $contact->contact_name;
        $this->contact_link = $contact->contact_link;
    }

    //form ürítése
    public function cancel()
    {
        $this->reset();
    }
};
?>

<div class="max-w-5xl mx-auto p-3 sm:p-6 space-y-6 sm:space-y-10 font-sans text-slate-800">

    <!-- ==================== KAPCSOLATOK KEZELÉSE ==================== -->
    <section class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 space-y-8">
        
        <!-- Fejléc -->
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Kapcsolatok Kezelése</h2>
            <p class="text-xs sm:text-sm text-slate-500">Új elérhetőségek és közösségi linkek hozzáadása, módosítása vagy törlése</p>
        </div>

        <!-- 1. ÚJ KAPCSOLAT HOZZÁADÁSA -->
        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 sm:p-6 space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>{{ $this->contact ? 'Kiválasztott kapcsolat szerkesztése' : 'Új kapcsolat hozzáadása' }}</span>
            </h3>

            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Contact Name -->
                    <div>
                        <label for="new_contact_name" class="block text-xs font-medium text-slate-700 mb-1">Kapcsolat megnevezése (Contact Name)</label>
                        <input wire:model="contact_name" type="text" id="new_contact_name" name="contact_name" placeholder="Pl. LinkedIn, GitHub, Email..." class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        @error('contact_name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Contact Link -->
                    <div>
                        <label for="new_contact_link" class="block text-xs font-medium text-slate-700 mb-1">Hivatkozás / Érték (Contact Link)</label>
                        <input wire:model="contact_link" type="text" id="new_contact_link" name="contact_link" placeholder="https://linkedin.com/in/... vagy mailto:..." class="w-full text-sm px-3 py-2 bg-white border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        @error('contact_link') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Mentés és mégsem Gomb -->
                <div class="flex flex-col gap-3 justify-end pt-2 sm:flex-row">
                    @if ($this->contact)
                        <button
                            type="button"
                            class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-md border border-rose-200/60 transition-colors flex items-center gap-1"
                            wire:click="cancel"
                        >
                            <span>Mégsem</span>
                        </button>
                    @endif
                    

                    <button type="submit" class="cursor-pointer w-full sm:w-auto px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>{{ $this->contact ? 'Frissítés' : 'Feltöltés' }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. KAPCSOLATOK LISTÁJA -->
        <div class="space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-slate-900">Meglévő Kapcsolatok</h3>

            <div class="divide-y divide-slate-100 border border-slate-200 rounded-lg overflow-hidden">
                
                @foreach ($this->getData['contacts'] as $contact)
                    <div class="p-3.5 sm:p-4 hover:bg-slate-50 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3">
                                <span class="font-semibold text-slate-900 text-sm sm:text-base">{{ $contact->contact_name }}</span>
                                <span class="hidden sm:inline text-slate-300">•</span>
                                <span target="_blank" class="text-slate-900 text-sm sm:text-base">
                                    {{ $contact->contact_link }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 pt-2 sm:pt-0 border-t border-slate-100 sm:border-0 justify-end">
                                <button
                                    type="button"
                                    class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-md border border-amber-200/60 transition-colors flex items-center gap-1"
                                    wire:click="selectedData({{ $contact }})"    
                                >
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span>Szerkesztés</span>
                                </button>
                                <button
                                    type="button"
                                    class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-md border border-rose-200/60 transition-colors flex items-center gap-1"
                                    wire:confirm="Biztos törölni szeretnéd?"
                                    wire:click="delete({{ $contact }})"
                                >
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Törlés</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </section>

</div>