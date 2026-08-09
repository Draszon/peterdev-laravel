@props(['technology'])

<section
    id="stack"
    class="scroll-mt-24 border-b border-border-main py-16 sm:py-24 px-4 md:px-8 lg:px-12"
    x-data="{ shown: false }"
    x-intersect.once="shown = true"    
>
    <div class="w-full space-y-12 sm:space-y-16">
        <div
            class="space-y-2.5 transition-all ease-out duration-500 delay-300"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-12'"
        >
            <div class="animate-bounce font-family-mono text-[11px] sm:text-xs text-accent-light">// 03. technológiák</div>
            <h2 class="text-2xl sm:text-4xl font-bold text-white tracking-tight">Technológiák, amikkel dolgozom</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 w-full">
            <!-- Eszköz -->

            @foreach ($technology as $tech)
                <div
                    class="bg-bg-card/40 border border-border-light p-6 sm:p-8 rounded-xl transition-all ease-out duration-500 delay-300 group shadow-sm hover:border-accent-base/30"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-12 pointer-events-none'"
                    >

                    <div class="flex justify-between items-center mb-4 sm:mb-6">
                        <div class="font-family-mono text-accent-light text-xs sm:text-sm">// {{ $tech->type }}</div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 group-hover:text-accent-light transition-colors">{{ $tech->title }}</h3>
                    <p class="text-text-secondary text-xs sm:text-base leading-relaxed">{{ $tech->description }}</p>
                </div>
            @endforeach

        </div>
    </div>
</section>