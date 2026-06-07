<!DOCTYPE html>
<html lang="fr" x-data="{ dark: localStorage.getItem('theme') !== 'light', mobileOpen: false }" :class="dark ? 'dark' : ''" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 - fallabolo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

  @fluxAppearance
      @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
</head>
<body class="antialiased transition-colors duration-300 overflow-x-hidden"
      x-bind:class="dark ? 'bg-zinc-950 text-zinc-100' : 'bg-slate-50 text-zinc-900'"
      x-data="{ scrolled: false }">

    <div x-on:scroll.window="scrolled = window.scrollY > 60">

        {{-- ── Overlay sombre derrière le menu mobile ── --}}
        <div
            x-show="mobileOpen"
            x-transition:enter="transition duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-on:click="mobileOpen = false"
            class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm md:hidden"
            aria-hidden="true"
        ></div>

        {{-- ── Menu mobile plein écran ── --}}
        <div
            x-show="mobileOpen"
            x-transition:enter="transition duration-350 ease-out"
            x-transition:enter-start="-translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition duration-250 ease-in"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-full opacity-0"
            class="fixed inset-x-0 top-0 z-50 flex min-h-screen flex-col bg-white dark:bg-zinc-950 md:hidden"
        >
            <div class="flex items-center justify-between border-b border-slate-200/80 px-5 py-4 dark:border-zinc-800 " >
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="grid size-9 place-items-center rounded-lg text-white dark:bg-zinc-50 dark:text-zinc-950">sq</span>
                    <span class="text-lg font-black text-slate-950 dark:text-zinc-400">fallabolo</span>
                </a>
                <button x-on:click="mobileOpen = false" class="grid size-9 place-items-center rounded-lg border border-slate-200 bg-slate-50 text-slate-700 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400">
                    <flux:icon.x-mark class="size-5" />
                </button>
            </div>

            <nav class="flex flex-1 flex-col px-5 py-8">
                <ul class="space-y-1">
                    @foreach ([
                        ['label' => 'Problème',   'href' => route('home').'#probleme', 'icon' => 'bug-ant'],
                        ['label' => 'Solution',     'href' => route('home').'#solution',   'icon' => 'face-smile'],
                        ['label' => 'Fonctionnalités',       'href' => route('home').'#fonctionnalites',     'icon' => 'star'],
                        ['label' => 'MCP',        'href' => route('home').'#mcp',      'icon' => 'sparkles'],
                        ['label' => 'Tarifs',       'href' => route('home').'#tarifs', 'icon' => 'credit-card'],
                    ] as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="group flex items-center gap-4 rounded-xl px-4 py-4 text-lg font-bold text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 dark:text-zinc-400 dark:hover:bg-zinc-900 dark:hover:text-zinc-50">
                                <span class="grid size-9 place-items-center rounded-lg bg-slate-100 text-slate-500 transition group-hover:bg-slate-200 group-hover:text-slate-950 dark:bg-zinc-900 dark:text-zinc-400 dark:group-hover:bg-zinc-800 dark:group-hover:text-zinc-50">
                                    <flux:icon :name="$link['icon']" class="size-5" />
                                </span>
                                {{ $link['label'] }}
                                <flux:icon.arrow-right class="ml-auto size-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-slate-500 dark:text-zinc-600" />
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="my-6 border-t border-slate-200 dark:border-zinc-800"></div>
                <a href="{{ route('home') }}#contact" class="flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-6 py-4 text-base font-black text-white transition hover:bg-slate-800 dark:bg-zinc-50 dark:text-zinc-950 dark:hover:bg-zinc-200">
                    Demander une démo gratuite
                </a>
            </nav>
        </div>

        {{-- ── Header principal ── --}}
        <header class="fixed top-0 left-0 right-0 z-40 flex justify-center" x-bind:class="scrolled ? 'pt-3' : 'pt-0'">
            <nav class="transition-all duration-300 ease-in-out w-full"
                x-bind:class="scrolled
                    ? 'mx-4 max-w-5xl rounded-full shadow-[0_8px_32px_-4px_rgba(0,0,0,0.12),0_0_0_1px_rgba(0,0,0,0.04)] backdrop-blur-md dark:shadow-[0_8px_32px_-4px_rgba(16,185,129,0.2),0_0_24px_0_rgba(16,185,129,0.15)] px-4 py-2'
                    : 'backdrop-blur px-5 py-4 lg:px-8'">
                <div class="flex items-center justify-between transition-all duration-300" x-bind:class="scrolled ? 'gap-2' : 'gap-4 mx-auto max-w-7xl'">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
                        <span class="grid place-items-center rounded-lg bg-slate-950 text-white dark:bg-zinc-50 dark:text-zinc-950 transition-all duration-300" x-bind:class="scrolled ? 'size-7' : 'size-9'">sq</span>
                        <span class="font-black tracking-normal text-slate-950 dark:text-zinc-400 transition-all duration-300" x-bind:class="scrolled ? 'text-base ' : 'text-lg'">fallabolo</span>
                    </a>

                    <div class="hidden items-center text-slate-600 dark:text-zinc-400 md:flex transition-all duration-300" x-bind:class="scrolled ? 'gap-5 text-sm font-medium' : 'gap-7 text-sm font-semibold'">
                        <a href="{{ route('home') }}#valeur" class="hover:text-emerald-500">Proposition de valeur</a>
                        <a href="{{ route('home') }}#probleme" class="hover:text-emerald-500">Problème</a>
                        <a href="{{ route('home') }}#solution" class="hover:text-emerald-500">Solution</a>
                        <a href="{{ route('home') }}#fonctionnalites" class="hover:text-emerald-500">Fonctionnalités</a>
                        <a href="{{ route('home') }}#tarifs" class="hover:text-emerald-500">Tarifs</a>
                        <button @click="dark=!dark; localStorage.setItem('theme', dark ? 'dark' : 'light')" class="w-9 h-9 flex items-center justify-center rounded-xl transition-all cursor-pointer hover:bg-emerald-500/10 hover:text-emerald-400">
                            <span x-text="dark ? '🌙' : '☀️'"></span>
                        </button>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('home') }}#contact" class="hidden md:inline-flex items-center gap-2 font-semibold text-white bg-slate-950 transition-all duration-300 hover:bg-slate-800 dark:bg-zinc-50 dark:text-zinc-950 dark:hover:bg-zinc-200" x-bind:class="scrolled ? 'text-sm px-4 py-1.5 rounded-full' : 'text-sm px-4 py-2 rounded-lg'">
                            Demander une démo
                        </a>
                        <flux:button x-on:click="mobileOpen = true" class="grid size-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 md:hidden">
                            <flux:icon.bars-3 class="size-5" />
                        </flux:button>
                    </div>
                </div>
            </nav>
        </header>
    </div>

   <main class="relative min-h-screen flex flex-col items-center justify-center pt-20 px-5 text-center overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] pointer-events-none opacity-50"
         style="background:radial-gradient(circle,rgba(52,211,153,.15) 0%,transparent 70%)"></div>
    <div class="absolute inset-0 hero-grid pointer-events-none"></div>

    <div class="relative max-w-2xl mx-auto">
        <h1 class="font-display font-extrabold leading-none tracking-tight mb-4" style="font-size:clamp(6rem,15vw,12rem)">
            <span class="grad-text">404</span>
        </h1>

        <h2 class="font-display font-bold text-2xl sm:text-3xl mb-6" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
            Oups ! Cette page s'est perdue dans le cloud.
        </h2>

        <p class="text-lg font-light max-w-md mx-auto mb-10 leading-relaxed"
           :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            La page que vous recherchez n'existe pas ou a été déplacée. Pas de panique, nous pouvons vous aider à retrouver votre chemin.
        </p>

        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('home') }}" class="px-8 py-3.5 rounded-xl font-display font-bold text-zinc-900 bg-emerald-400 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/25">
                Retour à l'accueil
            </a>
            <a href="{{ route('home') }}#contact" class="px-8 py-3.5 rounded-xl font-medium border transition-all hover:-translate-y-0.5"
                    :class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800/50' : 'border-zinc-200 text-zinc-600 hover:border-zinc-400 hover:bg-zinc-50'">
                Nous contacter
            </a>
        </div>
    </div>
