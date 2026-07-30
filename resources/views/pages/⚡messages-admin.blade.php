<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Models\Message;

new #[Title('Messages')] class extends Component
{
    #[Computed]
    public function messages()
    {
        return Message::all();
    }

    public function delete(Message $message)
    {
        $message->delete();
    }
};
?>

<div class="max-w-5xl mx-auto p-3 sm:p-6 space-y-6 sm:space-y-10 font-sans text-slate-800">

    <!-- ==================== BEÉRKEZETT ÜZENETEK KEZELÉSE ==================== -->
    <section
        class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 space-y-6" 
    >
        <!-- Fejléc -->
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900">Beérkezett Üzenetek</h2>
            <p class="text-xs sm:text-sm text-slate-500">A kapcsolatfelvételi űrlapon keresztül beküldött üzenetek listája</p>
        </div>

        <!-- Üzenetek Listája -->
        <div class="divide-y divide-slate-100 border border-slate-200 rounded-lg overflow-hidden">

            @foreach ($this->messages as $message)
                <!-- Üzenet (Nyitott / Kiterjesztett állapot a megtekintéssel) -->
                <div
                    class="p-3.5 sm:p-4 bg-slate-50/50 transition-colors"
                    x-data="{
                        isOpen: false,
                        toggle() { this.isOpen = ! this.isOpen }
                    }"

                >
                    <!-- Fejléc sora -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                            <span class="font-semibold text-slate-900 text-sm sm:text-base">{{ $message->name }}</span>
                            <span class="hidden sm:inline text-slate-300">•</span>
                            <span class="text-xs sm:text-sm text-slate-500">{{ $message->email }}</span>
                        </div>
                        <div class="flex items-center gap-2 pt-2 sm:pt-0 border-t border-slate-100 sm:border-0 justify-end">
                            <button @click="toggle()" type="button" class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 013.682-.793c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-1.503-1.503a3 3 0 01-3.267-3.267M12 9a3 3 0 013 3"></path>
                                </svg>
                                <span x-text="isOpen ? 'Bezárás' : 'Megtekintés'"></span>
                            </button>
                            <button wire:click="delete({{ $message }})" type="button" class="cursor-pointer flex-1 sm:flex-none justify-center px-2.5 py-1.5 text-xs font-medium text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-md border border-rose-200/60 transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Törlés</span>
                            </button>
                        </div>
                    </div>

                    <!-- Közvetlenül az elem alatti megtekintés szekció -->
                    <div
                        class="mt-4 pt-4 border-t border-slate-200/80 space-y-3"
                        x-show="isOpen"
                        x-collapse
                    >
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <span class="block text-xs font-medium text-slate-500">Küldő neve (Name)</span>
                                <span class="text-sm font-semibold text-slate-800">{{ $message->name }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-slate-500">E-mail cím (Email)</span>
                                <a href="mailto:{{ $message->email }}" class="text-sm font-medium text-indigo-600 hover:underline">{{ $message->email }}</a>
                            </div>
                        </div>

                        <div>
                            <span class="block text-xs font-medium text-slate-500 mb-1">Üzenet tartalma (Message)</span>
                            <div class="p-3.5 bg-white rounded-lg border border-slate-200 text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $message->message }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>

    </section>

</div>