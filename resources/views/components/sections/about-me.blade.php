<section 
    id="about"
    class="scroll-mt-24 border-b border-border-main py-16 sm:py-24 px-4 md:px-8 lg:px-12 bg-bg-card/20"
>
    <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12"
        x-data="{ shown: false }"
        x-intersect.once="shown = true"
    >
        <div
            class="lg:col-span-4 space-y-3 sm:space-y-4 transition-all ease-out duration-300 delay-300"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12 pointer-events-none'"
        >
            <div class="animate-bounce font-family-mono text-[11px] sm:text-xs text-accent-light">// 02. gondolkodásmód</div>
            <h2 class="text-2xl sm:text-4xl font-bold text-white tracking-tight">Hogyan gondolkodom a fejlesztésről?</h2>
            <p class="text-text-muted text-sm sm:text-base max-w-md">Szeretem, ha egy webes megoldás az adott célhoz illeszkedik. Minden projektet az igények és az üzleti helyzet alapján építek fel.</p>
        </div>
        
        <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12">
            <div
                class="space-y-3 border-l-2 border-border-main pl-4 sm:pl-6 hover:border-accent-base/50 transition-all ease-out duration-300 delay-500"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12 pointer-events-none'"
            >
                <div class="text-accent-light font-semibold font-family-mono text-xs sm:text-sm">&gt; 01 / Üzleti fókusz & egyedi igények</div>
                <p class="text-text-secondary text-xs sm:text-base leading-relaxed">
                    A letisztult, átgondolt megoldásokat keresem, amelyek valóban a felhasználót szolgálják. Először megértem a célt, utána olyan reszponzív és modern felületet építek, ami ehhez tényleg illeszkedik.
                </p>
            </div>
            <div
                class="space-y-3 border-l-2 border-border-main pl-4 sm:pl-6 hover:border-accent-base/50 transition-all ease-out duration-300 delay-700"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12 pointer-events-none'"   
            >
                <div class="text-accent-light font-semibold font-family-mono text-xs sm:text-sm">&gt; 02 / Szerveroldali háttér & Biztonság</div>
                <p class="text-text-secondary text-xs sm:text-base leading-relaxed">
                    Rendszerüzemeltetői tapasztalatomnak köszönhetően a Linux-alapú environments, API-kapcsolatok és szerverbeállítások stabilan, a megfelelő biztonsági alapelvek mentén futnak.
                </p>
            </div>
        </div>
    </div>
</section>