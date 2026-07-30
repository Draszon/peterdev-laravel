@props(['projects'])

<section
    id="projects"
    class="scroll-mt-24 border-b border-border-main py-16 sm:py-24 px-4 md:px-8 lg:px-12 bg-bg-card/10"
    x-data="{ show: false }"
    x-intersect.once="show = true"
>
    <div class="w-full space-y-12 sm:space-y-16">
        <div
            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-2'"
            class="space-y-2.5 transform transition-all duration-500 ease-out"
        >
            <div class="animate-bounce font-family-mono text-[11px] sm:text-xs text-accent-light">// 04. munkáim</div>
            <h2 class="text-2xl sm:text-4xl font-bold text-white tracking-tight">Projektjeim és referenciáim</h2>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 sm:gap-8 w-full">
            
            <!-- Orvosi / Magánrendelői Projekt -->
            @foreach ($projects as $index => $project)
                <div
                    class="bg-bg-card/30 border border-border-light/60 rounded-xl p-6 sm:p-8 flex flex-col justify-between gap-6 hover:border-text-dark transform transition-all duration-500 ease-out group"
                    :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                    :style="'transition-delay: ' + (200 + ({{ $index }} * 80)) + 'ms;'"
                >
                    <div class="space-y-3 sm:space-y-4">
                        <h3 class="text-xl sm:text-2xl font-bold text-white group-hover:text-accent-light transition-colors">{{ $project->title }}</h3>
                        <p class="text-text-secondary text-xs sm:text-base leading-relaxed">{{ $project->description }}</p>
                    </div>

                    <div class="pt-4 border-t border-border-main flex flex-col sm:flex-row sm:items-center justify-between gap-4 font-family-mono text-xs">
                        <span class="text-accent-light self-center sm:self-auto uppercase">[ státusz: {{ $project->status }} ]</span>
                        <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 bg-bg-card hover:bg-accent-base hover:text-neutral-950 border border-border-light hover:border-accent-base px-4 py-2 rounded transition-all text-text-primary font-medium">
                            <span>Megtekintem élőben</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
</section>