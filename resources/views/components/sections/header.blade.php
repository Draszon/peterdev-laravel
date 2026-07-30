<header
    x-data="{
        shown: false,
        open: false,
        menuItems: [
            { link: '#home', content: '01. // kezdőlap' },
            { link: '#about', content: '02. // rólam' },
            { link: '#stack', content: '03. // technológiák' },
            { link: '#projects', content: '04. // munkáim' },
            { link: '#contact', content: '05. // kapcsolat' },
        ],
        toggle() {
            this.open = !this.open;
        },
    }"
    x-intersect="shown = true"
>
    <!-- NAVIGATION -->
    <nav
        class="fixed top-0 left-0 w-full bg-bg-main/90 backdrop-blur-md border-b border-border-main z-50 px-4 md:px-8 py-4"
    >
        <div class="w-full flex items-center justify-between">
            <!-- Logo string -->
            <div class="font-family-mono text-accent-light font-bold tracking-wider text-xs sm:text-sm lg:text-base pr-2">
                &lt; PETER_DEV /&gt;
            </div>
            <!-- Menüpontok Desktop -->
            <div class="hidden md:flex items-center space-x-6 lg:space-x-12 font-family-mono text-xs lg:text-sm">
                <template x-for="item in menuItems" :key="item.link">
                    <x-menu-btn ::link="item.link" ::content="item.content"/>
                </template>
            </div>
        
            <!-- Jobb oldali rész: Státusz + Social + Hamburger gomb -->
            <div class="flex items-center space-x-3">
                <!-- Élő Státusz -->
                <div class="flex items-center space-x-1.5 bg-bg-card border border-border-light px-2.5 sm:px-4 py-1.5 sm:py-2 rounded text-[10px] sm:text-[11px] font-family-mono text-text-secondary">
                    <span class="w-2 h-2 rounded-full bg-accent-base animate-pulse"></span>
                    <span class="hidden xs:inline">STÁTUSZ: </span>
                    <span class="text-accent-light font-semibold">ELÉRHETŐ</span>
                </div>
            
                <!-- Hamburger Gomb (Mobil) -->
                <button x-on:click="toggle()" id="menu-btn" class="md:hidden p-2 text-text-secondary hover:text-accent-light focus:outline-none" aria-label="Menü megnyitása">
                    <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    
        <!-- Mobil Menü Dropdown -->
        <div 
            x-show="open"
            x-on:click.outside="open = false"
            x-transition:enter="transition-all ease-out duration-200"
            x-transition:enter-start="translate-x-50 opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition-all ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-y-10 opacity-0"
            id="mobile-menu"
            class="absolute top-full left-4 right-4 mt-2 p-4 bg-bg-main/95 border border-border-main rounded-xl shadow-2xl shadow-accent-base/20 backdrop-blur-lg flex flex-col space-y-3 font-family-mono text-xs"
        >

            <template x-for="item in menuItems" :key="item.link">
                <a x-on:click="toggle()" x-text="item.content" :href="item.link" class="mobile-link text-accent-light py-2.5 px-3 hover:bg-bg-card/60 rounded-lg transition-colors"></a>
            </template>
            
            <!-- Mobil Social Linkek -->
            <div class="flex space-x-6 pt-3 border-t border-border-main/80 px-3 text-text-secondary text-[11px]">
                @foreach ($socialLinks as $link)
                    <a href="{{ $link->formattedUrl }}" target="_blank" rel="noopener noreferrer" class="hover:text-accent-light transition-colors">{{ $link->contact_name }}</a>
                @endforeach
                
            </div>
        </div>
    </nav>
</header>