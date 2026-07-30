<?php

// Livewire attribútumok és komponens osztály.
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Computed;

// Eloquent modell a technológia rekordok kezeléséhez.
use App\Models\Technology;

// Névtelen Livewire komponens a technológiák admin felületéhez.
new #[Title('Edit technologies')] class extends Component
{
    // Az éppen szerkesztett rekord (null esetén új rekord létrehozása történik).
    public ?Technology $technology = null;

    // Űrlap mező: technológia típusa.
    #[Validate('required', message: 'Kötelező típust megadni!')]
    public $type = '';

    // Űrlap mező: technológia neve.
    #[Validate('required', message: 'Kötelező nevet megadni!')]
    public $title = '';

    // Űrlap mező: technológia leírása.
    #[Validate('required', message: 'Kötelező leírást megadni!')]
    public $description = '';

    // Computed property: a listához lekéri az összes technológia rekordot.
    #[Computed]
    public function technologies()
    {
        return Technology::all();
    }

    // Mentés: validálás után frissít vagy új rekordot hoz létre.
    public function save()
    {
        // A mezők validálása a Validate attribútumok alapján.
        $this->validate();

        // Ha van kiválasztott rekord, akkor szerkesztés történik.
        if ($this->technology) {
            $this->technology->update($this->only(['type', 'title', 'description']));
            session()->flash('status', 'Sikeres frissítés');
        } else {
            // Egyébként új rekord létrehozása.
            Technology::create($this->only(['type', 'title', 'description']));
            session()->flash('status', 'Sikeres feltöltés!');
        }

        // Visszaállítja az űrlapot alapállapotra mentés után.
        $this->reset();
    }

    // Szerkesztés megszakítása és mezők ürítése.
    public function cancel()
    {
        $this->reset();
    }

    // A kiválasztott rekord törlése.
    public function delete(Technology $technology)
    {
        $technology->delete();
        $this->reset();
    }

    // Szerkesztés mód indítása: a rekord adatait betölti az űrlapba.
    public function getUpdate(Technology $technology)
    {
        $this->technology = $technology;

        $this->type = $technology->type;
        $this->title = $technology->title;
        $this->description = $technology->description;
    }
};
?>

<!-- Fő konténer: lista + űrlap egy admin blokkban. -->
<div class="max-w-5xl mx-auto p-3 sm:p-6 space-y-6 sm:space-y-10 font-sans text-slate-800">

    <!-- ==================== 2. MEGLÉVŐ TECHNOLÓGIÁK SZERKESZTÉSE & LISTÁJA ==================== -->
    <section class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 space-y-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Technológiák kezelése</h2>
            <p class="text-xs sm:text-sm text-slate-500">Válassz ki egy elemet a listából a szerkesztéshez, törléshez vagy vigyél fel új elemet</p>
        </div>

        <!-- Lista szekció -->
        <div class="divide-y divide-slate-100 border border-slate-200 rounded-lg overflow-hidden">
            <!-- Elemek listázása -->
            @foreach ($this->technologies as $technology)
                <!-- Egy technológia sor: cím + műveleti gombok. -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3.5 sm:p-4 gap-3 hover:bg-slate-50 transition-colors">
                    <div class="flex items-start sm:items-center gap-2.5 flex-wrap">
                        <span class="font-medium text-slate-800 text-sm sm:text-base">{{ $technology->title }}</span>
                    </div>
                    <!-- Gombok: kis képernyőn flex-1 / szétosztva -->
                    <div class="flex items-center gap-2 pt-1 sm:pt-0 border-t border-slate-100 sm:border-0 justify-end">
                        <!-- Kiválasztja a rekordot szerkesztésre (betöltés az űrlapba). -->
                        <button wire:click="getUpdate({{ $technology }})" type="button" class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-md border border-amber-200/60 transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Szerkesztés</span>
                        </button>
                        <!-- Törli a kiválasztott rekordot. -->
                        <button
                            wire:confirm="Biztos törölni szeretnéd?"
                            wire:click="delete({{ $technology }})"
                            type="button"
                            class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-md border border-rose-200/60 transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Törlés</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Szerkesztés és új hozzáadása Form -->
        <div class="mt-6 pt-5 border-t bg-slate-50 p-3.5 sm:p-5 rounded-lg border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm sm:text-base font-semibold text-slate-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    <span>{{ $this->technology ? 'Kiválasztott szerkesztése' : 'Új technológia hozzáadása' }}</span>
                </h3>
            </div>

            <form wire:submit="save" id="edit-tech-form" class="space-y-4">
                <!-- Kétirányú adatkapcsolat: az inputok közvetlenül a komponens mezőit írják/olvassák. -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit-type" class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Típus (Type)</label>
                        <input wire:model="type" type="text" id="edit-type" name="type" class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm transition-all">
                        <div>
                            <!-- Mezőszintű validációs hiba a type mezőhöz. -->
                            @error('type') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="edit-title" class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Megnevezés (Title)</label>
                        <input wire:model="title" type="text" id="edit-title" name="title" class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm transition-all">
                        <div>
                            <!-- Mezőszintű validációs hiba a title mezőhöz. -->
                            @error('title') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="edit-description" class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Leírás (Description)</label>
                    <textarea wire:model="description" id="edit-description" name="description" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm transition-all resize-y"></textarea>
                    <div>
                        <!-- Mezőszintű validációs hiba a description mezőhöz. -->
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Mentés/frissítés után beállított státusz üzenet. -->
                @if (session('status'))
                    {{ session('status') }}
                @endif
                <!-- Akció gombok: mobilon 100% szélesek egymás alatt/mellett -->
                <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2.5 pt-2">
                    @if ($this->technology)
                        <!-- Csak szerkesztés módban jelenik meg: visszaállítás alapállapotra. -->
                        <button wire:click="cancel" type="button" class="cursor-pointer w-full sm:w-auto px-4 py-2 text-sm font-medium text-slate-600 bg-white hover:bg-slate-100 border border-slate-300 rounded-lg transition-colors text-center">
                            Mégse
                        </button>
                    @endif
                    
                    <!-- Dinamikus felirat: új létrehozás vagy meglévő frissítése. -->
                    <button type="submit" class="cursor-pointer w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-lg shadow-sm transition-colors text-center focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        {{$this->technology ? 'Szerkesztés' : 'Technológia feltöltése' }}
                    </button>
                </div>
            </form>
        </div>

    </section>

</div>