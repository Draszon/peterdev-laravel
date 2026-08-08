<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Message;
use Livewire\Attributes\Computed;
use App\Models\Contact;

new class extends Component
{
    #[Computed]
    public function pageDatas()
    {
        return [
            'contacts' => Contact::all(),
        ];
    }

    #[Validate('required', message: 'Írd le hogyan szólíthatlak!')]
    public $name = '';

    #[Validate('required', message: 'Add meg az email címed!')]
    #[Validate('email', message: 'Valós email címet kell megadi!')]
    public $email = '';

    #[Validate('required', message: 'Írd le röviden miben segíthetek!')]
    public $message = '';

    public function save()
    {
        $this->validate();

        Message::create(
            $this->only('name', 'email', 'message')
        );

        session()->flash('status', 'Sikeres üzenetküldés!');
        return $this->reset();
    }
};
?>

<div>
    <section
        id="contact"
        class="scroll-mt-24 py-16 sm:py-24 px-4 md:px-8 lg:px-12 w-full"
        x-data="{ show: false }"
        x-intersect.once="show = true"      
    >
        <div
            class="w-full max-w-4xl mx-auto space-y-8 sm:space-y-12 bg-bg-card border border-border-light p-5 sm:p-12 rounded-xl shadow-2xl"
                x-show="show"
                x-transition:enter="transition ease-out duration-500 delay-500"
                x-transition:enter-start="opacity-0 translate-y-30"
                x-transition:enter-end="opacity-100 translate-y-0"
            >
            <div class="space-y-3 text-center">
                <div class="animate-bounce font-family-mono text-[11px] sm:text-xs text-accent-light">// 05. kapcsolat</div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Kérdésed van vagy ötletelnél?</h2>
                
                <!-- Közvetlen Email Elérhetőség -->
                <div class="pt-2">
                    <span class="text-text-muted font-family-mono text-xs block mb-1">Közvetlen elérhetőségem:</span>
                    <a href="mailto:{{ $this->pageDatas['contacts'][2]['contact_link'] }}" class="font-family-mono text-accent-light hover:text-accent-lighter text-sm sm:text-lg font-semibold bg-bg-main/60 border border-border-light/50 px-4 py-2 rounded-lg inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4 text-accent-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ $this->pageDatas['contacts'][2]['contact_link'] }}
                    </a>
                </div>
            </div>

            @if (session('status'))
                <div class="p-4 mb-6 text-sm text-emerald-400 bg-emerald-950/50 border border-emerald-500/30 rounded-lg font-family-mono">
                    &gt; {{ session('status') }}
                </div>
            @endif
            
            <form wire:submit.prevent="save" class="space-y-4 sm:space-y-6 font-family-mono text-xs sm:text-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-text-muted text-[11px] sm:text-xs mb-1.5 sm:mb-2">&gt; hogyan szólíthatlak?</label>
                        <input wire:model="name" type="text" placeholder="A neved..." class="w-full bg-bg-main border border-border-light focus:border-accent-base/50 rounded-lg p-3 sm:p-4 text-text-primary focus:outline-none transition-colors">
                        <div>
                            @error('name')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-text-muted text-[11px] sm:text-xs mb-1.5 sm:mb-2">&gt; ahol elérhetlek:</label>
                        <input wire:model="email" type="email" placeholder="Az e-mail címed..." class="w-full bg-bg-main border border-border-light focus:border-accent-base/50 rounded-lg p-3 sm:p-4 text-text-primary focus:outline-none transition-colors">
                        <div>
                            @error('email')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>                        
                    </div>
                </div>
                <div>
                    <label class="block text-text-muted text-[11px] sm:text-xs mb-1.5 sm:mb-2">&gt; miben segíthetek?</label>
                    <textarea wire:model="message" rows="4" placeholder="Rövid leírás az ötletedről vagy kérdésedről..." class="w-full bg-bg-main border border-border-light focus:border-accent-base/50 rounded-lg p-3 sm:p-4 text-text-primary focus:outline-none transition-colors"></textarea>
                    <div>
                        @error('message')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>                
                </div>
                <div class="pt-1 sm:pt-2">
                    <button type="submit" class="w-full bg-accent-base hover:bg-accent-light text-neutral-950 font-extrabold p-3.5 sm:p-4 rounded-lg transition-colors text-sm sm:text-base shadow-[0_0_30px_rgba(16,185,129,0.1)]">
                        üzenet_küldése()
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>