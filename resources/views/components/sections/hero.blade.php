<section id="home" class="min-h-[85vh] flex items-center px-4 md:px-8 lg:px-12 border-b border-border-main py-10 sm:py-16">
    <div
        class="w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center"
        x-data="{ shown: false }"
        x-intersect.once="shown = true"
    >
        
        <!-- Bal hasáb -->
        <div
            class="lg:col-span-7 space-y-6 sm:space-y-8 transition-all duration-400"
            x-show="shown"
            x-transition:enter="transition ease-out duration-300 delay-300"
            x-transition:enter-start="opacity-0 -translate-x-50"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-data="{
                text: 'A látványos megjelenés mögött stabil technológia és átgondolt struktúra áll.',
                newText: '',

                init() { this.type(0); },

                type(x) {
                    if(this.newText.length === this.text.length) {
                        return;
                    }
                    this.newText += this.text[x];
                    setTimeout(() => {
                        this.type(x + 1);
                    }, 70);
                },
            }"
        >
            
            <div class="animate-bounce font-family-mono text-[11px] sm:text-xs text-accent-light tracking-wider bg-bg-card border border-border-light px-2.5 py-1 inline-block rounded">
                ~/portfolio/kezdőlap
            </div><br>

            <span x-text="newText" class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-transparent bg-clip-text bg-linear-to-r from-accent-light via-emerald-200 to-accent-base"></span>
            <span class="animate-pulse border-r-7 border-accent-light ml-0.5 text-3xl sm:text-5xl lg:text-6xl">&nbsp;</span>
            
            <p class="text-text-secondary text-sm sm:text-lg lg:text-xl max-w-3xl leading-relaxed">
                Szia, Péter vagyok — full-stack webfejlesztő & sysadmin <br>
                Webalkalmazásokat építek az alapoktól a szerveroldali architektúráig. Rendszerüzemeltetői
                háttérrel nemcsak a tiszta, karbantartható kódra, hanem a mögötte álló
                infrastruktúrára is kiemelt
                figyelmet fordítok. Az oldalon a saját projektjeimet és referenciáimat
                gyűjtöttem össze. Ha felkeltette az érdeklődésedet a munkám, a kapcsolat
                szekcióban megtalálod az elérhetőségeimet.
            </p>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2 text-xs sm:text-sm">
                <a href="#contact" class="bg-accent-base hover:bg-accent-light text-neutral-950 font-bold px-6 sm:px-8 py-3.5 sm:py-4 rounded shadow-[0_0_30px_rgba(16,185,129,0.15)] transition-all transform hover:-translate-y-0.5 text-center md:w-auto">
                    Kapcsolat
                </a>
                <a href="#projects" class="border border-border-light hover:border-accent-base/40 text-text-secondary hover:text-accent-light px-6 sm:px-8 py-3.5 sm:py-4 rounded transition-all text-center md:w-auto">
                    Eddigi munkáim megtekintése
                </a>
            </div>
        </div>
        <!-- Jobb hasáb: JSON Terminál -->
        <div
            class="lg:col-span-5 w-full"
            x-show="shown"
            x-transition:enter="transition ease-out duration-400 delay-300"
            x-transition:enter-start="opacity-0 translate-x-50"
            x-transition:enter-end="opacity-100 translate-x-0"
        >
            <div class="bg-bg-card border border-border-light rounded-xl shadow-2xl overflow-hidden">
                <div class="bg-bg-main px-4 sm:px-6 py-3 sm:py-4 border-b border-border-main flex items-center justify-between font-family-mono text-[10px] sm:text-xs text-text-muted">
                    <div class="flex space-x-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                    </div>
                    <div class="truncate pl-2">[ specifikaciok.json ]</div>
                </div>
                <div class="p-4 sm:p-8 font-family-mono text-xs sm:text-sm text-accent-light leading-relaxed">
                    <p class="text-text-dark text-[11px] sm:text-xs">&gt; fejlesztési_irányelvek_betöltése...</p>
                    <pre class="text-text-primary mt-2 text-[11px] sm:text-sm overflow-x-auto whitespace-pre block bg-bg-main/30 p-2 rounded border border-border-main/50">
{
    "fókusz": "Webalkalmazás Fejlesztés",
    "architektúra": "Tiszta, követhető kód",
    "infrastruktúra": "Linux & Szerveroldal",
    "sebesség": "Maximálisan optimalizált"
}
                    </pre>
                    <div class="mt-4 flex items-center space-x-1 text-text-dark">
                        <span>&gt; _</span>
                        <span class="w-1.5 h-3.5 bg-accent-base animate-pulse inline-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>