</main>
    <footer class="transition-colors duration-300" x-bind:class="dark ? 'bg-zinc-900/50 border-t border-zinc-800' : 'bg-white border-t border-slate-200'">
        <div class="mx-auto max-w-7xl px-5 lg:px-8 py-12">
            <div class="grid grid-cols-2 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-sm font-black text-slate-900 dark:text-zinc-100">Produit</p>
                    <ul class="mt-4 space-y-3">
                        @foreach ([['label'=>'Tarifs','href'=>route('home').'#tarifs'],['label'=>'Solution','href'=>route('home').'#solution'],['label'=>'Fonctionnalités','href'=>route('home').'#fonctionnalites'],['label'=>'FAQ','href'=>route('home').'#faq']] as $link)
                            <li><a href="{{ $link['href'] }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-900 dark:text-zinc-100">Légal</p>
                    <ul class="mt-4 space-y-3">
                        @foreach ([['label'=>'CGU','slug'=>'cgu'],['label'=>'CGV','slug'=>'cgv'],['label'=>'Politique de cookies','slug'=>'cookies']] as $link)
                            <li><a href="{{ route('legal.show', $link['slug']) }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-900 dark:text-zinc-100">Contact</p>
                    <ul class="mt-4 space-y-3">
                        <li><a href="{{ route('home') }}#contact" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">Demander une démo</a></li>
                        <li><a href="mailto:contact@fallabolo.com" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">contact@fallabolo.com</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-900 dark:text-zinc-100">Ressources</p>
                    <ul class="mt-4 space-y-3">
                        <li><a href="{{ route('home') }}#faq" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">FAQ</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-100 dark:border-zinc-800 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="grid size-8 place-items-center rounded-lg bg-slate-950 text-white dark:bg-zinc-50 dark:text-zinc-950">sq</span>
                    <span class="text-base font-black text-slate-900 dark:text-zinc-100">fallabolo</span>
                </a>
                <p class="text-sm text-slate-400 dark:text-zinc-500">© {{ date('Y') }} fallabolo. Tous droits réservés.</p>
                <div class="flex items-center gap-4">
                    <a href="https://www.linkedin.com/company/fallabolo" class="text-slate-400 hover:text-slate-950 dark:hover:text-zinc-50">
                        <svg class="size-5" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3A2 2 0 0 1 21 5V19A2 2 0 0 1 19 21H5A2 2 0 0 1 3 19V5A2 2 0 0 1 5 3H19M18.5 18.5V13.2A3.26 3.26 0 0 0 15.24 9.94C14.39 9.94 13.4 10.46 12.92 11.24V10.13H10.13V18.5H12.92V13.57A1.46 1.46 0 0 1 14.38 12.11A1.46 1.46 0 0 1 15.84 13.57V18.5H18.5M6.88 8.56A1.68 1.68 0 0 0 8.56 6.88A1.68 1.68 0 0 0 6.88 5.2A1.68 1.68 0 0 0 5.2 6.88A1.68 1.68 0 0 0 6.88 8.56M8.27 18.5V10.13H5.5V18.5H8.27Z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @fluxScripts
    @persist('toast')
        <flux:toast.group position="top center">
            <flux:toast />
        </flux:toast.group>
    @endpersist
</body>
</html>
