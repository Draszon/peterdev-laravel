<?php

use Illuminate\Support\Facades\RateLimiter;
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
        $contacts = Contact::all();

        return [
            'contacts' => $contacts,
            'emailContact' => $contacts->first(fn (Contact $contact) => str_contains($contact->contact_link, '@')),
        ];
    }

    #[Validate('required', message: 'Írd le hogyan szólíthatlak!')]
    #[Validate('min:2', message: 'Túl rövid név!')]
    #[Validate('max:100', message: 'Túl hosszú név!')]
    public $name = '';

    #[Validate('required', message: 'Add meg az email címed!')]
    #[Validate('max:150', message: 'Túl hosszú email cím')]
    #[Validate('email', message: 'Valós email címet kell megadi!')]
    public $email = '';

    #[Validate('required', message: 'Írd le röviden miben segíthetek!')]
    #[Validate('max:2000', message: 'Max 2000 karaktert hosszú lehet az üzenet!')]
    public $message = '';

    #[Validate('accepted', message: 'El kell fogadnod az adatkezelési tájékoztatót a küldés előtt.')]
    public $privacy_consent = false;

    public $website = '';

    public float $formLoadedAt = 0.0;

    public function mount(): void
    {
        $this->formLoadedAt = microtime(true);
    }

    public function save()
    {
        $this->validate();

        if ($this->website !== '' || (microtime(true) - $this->formLoadedAt) < 2) {
            session()->flash('status', 'Sikeres üzenetküldés!');

            return $this->reset(['name', 'email', 'message', 'website', 'privacy_consent']);
        }

        $rateLimitKey = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            $this->addError('email', "Túl sok üzenetet küldtél. Kérlek várj {$seconds} másodpercet.");

            return null;
        }

        RateLimiter::hit($rateLimitKey, 60);

        Message::create(
            $this->only('name', 'email', 'message')
        );

        session()->flash('status', 'Sikeres üzenetküldés!');

        return $this->reset(['name', 'email', 'message', 'website', 'privacy_consent']);
    }
};
?>

<div>
    <section
        id="contact"
        class="scroll-mt-24 py-16 sm:py-24 px-4 md:px-8 lg:px-12 w-full"
        x-data="{ shown: false }"
        x-intersect.once="shown = true"
    >
        <div
            class="w-full max-w-4xl mx-auto space-y-8 sm:space-y-12 bg-bg-card border border-border-light p-5 sm:p-12 rounded-xl shadow-2xl transition-all duration-500 delay-500 ease-out"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12 pointer-events-none'"
        >
            <div class="space-y-3 text-center">
                <div class="animate-bounce font-family-mono text-[11px] sm:text-xs text-accent-light">// 05. kapcsolat</div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">Kérdésed van vagy ötletelnél?</h2>
                
                <!-- Közvetlen Email Elérhetőség -->
                <div class="pt-2">
                    <span class="text-text-muted font-family-mono text-xs block mb-1">Közvetlen elérhetőségem:</span>
                    @if ($this->pageDatas['emailContact'])
                        <a href="{{ $this->pageDatas['emailContact']->formatted_url }}" class="font-family-mono text-accent-light hover:text-accent-lighter text-sm sm:text-lg font-semibold bg-bg-main/60 border border-border-light/50 px-4 py-2 rounded-lg inline-flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4 text-accent-base" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $this->pageDatas['emailContact']->contact_link }}
                        </a>
                    @endif
                </div>
            </div>

            @if (session('status'))
                <div class="p-4 mb-6 text-sm text-emerald-400 bg-emerald-950/50 border border-emerald-500/30 rounded-lg font-family-mono">
                    &gt; {{ session('status') }}
                </div>
            @endif
            
            <form wire:submit.prevent="save" class="space-y-4 sm:space-y-6 font-family-mono text-xs sm:text-sm">
                <div class="absolute left-[-9999px]" aria-hidden="true">
                    <label for="website">Hagyd ezt a mezőt üresen</label>
                    <input wire:model="website" type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-text-muted text-[11px] sm:text-xs mb-1.5 sm:mb-2">&gt; hogyan szólíthatlak?</label>
                        <input wire:model="name" type="text" placeholder="A neved..." class="w-full bg-bg-main border border-border-light focus:border-accent-base/50 rounded-lg p-3 sm:p-4 text-text-primary focus:outline-none transition-colors">
                        <div>
                            @error('name')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-text-muted text-[11px] sm:text-xs mb-1.5 sm:mb-2">&gt; ahol elérhetlek:</label>
                        <input wire:model="email" type="email" placeholder="Az e-mail címed..." class="w-full bg-bg-main border border-border-light focus:border-accent-base/50 rounded-lg p-3 sm:p-4 text-text-primary focus:outline-none transition-colors">
                        <div>
                            @error('email')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>                        
                    </div>
                </div>
                <div>
                    <label class="block text-text-muted text-[11px] sm:text-xs mb-1.5 sm:mb-2">&gt; miben segíthetek?</label>
                    <textarea wire:model="message" rows="4" placeholder="Rövid leírás az ötletedről vagy kérdésedről..." class="w-full bg-bg-main border border-border-light focus:border-accent-base/50 rounded-lg p-3 sm:p-4 text-text-primary focus:outline-none transition-colors"></textarea>
                    <div>
                        @error('message')
                            <span class="text-red-400 text-xs">{{ $message }}</span>
                        @enderror
                    </div>                
                </div>
                <div class="pt-1 sm:pt-2 space-y-3">
                    <label class="flex items-start gap-3 text-text-secondary text-[11px] sm:text-xs leading-relaxed">
                        <input wire:model="privacy_consent" type="checkbox" class="mt-1 h-4 w-4 rounded border-border-light bg-bg-main text-accent-base focus:ring-accent-base">
                        <span>
                            Elfogadom az <a href="/adatkezelesi_tajekoztato.pdf" target="_blank" rel="noopener" class="text-accent-light hover:text-accent-lighter underline">adatkezelési tájékoztatót</a>, és hozzájárulok ahhoz, hogy az általam megadott adatokat a kapcsolatfelvétel céljából tárolják és feldolgozzák.
                        </span>
                    </label>
                    <div>
                        @error('privacy_consent')
                            <span class="text-red-400 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-accent-base hover:bg-accent-light text-neutral-950 font-extrabold p-3.5 sm:p-4 rounded-lg transition-colors text-sm sm:text-base shadow-[0_0_30px_rgba(16,185,129,0.1)]">
                        üzenet_küldése()
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>