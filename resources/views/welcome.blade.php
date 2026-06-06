<!DOCTYPE html>
<html lang="fr" x-data="{ dark: localStorage.getItem('theme') !== 'light', mobileOpen: false }" :class="dark ? 'dark' : ''" class="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MatchRH Recrutement Intelligent</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
<style>
  body { font-family: 'DM Sans', sans-serif; }

  .hero-grid {
    background-image: linear-gradient(rgba(110,231,183,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(110,231,183,.06) 1px, transparent 1px);
    background-size: 60px 60px;
    -webkit-mask: radial-gradient(ellipse 80% 70% at 50% 50%, black 30%, transparent 100%);
    mask: radial-gradient(ellipse 80% 70% at 50% 50%, black 30%, transparent 100%);
  }
  .light .hero-grid {
    background-image: linear-gradient(rgba(5,150,105,.07) 1px, transparent 1px), linear-gradient(90deg, rgba(5,150,105,.07) 1px, transparent 1px);
  }

  .grad-text {
    background: linear-gradient(135deg, #6ee7b7, #34d399);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
  }
  .glow-dot { box-shadow: 0 0 14px #34d399, 0 0 28px rgba(52,211,153,.4); }

  /* Scroll reveal */
  .reveal        { opacity:0; transform:translateY(28px);  transition:opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1); }
  .reveal-l      { opacity:0; transform:translateX(-28px); transition:opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1); }
  .reveal-r      { opacity:0; transform:translateX(28px);  transition:opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1); }
  .reveal.on, .reveal-l.on, .reveal-r.on { opacity:1; transform:translate(0,0); }
  .d1{transition-delay:.1s} .d2{transition-delay:.2s} .d3{transition-delay:.3s} .d4{transition-delay:.4s}

  .bar-fill { width:0; transition:width 1.3s cubic-bezier(.16,1,.3,1); }
  .bar-fill.on { width:var(--w); }

  /* MCP shimmer */
  .mcp-shimmer {
    background: linear-gradient(90deg, rgba(110,231,183,.06) 25%, rgba(110,231,183,.18) 50%, rgba(110,231,183,.06) 75%);
    background-size: 200% 100%;
    animation: shimmer 3s linear infinite;
  }
  @keyframes shimmer { 0%{background-position:-200% 0} 100%{background-position:200% 0} }

  .price-card { transition: transform .3s cubic-bezier(.16,1,.3,1); }
  .price-card:hover { transform: translateY(-5px); }

  .mobile-drawer { transition: transform .35s cubic-bezier(.16,1,.3,1); }

  ::-webkit-scrollbar { width:5px; }
  ::-webkit-scrollbar-thumb { background:rgba(110,231,183,.25); border-radius:999px; }
</style>
  @fluxAppearance

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @php
            // ─── FAQ ─────────────────────────────────────────────────────
            $faqs = [
                ['question' => 'Ai-je besoin de connaissances en paie pour utiliser Squarhe ?', 'answer' => 'Non. Squarhe est conçu pour les dirigeants et gestionnaires qui ne sont pas experts en paie. L\'interface vous guide étape par étape : vous saisissez les variables, Squarhe calcule, vous validez. Notre équipe vous accompagne à la prise en main la plupart de nos clients sont opérationnels en moins d\'une journée.'],
                ['question' => 'Combien coûte Squarhe concrètement pour mon équipe ?', 'answer' => 'Squarhe démarre à 14 900 FCFA/mois pour 5 employés (offre Starter). Pour 20 employés, l\'offre Croissance revient à 34 900 FCFA/mois soit moins de 1 750 FCFA par employé. Utilisez le simulateur de tarifs sur cette page pour voir votre prix exact selon votre effectif.'],
                ['question' => 'Y a-t-il des frais cachés ou des suppléments ?', 'answer' => 'Non. Le prix affiché couvre les bulletins, les documents RH habituels et le support. Il n\'y a pas de facturation à l\'acte pour les procédures courantes. Seul le setup fee (mise en service initiale) est séparé, négociable selon votre situation.'],
                ['question' => 'Est-ce que Squarhe couvre la CNPS et l\'IRPP camerounais ?', 'answer' => 'Oui. Squarhe intègre les règles de calcul CNPS et IRPP en vigueur au Cameroun, avec des mises à jour automatiques en cas de changement réglementaire. Vous disposez également des exports nécessaires pour vos déclarations et contrôles.'],
                ['question' => 'Que se passe-t-il si mon équipe grossit ?', 'answer' => 'Squarhe s\'adapte à votre croissance. Vous pouvez passer d\'une offre à l\'autre à tout moment, sans engagement annuel. Le simulateur de tarifs sur cette page calcule automatiquement votre prix en fonction de votre effectif.'],
                ['question' => 'Squarhe couvre-t-il tous les secteurs d\'activité ?', 'answer' => 'Squarhe couvre la majorité des PME de services, commerce et industrie légère. Certaines conventions spécifiques comme le BTP et l\'agriculture ne sont pas encore entièrement intégrées, mais vous pouvez configurer vos propres bases de calcul. Contactez-nous pour évaluer votre situation.'],
                ['question' => 'Comment se passe la migration depuis Excel ?', 'answer' => 'Nous vous accompagnons pendant la migration. Notre équipe reprend vos données existantes (employés, historique, variables) et les importe dans Squarhe. La migration se fait idéalement en fin de mois ou d\'exercice pour une continuité parfaite.'],
                ['question' => 'Mes données sont-elles sécurisées ?', 'answer' => 'Oui. Les accès sont contrôlés par rôle (administrateur, gestionnaire, employé), vos données sont sauvegardées automatiquement et toutes les actions importantes sont tracées. Vos bulletins et contrats sont archivés dans un espace structuré et sécurisé.'],
            ];
        @endphp
</head>

<body class="antialiased overflow-x-hidden transition-colors duration-300"
      :class="dark ? 'bg-zinc-950 text-zinc-100' : 'bg-slate-50 text-zinc-900'"
      x-init="
        $nextTick(() => {
          const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
              if (e.isIntersecting) {
                e.target.classList.add('on');
                if (e.target.classList.contains('bar-fill')) e.target.style.width = e.target.style.getPropertyValue('--w') || e.target.getAttribute('data-w') + '%';
              }
            });
          }, { threshold:.1, rootMargin:'0px 0px -40px 0px' });
          document.querySelectorAll('.reveal,.reveal-l,.reveal-r,.bar-fill').forEach(el => obs.observe(el));
        })
      ">
<div
    x-data="{ scrolled: false, menuOpen: false }"
    x-on:scroll.window="scrolled = window.scrollY > 60"
>

    {{-- ── Overlay sombre derrière le menu mobile ── --}}
    <div
        x-show="menuOpen"
        x-transition:enter="transition duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="menuOpen = false"
        class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm md:hidden"
        aria-hidden="true"
    ></div>

    {{-- ── Menu mobile plein écran (slide from top) ── --}}
    <div
        x-show="menuOpen"
        x-transition:enter="transition duration-350 ease-out"
        x-transition:enter-start="-translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-250 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-full opacity-0"
        class="fixed inset-x-0 top-0 z-50 flex min-h-screen flex-col bg-white dark:bg-zinc-950 md:hidden"
    >
        {{-- Header interne du menu --}}
        <div class="flex items-center justify-between border-b border-slate-200/80 px-5 py-4 dark:border-zinc-800">
            <a href="#top" x-on:click="menuOpen = false" class="flex items-center gap-2.5">
                <span class="grid size-9 place-items-center rounded-lg text-white dark:bg-zinc-50 dark:text-zinc-950">
                    sqa
                </span>
                <span class="text-lg font-black text-slate-950 dark:text-zinc-400">fallabolo</span>
            </a>
            <button
                x-on:click="menuOpen = false"
                class="grid size-9 place-items-center rounded-lg border border-slate-200 bg-slate-50 text-slate-700 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400"
                aria-label="Fermer le menu"
            >
                <flux:icon.x-mark class="size-5" />
            </button>
        </div>

        {{-- Liens de navigation --}}
        <nav class="flex flex-1 flex-col px-5 py-8" aria-label="Navigation mobile">
            <ul class="space-y-1">

                @foreach ([
                    ['label' => 'Problème',   'href' => '#probleme', 'icon' => 'bug-ant'],
                    ['label' => 'Solution',     'href' => '#solution',   'icon' => 'face-smile'],
                    ['label' => 'Fonctionnalités',       'href' => '#fonctionnalites',     'icon' => 'star'],
                    ['label' => 'MCP',        'href' => '#mcp',      'icon' => 'sparkles'],
                    ['label' => 'Tarifs',       'href' => '#tarifs', 'icon' => 'credit-card'],
                ] as $link)
                    <li>
                        <a
                            href="{{ $link['href'] }}"
                            x-on:click="
                                menuOpen = false;
                                $nextTick(() => {
                                    const el = document.querySelector('{{ $link['href'] }}');
                                    if (el) el.scrollIntoView({ behavior: 'smooth' });
                                })
                            "
                            class="group flex items-center gap-4 rounded-xl px-4 py-4 text-lg font-bold text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 dark:text-zinc-400 dark:hover:bg-zinc-900 dark:hover:text-zinc-50"
                        >
                            <span class="grid size-9 place-items-center rounded-lg bg-slate-100 text-slate-500 transition group-hover:bg-slate-200 group-hover:text-slate-950 dark:bg-zinc-900 dark:text-zinc-400 dark:group-hover:bg-zinc-800 dark:group-hover:text-zinc-50">
                                <flux:icon :name="$link['icon']" class="size-5" />
                            </span>
                            {{ $link['label'] }}
                            <flux:icon.arrow-right class="ml-auto size-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-slate-500 dark:text-zinc-600" />
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- Séparateur --}}
            <div class="my-6 border-t border-slate-200 dark:border-zinc-800"></div>

            {{-- CTA principal --}}
            <a
                href="#contact"
                x-on:click="
                    menuOpen = false;
                    $nextTick(() => {
                        const el = document.querySelector('#contact');
                        if (el) el.scrollIntoView({ behavior: 'smooth' });
                    })
                "
                class="flex items-center justify-center gap-2 rounded-xl bg-slate-950 px-6 py-4 text-base font-black text-white transition hover:bg-slate-800 dark:bg-zinc-50 dark:text-zinc-950 dark:hover:bg-zinc-200"
            >

                Demander une démo gratuite
            </a>

            <p class="mt-4 text-center text-sm text-slate-400">
                ✓ Sans engagement &nbsp;·&nbsp; ✓ Réponse sous 24h
            </p>
        </nav>

        {{-- Pied du menu --}}
        <div class="border-t border-slate-200 px-5 py-5 dark:border-zinc-800">
            <p class="text-center text-sm text-slate-400">contact@fallabolo.com</p>
        </div>
    </div>

    {{-- ── Header principal ── --}}
    <header
        class="fixed top-0 left-0 right-0 z-40 flex justify-center"
        :class="scrolled ? 'pt-3' : 'pt-0'"
    >
        <nav
            aria-label="Navigation principale"
            class="transition-all duration-300 ease-in-out w-full"
            :class="scrolled
                ? 'mx-4 max-w-5xl rounded-full border border-slate-200/80 bg-white/90 shadow-[0_8px_32px_-4px_rgba(0,0,0,0.12),0_0_0_1px_rgba(0,0,0,0.04)] backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-950/90 dark:shadow-[0_8px_32px_-4px_rgba(0,0,0,0.4)] px-4 py-2'
                : 'border-b border-slate-200/80 bg-white/90 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/90 px-5 py-4 lg:px-8'"
        >
            <div
                class="flex items-center justify-between transition-all duration-300"
                :class="scrolled ? 'gap-2' : 'gap-4 mx-auto max-w-7xl'"
            >

                {{-- Logo --}}
                <a href="#top" class="flex items-center gap-2.5 shrink-0">
                    <span
                        class="grid place-items-center rounded-lg bg-slate-950 text-white dark:bg-zinc-50 dark:text-zinc-950 transition-all duration-300"
                        :class="scrolled ? 'size-7' : 'size-9'"
                    >
                        sq
                    </span>
                    <span
                        class="font-black tracking-normal text-slate-950 dark:text-zinc-400 transition-all duration-300"
                        :class="scrolled ? 'text-base ' : 'text-lg'"
                    >fallabolo</span>
                </a>

                {{-- Liens desktop --}}
                <div
                    class="hidden items-center text-slate-600 dark:text-zinc-400 md:flex transition-all duration-300"
                    :class="scrolled ? 'gap-5 text-sm font-medium' : 'gap-7 text-sm font-semibold'"
                >

                <a href="#valeur"          :class="dark ? 'border-zinc-800 text-zinc-300 hover:text-emerald-400' : 'border-zinc-100 text-zinc-600 hover:text-emerald-600'">Proposition de valeur</a>
    <a href="#probleme"        :class="dark ? 'border-zinc-800 text-zinc-300 hover:text-emerald-400' : 'border-zinc-100 text-zinc-600 hover:text-emerald-600'">Problème</a>
    <a href="#solution"        :class="dark ? 'border-zinc-800 text-zinc-300 hover:text-emerald-400' : 'border-zinc-100 text-zinc-600 hover:text-emerald-600'">Solution</a>
    <a href="#fonctionnalites" :class="dark ? 'border-zinc-800 text-zinc-300 hover:text-emerald-400' : 'border-zinc-100 text-zinc-600 hover:text-emerald-600'">Fonctionnalités</a>
    <a href="#mcp"             :class="dark ? 'border-zinc-800 text-zinc-300 hover:text-emerald-400' : 'border-zinc-100 text-zinc-600 hover:text-emerald-600'">MCP</a>
    <a href="#tarifs"          :class="dark ? 'border-zinc-800 text-zinc-300 hover:text-emerald-400' : 'border-zinc-100 text-zinc-600 hover:text-emerald-600'">Tarifs</a>
  <button @click="dark=!dark; localStorage.setItem('theme', dark ? 'dark' : 'light')"
            class="w-9 h-9 flex items-center justify-center rounded-xl border text-sm transition-all cursor-pointer"
            :class="dark ? 'hover:border-emerald-500/50 hover:text-emerald-400 hover:bg-emerald-500/10' : ' hover:border-emerald-500/50 hover:text-emerald-600 hover:bg-emerald-50'">
      <span x-text="dark ? '🌙' : '☀️'"></span>
    </button>
                </div>

                {{-- CTA desktop + burger mobile --}}
                <div class="flex items-center gap-3 shrink-0">

                    {{-- CTA desktop uniquement --}}
                    <a
                        href="#contact"
                        class="hidden md:inline-flex items-center gap-2 font-semibold text-white bg-slate-950 transition-all duration-300 hover:bg-slate-800 dark:bg-zinc-50 dark:text-zinc-950 dark:hover:bg-zinc-200"
                        :class="scrolled ? 'text-sm px-4 py-1.5 rounded-full' : 'text-sm px-4 py-2 rounded-lg'"
                    >
                        Demander une démo
                    </a>

                    {{-- Burger mobile uniquement --}}
                    <flux:button
                        x-on:click="menuOpen = true"
                        class="grid size-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 md:hidden"
                        aria-label="Ouvrir le menu"
                    >
                        <flux:icon.bars-3 class="size-5" />
                    </flux:accentbutton>

                </div>
            </div>
        </nav>
    </header>

</div>

{{-- Spacer fixed header --}}
<div class="h-[65px]"></div>



<!-- ===== HERO ===== -->
<section class="relative pt-32 pb-24 px-5 text-center overflow-hidden">
  <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[500px] pointer-events-none"
       style="background:radial-gradient(ellipse,rgba(52,211,153,.13) 0%,transparent 70%)"></div>
  <div class="absolute inset-0 hero-grid pointer-events-none"></div>
  <div class="relative max-w-5xl mx-auto">

    <div class="reveal inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-sm font-medium mb-6"
         :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
      <span class="px-2 py-0.5 rounded-full text-xs font-bold font-display bg-emerald-400 text-zinc-900">NOUVEAU</span>
      Matching algorithmique transparent sans CV obligatoire
    </div>

    <h1 class="reveal d1 font-display font-extrabold leading-[1.06] tracking-tight mb-5" style="font-size:clamp(2.4rem,7vw,4.8rem)">
      Recrutement sans bruit,<br>
      <span class="grad-text">matching au mérite</span>
    </h1>

    <p class="reveal d2 text-lg font-light max-w-xl mx-auto mb-10 leading-relaxed"
       :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
      Fini le tri manuel de centaines de CVs. MatchRH connecte talents et recruteurs via un scoring structuré, transparent et instantané.
    </p>

    <div class="reveal d3 flex flex-wrap gap-3 justify-center mb-16">
      <button class="px-7 py-3.5 rounded-xl font-display font-bold text-zinc-900 bg-emerald-400 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/25">
        Créer un compte gratuit
      </button>
      <button class="px-7 py-3.5 rounded-xl font-medium border transition-all hover:-translate-y-0.5"
              :class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800/50' : 'border-zinc-200 text-zinc-600 hover:border-zinc-400 hover:bg-zinc-50'">
        Voir la démo  <flux:icon.chevron-right class="size-4 inline-block ml-1"/>
      </button>
    </div>

    <!-- Stats -->
    <div class="reveal d4 grid grid-cols-2 sm:grid-cols-4 gap-6 pt-10 border-t"
         :class="dark ? 'border-zinc-800' : 'border-zinc-200'">
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">−87%</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Temps de tri</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">4 étapes</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Processus clair</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">100%</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Transparent</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">0 CV</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Requis</div>
      </div>
    </div>
  </div>
</section>


<!-- ===== PROPOSITION DE VALEUR ===== -->
<section id="valeur" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/50 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        La vérité que personne ne dit
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Vous passez des heures à soigner votre CV.<br>
        <span class="grad-text">Les recruteurs le lisent en 6 secondes.</span>
      </h2>
      <p class="text-base max-w-lg mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Ce n'est pas un jugement c'est une réalité structurelle. Avec des centaines de candidatures par poste, personne ne peut lire chaque CV en entier.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
      <!-- Mythe candidat -->
      <div class="reveal-l rounded-2xl border p-8 relative overflow-hidden"
           :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="absolute top-4 right-4 text-xs font-bold px-3 py-1 rounded-full border"
             :class="dark ? 'bg-red-500/15 text-red-400 border-red-500/20' : 'bg-red-50 text-red-600 border-red-200'">
          Le mythe
        </div>
        <h3 class="font-display font-bold text-lg mb-4" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ce que le candidat croit</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Peaufiner chaque ligne du CV pendant des heures
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Écrire une lettre de motivation personnalisée
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Adapter le format, les mots-clés, la mise en page
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Attendre… et souvent ne jamais avoir de retour
          </li>
        </ul>
      </div>

      <!-- Réalité recruteur -->
      <div class="reveal-r rounded-2xl border p-8 relative overflow-hidden"
           :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="absolute top-4 right-4 text-xs font-bold px-3 py-1 rounded-full border"
             :class="dark ? 'bg-amber-500/15 text-amber-400 border-amber-500/20' : 'bg-amber-50 text-amber-600 border-amber-200'">
          La réalité
        </div>
        <h3 class="font-display font-bold text-lg mb-4" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ce que le recruteur fait vraiment</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Reçoit 200+ candidatures en 48h pour un seul poste
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Scanne le CV en 6 secondesshrink-0titre, entreprise, expérience
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Ignore la lettre de motivation dans 90 % des cas
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Élimine en masse par manque de temps, pas de critères clairs
          </li>
        </ul>
      </div>
    </div>

    <!-- Conclusion MatchRH -->
    <div class="reveal rounded-2xl border p-8 md:p-12 text-center relative overflow-hidden"
         :class="dark ? 'bg-emerald-950/40 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
      <div class="absolute inset-0 pointer-events-none"
           style="background:radial-gradient(ellipse 60% 80% at 50% 100%,rgba(52,211,153,.07),transparent)"></div>
      <div class="relative">
        <div class="text-xl text-center mb-4">
        <flux:icon.scale class="size-10  mx-auto"/>

        </div>
        <h3 class="font-display font-bold text-2xl mb-3" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
          MatchRH rend le jeu équitable
        </h3>
        <p class="text-base max-w-lg mx-auto mb-6" :class="dark ? 'text-zinc-400' : 'text-zinc-600'">
          Vos compétences réelles sont évaluées sur des critères objectifs et structurés pas sur la beauté d'un PDF. Le meilleur profil gagne, pas le meilleur CV designer.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Compétences notées /5</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Expérience vérifiable</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Score visible avant candidature</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Pas de biais de présentation</span>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== PROBLÈMES ===== -->
<section id="probleme" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal mb-12">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Problème
      </div>
      <h2 class="font-display font-bold leading-tight mb-3" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Le recrutement classique est cassé
      </h2>
      <p class="text-base max-w-md" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Des centaines de candidatures par poste. Des heures perdues à trier des PDFs. MatchRH y met fin.
      </p>
    </div>

    <div class="grid sm:grid-cols-2 rounded-2xl overflow-hidden border"
         :class="dark ? 'border-zinc-800 bg-zinc-800' : 'border-zinc-200 bg-zinc-200'" style="gap:1px">
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.envelope class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Candidatures massives et non pertinentes</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Chaque offre attire des dizaines de profils inadaptés, noyant les bons candidats dans la masse.</p>
      </div>
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.clock class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Tri manuel chronophage</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Un recruteur passe en moyenne 6 secondes sur un CV. La qualité de la décision est sacrifiée pour la vitesse.</p>
      </div>
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.document class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Lettres de motivation jamais lues</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Étape vide de sens, supprimée chez nous. Une perte de temps pour toutes les parties.</p>
      </div>
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.folder class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Données non comparables</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Des compétences dispersées dans des PDFs impossibles à comparer objectivement entre candidats.</p>
      </div>
    </div>
  </div>
</section>


<!-- ===== SOLUTION / PROCESSUS ===== -->
<section id="solution" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-10">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Notre solution
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Matching en 4 étapes,<br><span class="grad-text">score transparent</span>
      </h2>
      <p class="text-base max-w-md mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Un algorithme déterministe. Pas de boîte noire chaque score est expliqué, visible et contestable.
      </p>
    </div>

    <!-- Steps -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 rounded-2xl overflow-hidden border mb-16"
         :class="dark ? 'border-zinc-800 bg-zinc-800' : 'border-zinc-200 bg-zinc-200'" style="gap:1px">
      <div class="p-6 reveal d1 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">01</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Critères bloquants</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Éliminatoires. Si un critère obligatoire n'est pas rempli, le score tombe à 0 automatiquement.</p>
      </div>
      <div class="p-6 reveal d2 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">02</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score principal pondéré</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">6 dimensions clés (compétences 50 %, expérience 20 %…) combinées en un score sur 100.</p>
      </div>
      <div class="p-6 reveal d3 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">03</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Points bonus</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Certifications, compétences rares, langues supplémentaires des points qui distinguent les excellents profils.</p>
      </div>
      <div class="p-6 reveal d4 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">04</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score final en %</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Un chiffre clair, visible avant même de postuler. Le candidat sait. Le recruteur a son classement.</p>
      </div>
    </div>

    <!-- Weights + Score preview -->
    <div class="grid md:grid-cols-2 gap-8">

      <!-- Barres de pondération -->
      <div class="reveal-l self-center">
        <p class="text-xs font-bold font-display uppercase tracking-widest mb-5"
           :class="dark ? 'text-emerald-400' : 'text-emerald-700'">Pondérations fixes & transparentes</p>
        <div class="space-y-4">
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Compétences</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" data-w="50" style="--w:50%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">50%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Expérience</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" data-w="20" style="--w:20%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">20%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Formation</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" data-w="10" style="--w:10%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">10%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Langues</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" data-w="10" style="--w:10%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">10%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Disponibilité</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" data-w="5" style="--w:5%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">5%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Localisation</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" data-w="5" style="--w:5%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">5%</div>
          </div>
        </div>
      </div>

      <!-- Score preview -->
      <div class="reveal-r rounded-2xl border p-6" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="flex items-center justify-between mb-5">
          <h4 class="font-display font-bold text-sm" :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Compatibilité estimée</h4>
          <span class="font-display font-extrabold text-4xl grad-text">84%</span>
        </div>
        <div class="space-y-3 mb-5">
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Compétences</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Excellent</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Expérience</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Langues</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Disponibilité</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Immédiate</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Localisation</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
        </div>
        <div class="pt-4 border-t" :class="dark ? 'border-zinc-800' : 'border-zinc-200'">
          <p class="text-xs mb-2" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Bonus cumulés</p>
          <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">+5 Sage Paie</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">+3 Excel avancé</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== FONCTIONNALITÉS ===== -->
<section id="fonctionnalites" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Fonctionnalités
      </div>
      <h2 class="font-display font-bold leading-tight" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Tout ce dont vous avez besoin,<br>rien de superflu
      </h2>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
      <div class="reveal d1 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.hand-raised class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Critères bloquants configurables</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Définissez vos exigences non-négociables. Tout le reste est auto-filtré avant même l'envoi de la candidature.</p>
      </div>
      <div class="reveal d2 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.star class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Système de bonus flexible</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Récompensez les compétences différenciantes avec des points bonus cumulables certifications, langues rares, expertises.</p>
      </div>
      <div class="reveal d3 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.chart-pie class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Classement automatique</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Les candidats arrivent déjà classés du plus compatible au moins compatible. Zéro tri manuel nécessaire.</p>
      </div>
      <div class="reveal d1 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.eye class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score visible avant candidature</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Le candidat voit sa compatibilité avant de postuler. Il s'auto-sélectionne moins de candidatures, bien meilleures.</p>
      </div>
      <div class="reveal d2 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.bell class="size-8"/>
    </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Notifications temps réel</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Alertes instantanées à chaque candidature qualifiée. Résumés périodiques de l'activité de vos offres.</p>
      </div>
      <div class="reveal d3 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.sparkles class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Recommandations IA</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Le système suggère proactivement des profils aux recruteurs et des offres adaptées aux candidats.</p>
      </div>
    </div>
  </div>
</section>


<!-- ===== MCP INTEGRATION ===== -->
<section id="mcp" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal rounded-2xl border overflow-hidden relative"
         :class="dark ? 'border-emerald-500/20' : 'border-emerald-300/60'">
      <div class="absolute inset-0 mcp-shimmer pointer-events-none"></div>
      <div class="relative p-8 md:p-12">
        <div class="flex flex-col lg:flex-row gap-10 items-start">

          <!-- Texte -->
          <div class="flex-1 self-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-5"
                 :class="dark ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400' : 'bg-emerald-50 border-emerald-300 text-emerald-700'">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse-slow"></span>
              Prochainement · MCP Integration
            </div>
            <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.5rem,3.5vw,2.25rem)"
                :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
              MatchRH dans votre<br>
              <span class="grad-text">IA préférée</span>
            </h2>
            <p class="text-base leading-relaxed mb-6" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
              Bientôt, recruteurs et candidats pourront interagir avec MatchRH directement depuis leurs outils IA (Claude, ChatGPT, Cursor, Copilot…) via le protocole <strong :class="dark ? 'text-zinc-200 font-semibold' : 'text-zinc-700 font-semibold'">MCP (Model Context Protocol)</strong>. Publiez des offres, consultez vos scores et recevez des recommandations sans quitter votre environnement de travail.
            </p>

            <div class="grid sm:grid-cols-2 gap-3 mb-8">
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <span class="text-lg shrink-0">
                      <flux:icon.sparkles class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Commandes en langage naturel</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">"Trouve les 3 meilleurs profils Laravel disponibles sous 30 jours"</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <span class="text-lg shrink-0">
                      <flux:icon.chart-bar class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Scores & recommandations</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Classements disponibles directement depuis votre assistant IA</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                <span class="text-lg shrink-0">

                    <flux:icon.document class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Création d'offres via l'IA</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Publiez une offre structurée en décrivant le poste à votre IA</p>
                </div>
              </div>
              <div class="flex items-start gap-3 p-4 rounded-xl border"
                   :class="dark ? 'bg-zinc-900/80 border-zinc-800' : 'bg-white border-zinc-200'">
                   <span class="text-lg shrink-0">
                       <flux:icon.star class="size-8"/>

                </span>
                <div>
                  <p class="text-sm font-semibold" :class="dark ? 'text-zinc-200' : 'text-zinc-800'">Alertes contextuelles</p>
                  <p class="text-xs mt-0.5" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Notifications dans votre outil habituel, sans changer d'application</p>
                </div>
              </div>
            </div>

            <div class="flex flex-wrap gap-3 items-center">
              <button class="px-5 py-2.5 rounded-xl font-display font-bold text-sm bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all">
                M'avertir à la sortie
              </button>
              <a href="#" class="text-sm underline underline-offset-4 decoration-dashed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
                En savoir plus sur MCP  <flux:icon.chevron-right class="size-4 inline-block ml-1"/>
              </a>
            </div>
          </div>

          <!-- Code block -->
        <div class="shrink-0 flex  self-center">
  <div class="rounded-xl overflow-hidden bg-zinc-900 border border-zinc-800 shadow-2xl font-mono text-xs text-zinc-300">

    <div class="flex items-center gap-2 px-4 py-3 bg-zinc-900/50 border-b border-zinc-800 select-none">
      <div class="flex gap-1.5">
        <span class="w-3 h-3 rounded-full bg-red-500/80 block"></span>
        <span class="w-3 h-3 rounded-full bg-amber-500/80 block"></span>
        <span class="w-3 h-3 rounded-full bg-emerald-500/80 block"></span>
      </div>
      <span class="ml-2 text-zinc-500 text-[11px]">matchrh-mcp.ts</span>
    </div>

    <div class="p-5 overflow-x-auto space-y-1">
      <div class="text-zinc-500">// Connexion MCP MatchRH</div>
      <div><span class="text-emerald-400">import</span> { MatchRH } <span class="text-emerald-400">from</span> <span class="text-amber-300">'matchrh-mcp'</span></div>
      <div class="h-2"></div>
      <div class="text-zinc-500">// Demander les top candidats</div>
      <div><span class="text-emerald-400">const</span> results = <span class="text-emerald-400">await</span> MatchRH.getTopCandidates({</div>
      <div class="pl-4">offreId: <span class="text-amber-300">'dev-laravel-001'</span>,</div>
      <div class="pl-4">limit: <span class="text-blue-400">5</span></div>
      <div>})</div>
      <div class="text-zinc-500">// [{ name: 'Jean', score: 92% },</div>
      <div class="text-zinc-500">//  { name: 'Marie', score: 89% }]</div>
    </div>

  </div>
</div>

        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== UTILISATEURS ===== -->
<section id="utilisateurs" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Utilisateurs
      </div>
      <h2 class="font-display font-bold leading-tight" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Deux profils, une même plateforme
      </h2>
    </div>

    <div class="grid md:grid-cols-2 gap-5 mb-8">
      <!-- Recruteur -->
      <div class="reveal-l rounded-2xl border overflow-hidden" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
        <div class="flex items-center gap-3 p-5 border-b" :class="dark ? 'border-zinc-800' : 'border-zinc-100'">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl border" :class="dark ? 'bg-indigo-500/10 border-indigo-500/20' : 'bg-indigo-50 border-indigo-200'">        <flux:icon.building-office class="size-8"/></div>
          <div>
            <p class="font-display font-bold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Recruteur</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Entreprises & DRH</p>
          </div>
        </div>
        <div class="p-5 space-y-3">
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Publie des offres structurées avec critères bloquants & bonus</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Reçoit uniquement des candidatures qualifiées, classées automatiquement</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Définit les critères éliminatoires (permis, expérience minimum…)</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Accède au résumé structuré de chaque candidat avec son score</span></div>
          <div class="flex flex-wrap gap-2 pt-2">
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Classement auto</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Critères bloquants</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Points bonus</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-zinc-800 border-zinc-700 text-zinc-300' : 'bg-zinc-100 border-zinc-200 text-zinc-600'">Notifs temps réel</span>
          </div>
        </div>
      </div>

      <!-- Candidat -->
      <div class="reveal-r rounded-2xl border overflow-hidden" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
        <div class="flex items-center gap-3 p-5 border-b" :class="dark ? 'border-zinc-800' : 'border-zinc-100'">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">        <flux:icon.users class="size-8"/></div>
          <div>
            <p class="font-display font-bold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Candidat</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Chercheurs d'emploi</p>
          </div>
        </div>
        <div class="p-5 space-y-3">
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Crée un profil structuré sans CV obligatoire</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Voit son score de compatibilité avant de postuler</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Répond aux questions de préqualification spécifiques</span></div>
          <div class="flex gap-3 text-sm"><span class="shrink-0 text-emerald-400 mt-0.5">→</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Reçoit des recommandations d'offres adaptées à son profil</span></div>
          <div class="space-y-2 pt-2">
            <div class="flex items-center gap-3 text-xs">
              <span class="w-14 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Laravel</span>
              <span class="text-emerald-400">★★★★★</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-14 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">MySQL</span>
              <span class="text-emerald-400">★★★★</span><span :class="dark ? 'text-zinc-700' : 'text-zinc-200'">★</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
              <span class="w-14 shrink-0" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Git</span>
              <span class="text-emerald-400">★★★</span><span :class="dark ? 'text-zinc-700' : 'text-zinc-200'">★★</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Classement table -->
    <div class="reveal rounded-2xl border overflow-hidden" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
      <div class="flex items-center justify-between p-5 border-b" :class="dark ? 'border-zinc-800' : 'border-zinc-100'">
        <h4 class="font-display font-bold text-sm" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Classement · Développeur Laravel</h4>
        <span class="px-3 py-1 rounded-lg text-xs font-bold border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">Classement automatique ✓</span>
      </div>
      <!-- Ligne 1 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(99,102,241,.15);border-color:rgba(99,102,241,.3);color:#818cf8">JD</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Jean Dupont</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev Full Stack · 5 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" style="width:92%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">92%</span>
        </div>
      </div>
      <!-- Ligne 2 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(34,197,94,.1);border-color:rgba(34,197,94,.25);color:#4ade80">MK</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Marie Kamga</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev Laravel · 4 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" style="width:89%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">89%</span>
        </div>
      </div>
      <!-- Ligne 3 -->
      <div class="flex items-center justify-between p-4 border-b transition-colors" :class="dark ? 'border-zinc-800 hover:bg-zinc-800/50' : 'border-zinc-100 hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.25);color:#fbbf24">AB</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Alain Bello</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev Backend · 3 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" style="width:85%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">85%</span>
        </div>
      </div>
      <!-- Ligne 4 -->
      <div class="flex items-center justify-between p-4 transition-colors" :class="dark ? 'hover:bg-zinc-800/50' : 'hover:bg-zinc-50'">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 border" style="background:rgba(239,68,68,.1);border-color:rgba(239,68,68,.2);color:#f87171">SN</div>
          <div>
            <p class="text-sm font-semibold" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Sophie Ngo</p>
            <p class="text-xs" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Dev PHP · 2 ans</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="hidden sm:block w-20 h-1.5 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-100'">
            <div class="h-full rounded-full bg-gradient-to-r from-emerald-600 to-emerald-400" style="width:78%"></div>
          </div>
          <span class="font-display font-bold text-sm" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">78%</span>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== TARIFS ===== -->
<section id="tarifs" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-6">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Tarifs
      </div>
      <h2 class="font-display font-bold leading-tight mb-3" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        100% Gratuit.<br>
        <span class="grad-text">Et c'est notre force.</span>
      </h2>
      <p class="text-base max-w-lg mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Pas de freemium, pas de fonctionnalités cachées derrière un paywall. La gratuité totale est notre avantage concurrentiel elle nous permet d'atteindre une masse critique de candidats et de recruteurs plus vite que n'importe quel concurrent.
      </p>
    </div>

    <!-- Argument marketing -->
    <div class="reveal my-8 p-5 rounded-2xl border flex gap-4 items-start"
         :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
      <span class="text-2xl shrink-0">        <flux:icon.light-bulb class="size-8"/></span>
      <div>
        <p class="font-display font-bold text-sm mb-1" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Notre avantage stratégique</p>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
          Les plateformes payantes créent une barrière les meilleurs talents ne paient pas pour chercher un emploi, et les PME ne paient pas pour recruter des profils incertains. En étant entièrement gratuit, MatchRH agrège le marché plus vite, crée de la valeur pour tous, et construit la réputation qui fera sa pérennité.
        </p>
      </div>
    </div>

    <!-- Plans -->
    <div class="grid sm:grid-cols-3 gap-5 mt-10">

      <!-- Candidat -->
      <div class="price-card reveal d1 rounded-2xl border overflow-hidden flex flex-col"
           :class="dark ? 'border-zinc-800 bg-zinc-900' : 'border-zinc-200 bg-white'">
        <div class="p-6 flex flex-col flex-1">
          <p class="font-display font-bold text-sm mb-1" :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Candidat</p>
          <div class="flex items-baseline gap-1 mb-1">
            <span class="font-display font-extrabold text-4xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Gratuit</span>
          </div>
          <p class="text-xs mb-6" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Pour tous les chercheurs d'emploi</p>
          <div class="space-y-3 flex-1 mb-6">
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Profil structuré complet</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Score de compatibilité visible</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Candidatures illimitées</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Recommandations d'offres</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Notifications en temps réel</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">CV optionnel (pas requis)</span></div>
          </div>
          <button class="w-full py-3 rounded-xl font-display font-bold text-sm border transition-all"
                  :class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800' : 'border-zinc-200 text-zinc-600 hover:border-zinc-400 hover:bg-zinc-50'">
            Créer mon profil
          </button>
        </div>
      </div>

      <!-- Recruteur PMEshrink-0Featured -->
      <div class="price-card reveal d2 rounded-2xl border overflow-hidden flex flex-col"
           :class="dark ? 'border-emerald-500/40 bg-emerald-950/40' : 'border-emerald-300 bg-emerald-50/60'">
        <div class="py-2 text-center text-xs font-bold font-display tracking-widest uppercase"
             :class="dark ? 'bg-emerald-500/20 text-emerald-400' : 'bg-emerald-100 text-emerald-700'">
          ⭐ Le plus populaire
        </div>
        <div class="p-6 flex flex-col flex-1">
          <p class="font-display font-bold text-sm mb-1" :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Recruteur PME</p>
          <div class="flex items-baseline gap-1 mb-1">
            <span class="font-display font-extrabold text-4xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Gratuit</span>
          </div>
          <p class="text-xs mb-6" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">La solution complète sans limite</p>
          <div class="space-y-3 flex-1 mb-6">
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Offres d'emploi illimitées</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Critères bloquants & bonus</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Classement automatique des candidats</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Notifications & résumés périodiques</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Tableau de bord recruteur</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Support prioritaire</span></div>
          </div>
          <button class="w-full py-3 rounded-xl font-display font-bold text-sm bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all">
            Commencer à recruter
          </button>
        </div>
      </div>

      <!-- Entreprise -->
      <div class="price-card reveal d3 rounded-2xl border overflow-hidden flex flex-col"
           :class="dark ? 'border-zinc-800 bg-zinc-900' : 'border-zinc-200 bg-white'">
        <div class="p-6 flex flex-col flex-1">
          <p class="font-display font-bold text-sm mb-1" :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Entreprise</p>
          <div class="flex items-baseline gap-1 mb-1">
            <span class="font-display font-extrabold text-4xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Gratuit</span>
          </div>
          <p class="text-xs mb-6" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Fonctionnalités avancées à venir</p>
          <div class="space-y-3 flex-1 mb-6">
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Tout Recruteur PME inclus</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Multi-utilisateurs & équipes RH</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400">✓</span><span :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Statistiques & reporting avancé</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400 text-xs">🔜</span><span :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Intégration MCP (à venir)</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400 text-xs">🔜</span><span :class="dark ? 'text-zinc-400' : 'text-zinc-500'">API privée & webhooks (à venir)</span></div>
            <div class="flex items-start gap-2.5 text-sm"><span class="shrink-0 mt-0.5 text-emerald-400 text-xs">🔜</span><span :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Account manager dédié (à venir)</span></div>
          </div>
          <button class="w-full py-3 rounded-xl font-display font-bold text-sm border transition-all"
                  :class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800' : 'border-zinc-200 text-zinc-600 hover:border-zinc-400 hover:bg-zinc-50'">
            Rejoindre la liste d'attente
          </button>
        </div>
      </div>
    </div>

    <!-- Trust badges -->
    <div class="reveal mt-10 flex flex-wrap justify-center gap-5 text-sm" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">
      <span>✓ Aucune carte bancaire requise</span>
      <span>✓ Aucune limite cachée</span>
      <span>✓ Données protégées (Loi camerounaise 2024)</span>
      <span>✓ Gratuit pour toujours sur les offres de base</span>
    </div>
  </div>
</section>


{{-- ═══════════════════════════════════════════════════
     TÉMOIGNAGES scroll-snap mobile / carousel JS desktop
═══════════════════════════════════════════════════ --}}
<section
    id="avis"
    class="overflow-hidden bg-white py-16 dark:bg-zinc-950 sm:py-20"
    x-data="testimonialCarousel()"
    x-init="init()"
>
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        {{-- ── En-tête ── --}}
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-400/20 dark:text-emerald-300">
                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                    Ils avancent avec Squarhe
                </span>
                <h2 class="mt-4 text-2xl font-black leading-tight text-slate-950 dark:text-zinc-300 sm:text-3xl lg:text-4xl">
                    Des PME camerounaises qui ont remplacé Excel.
                </h2>
            </div>

            {{-- Contrôles masqués sur mobile (scroll natif suffit) --}}
            <div class="hidden items-center gap-2 sm:flex">
                <button x-on:click="prev()" class="grid size-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800" aria-label="Précédent">
                    <svg class="size-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
                </button>
                <button x-on:click="togglePause()" class="grid size-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800" :aria-label="paused ? 'Reprendre' : 'Pause'">
                    <svg x-show="!paused" class="size-4" viewBox="0 0 20 20" fill="currentColor"><path d="M5.75 3a.75.75 0 0 0-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75V3.75A.75.75 0 0 0 7.25 3h-1.5ZM12.75 3a.75.75 0 0 0-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75V3.75a.75.75 0 0 0-.75-.75h-1.5Z"/></svg>
                    <svg x-show="paused" class="size-4" viewBox="0 0 20 20" fill="currentColor"><path d="M6.3 2.84A1.5 1.5 0 0 0 4 4.11v11.78a1.5 1.5 0 0 0 2.3 1.27l9.344-5.891a1.5 1.5 0 0 0 0-2.538L6.3 2.84Z"/></svg>
                </button>
                <button x-on:click="next()" class="grid size-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800" aria-label="Suivant">
                    <svg class="size-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                </button>
                <span class="ml-1 text-sm font-bold tabular-nums text-slate-400 dark:text-zinc-500">
                    <span x-text="current + 1"></span><span class="text-slate-300 dark:text-zinc-700">/</span><span x-text="total"></span>
                </span>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             MOBILE : scroll snap natif (< sm)
        ══════════════════════════════════════════ --}}
        <div class="mt-8 sm:hidden">
            <div
                class="flex gap-3 overflow-x-auto pb-2"
                style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none;"
                x-ref="mobileTrack"
            >
                @php
                $testimonials_data = [
                    ['name' => 'Ariane M.', 'role' => 'Directrice administrative', 'location' => 'Douala', 'sector' => 'Cabinet d\'architecture', 'result' => 'La validation de paie prend maintenant 20 minutes, contre 2 jours avant.', 'quote' => 'Squarhe nous donne une vision claire de la paie avant validation. Les équipes gagnent du temps sans perdre le contrôle.'],
                    ['name' => 'Patrick N.', 'role' => 'Fondateur', 'location' => 'Yaoundé', 'sector' => 'PME services', 'result' => 'Zéro oubli de variable depuis que nous utilisons Squarhe.', 'quote' => 'La plateforme a transformé nos fins de mois. Les variables sont suivies, les oublis diminuent et les bulletins partent plus vite.'],
                    ['name' => 'Nadia E.', 'role' => 'Responsable RH', 'location' => 'Douala', 'sector' => 'Distribution', 'result' => 'Les demandes de congés sont traitées en 1 clic au lieu de passer par WhatsApp.', 'quote' => 'J\'aime la simplicité de Squarhe. Les collaborateurs comprennent leurs espaces et les managers suivent les demandes sans relance.'],
                    ['name' => 'Brice T.', 'role' => 'Gérant', 'location' => 'Bafoussam', 'sector' => 'Commerce', 'result' => 'Un historique CNPS propre et accessible en quelques secondes.', 'quote' => 'On a remplacé les fichiers dispersés par une base fiable. Les contrôles sont plus rapides et les décisions plus sereines.'],
                    ['name' => 'Mireille K.', 'role' => 'Office Manager', 'location' => 'Douala', 'sector' => 'BTP', 'result' => 'Notre équipe de 30 personnes gérée sans service RH dédié.', 'quote' => 'Squarhe nous aide à rester organisés même avec une petite équipe RH. Tout est lisible et accessible au bon moment.'],
                    ['name' => 'Samuel F.', 'role' => 'CEO', 'location' => 'Yaoundé', 'sector' => 'Agence digitale', 'result' => 'La paie automatisée sans perdre la main sur les validations importantes.', 'quote' => 'La vision produit est excellente : automatiser la paie tout en gardant l\'humain au centre des validations importantes.'],
                    ['name' => 'Clarisse B.', 'role' => 'Comptable', 'location' => 'Douala', 'sector' => 'Services financiers', 'result' => 'Je vois en temps réel l\'impact de chaque variable sur la masse salariale.', 'quote' => 'Les impacts en temps réel sur la paie sont rassurants. Je vois tout de suite ce qui change et pourquoi.'],
                    ['name' => 'Eric D.', 'role' => 'Directeur Général', 'location' => 'Douala', 'sector' => 'Industrie légère', 'result' => 'Une discipline RH qu\'on n\'arrivait pas à installer avec Excel.', 'quote' => 'Squarhe apporte une discipline RH qui manquait à notre croissance. C\'est simple, structuré et très concret.'],
                    ['name' => 'Joëlle S.', 'role' => 'Chargée d\'administration', 'location' => 'Limbé', 'sector' => 'ONG', 'result' => 'Retrouver un contrat ou un bulletin prend 10 secondes, pas 10 minutes.', 'quote' => 'Les documents RH sont enfin centralisés. Nous retrouvons les contrats et bulletins sans fouiller dans plusieurs dossiers.'],
                    ['name' => 'Marc L.', 'role' => 'DAF', 'location' => 'Douala', 'sector' => 'Import-Export', 'result' => 'Zéro retard sur nos déclarations CNPS cette année.', 'quote' => 'La conformité est mieux suivie et les mises à jour rassurent la direction. C\'est un vrai gain de fiabilité.'],
                    ['name' => 'Kevin O.', 'role' => 'Entrepreneur', 'location' => 'Kribi', 'sector' => 'Hôtellerie', 'result' => 'La paie de 45 saisonniers gérée sans stress ni erreur.', 'quote' => 'Squarhe rend la paie moins stressante. Les processus sont guidés et les erreurs deviennent beaucoup plus faciles à détecter.'],
                    ['name' => 'Oscar W.', 'role' => 'Fondateur', 'location' => 'Douala', 'sector' => 'Cabinet conseil', 'result' => 'Un outil qui connaît la CNPS, le Code du travail camerounais et nos réalités.', 'quote' => 'Squarhe comprend les réalités locales. Ce n\'est pas un outil générique plaqué sur nos contraintes.'],
                ];
                @endphp

                {{-- Padding left pour que la première card soit bien centrée --}}
                <div class="w-5 shrink-0"></div>

                @foreach ($testimonials_data as $t)
                    <div
                        class="flex w-[85vw] shrink-0 flex-col rounded-2xl border border-slate-200/80 bg-slate-50 p-5 dark:border-zinc-800 dark:bg-zinc-900"
                        style="scroll-snap-align: center;"
                    >
                        <div class="flex items-center gap-0.5" aria-label="5 étoiles">
                            @for ($s = 0; $s < 5; $s++)
                                <svg class="size-4 text-amber-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd"/></svg>
                            @endfor
                        </div>
                        <div class="mt-4 inline-flex items-start gap-2 rounded-lg bg-emerald-100/80 px-3 py-2 dark:bg-emerald-400/10">
                            <svg class="mt-0.5 size-3.5 shrink-0 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                            <p class="text-xs font-bold leading-5 text-emerald-800 dark:text-emerald-300">{{ $t['result'] }}</p>
                        </div>
                        <p class="mt-4 flex-1 text-sm leading-7 text-slate-600 dark:text-zinc-400">"{{ $t['quote'] }}"</p>
                        <div class="mt-5 flex items-center gap-3 border-t border-slate-200/80 pt-4 dark:border-zinc-800">
                            <div class="grid size-9 shrink-0 place-items-center rounded-full bg-slate-200 text-sm font-black text-slate-700 dark:bg-zinc-800 dark:text-zinc-200">
                                {{ mb_substr($t['name'], 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-black text-slate-950 dark:text-zinc-400">{{ $t['name'] }}</p>
                                <p class="truncate text-xs text-slate-500 dark:text-zinc-400">{{ $t['role'] }} · {{ $t['sector'] }}</p>
                            </div>
                            <span class="ml-auto shrink-0 text-xs text-slate-400">📍 {{ $t['location'] }}</span>
                        </div>
                    </div>
                @endforeach

                <div class="w-5 shrink-0"></div>
            </div>

            {{-- Indicateur swipe --}}
            <p class="mt-3 text-center text-xs text-slate-400 dark:text-zinc-500">← Glissez pour voir plus →</p>
        </div>

        {{-- ══════════════════════════════════════════
             DESKTOP : carousel JS (sm+)
        ══════════════════════════════════════════ --}}
        <div class="relative mt-10 hidden overflow-hidden sm:block">
            <div
            data-carousel-track
                class="flex transition-transform duration-700 ease-in-out will-change-transform"
                :style="`transform: translateX(-${current * (100 / visibleCount)}%)`"
            >
                @foreach ($testimonials_data as $t)
                    <div
                        class="shrink-0 px-2"
                        :style="`width: ${100 / visibleCount}%`"
                        style="width: 50%"
                    >
                        <div class="flex h-full flex-col rounded-2xl border border-slate-200/80 bg-slate-50 p-6 dark:border-zinc-800 dark:bg-zinc-900">
                            <div class="flex items-center gap-0.5" aria-label="5 étoiles">
                                @for ($s = 0; $s < 5; $s++)
                                    <svg class="size-4 text-amber-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd"/></svg>
                                @endfor
                            </div>
                            <div class="mt-4 inline-flex items-start gap-2 rounded-lg bg-emerald-100/80 px-3 py-2 dark:bg-emerald-400/10">
                                <svg class="mt-0.5 size-3.5 shrink-0 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                                <p class="text-xs font-bold leading-5 text-emerald-800 dark:text-emerald-300">{{ $t['result'] }}</p>
                            </div>
                            <p class="mt-4 flex-1 text-sm leading-7 text-slate-600 dark:text-zinc-400">"{{ $t['quote'] }}"</p>
                            <div class="mt-5 flex items-center gap-3 border-t border-slate-200/80 pt-4 dark:border-zinc-800">
                                <div class="grid size-9 shrink-0 place-items-center rounded-full bg-slate-200 text-sm font-black text-slate-700 dark:bg-zinc-800 dark:text-zinc-200">
                                    {{ mb_substr($t['name'], 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-black text-slate-950 dark:text-zinc-400">{{ $t['name'] }}</p>
                                    <p class="truncate text-xs text-slate-500 dark:text-zinc-400">{{ $t['role'] }} · {{ $t['sector'] }}</p>
                                </div>
                                <span class="ml-auto shrink-0 text-xs text-slate-400">📍 {{ $t['location'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Fades latéraux --}}
            <div class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-white to-transparent dark:from-zinc-950"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white to-transparent dark:from-zinc-950"></div>
        </div>

        {{-- Dots desktop --}}
        <div class="mt-6 hidden items-center justify-center gap-1.5 sm:flex">
            @foreach ($testimonials_data as $i => $t)
                <button
                    x-on:click="goTo({{ $i }})"
                    class="rounded-full transition-all duration-300"
                    :class="{{ $i }} === current ? 'w-6 h-2 bg-slate-950 dark:bg-zinc-50' : 'size-2 bg-slate-300 hover:bg-slate-400 dark:bg-zinc-700/60'"
                    aria-label="Témoignage {{ $i + 1 }}"
                ></button>
            @endforeach
        </div>

    </div>
</section>

   {{-- ═══════════════════════════════════════════════════
                     FAQ Réponses enrichies
                ═══════════════════════════════════════════════════ --}}
                <section id="faq" class="border-y border-slate-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
                    <div class="mx-auto max-w-4xl px-5 py-12 sm:py-16 lg:px-8">
                        <div class="text-left sm:text-center">
                            <p class="text-sm font-black uppercase text-emerald-700">Foire aux questions</p>
                            <h2 class="mt-3 text-2xl font-black leading-tight text-slate-950 sm:text-4xl">Tout ce que vous voulez savoir avant de nous contacter.</h2>
                        </div>
                        <div class="mt-8 space-y-3 sm:mt-10">
                            @foreach ($faqs as $index => $faq)
                                <details class="group rounded-lg border border-slate-200 bg-slate-50 p-4 open:bg-white open:shadow-lg dark:border-zinc-800 dark:bg-zinc-900 dark:open:bg-zinc-800 sm:p-5" @if ($index === 0) open @endif>
                                    <summary class="flex min-h-12 cursor-pointer list-none items-center justify-between gap-4 font-black text-slate-950 dark:text-zinc-400 sm:gap-5">
                                        <span>{{ $faq['question'] }}</span>
                                        <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-slate-200 text-slate-700 transition group-open:rotate-45 dark:bg-zinc-800 dark:text-zinc-200"><flux:icon.plus class="size-4" /></span>
                                    </summary>
                                    <p class="mt-4 leading-8 text-slate-600 dark:text-zinc-400">{{ $faq['answer'] }}</p>
                                </details>
                            @endforeach
                        </div>

                        <div class="mt-8 rounded-lg border border-slate-200 bg-slate-50 p-5 text-center dark:border-zinc-800 dark:bg-zinc-900">
                            <p class="font-bold text-slate-700 dark:text-zinc-400">Vous avez une question spécifique à votre situation ?</p>
                            <flux:button href="#contact" variant="primary" class="mt-4">
                                Parlez-nous de votre PME
                            </flux:button>
                        </div>
                    </div>
                </section>
<!-- ===== CTA ===== -->
<section class="py-24 px-5 transition-colors duration-300" :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal relative rounded-3xl border overflow-hidden p-10 md:p-16 text-center"
         :class="dark ? 'bg-emerald-950/40 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
      <div class="absolute inset-0 pointer-events-none"
           style="background:radial-gradient(ellipse 60% 80% at 50% 100%,rgba(52,211,153,.09),transparent)"></div>
      <div class="relative">
        <h2 class="font-display font-extrabold leading-tight mb-4" style="font-size:clamp(1.8rem,5vw,3.2rem)"
            :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
          Prêt à recruter<br>
          <span class="grad-text">sans friction ?</span>
        </h2>
        <p class="text-base max-w-md mx-auto mb-8" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
          Rejoignez la plateforme qui met fin au tri manuel. Commencez gratuitement dès maintenant aucune carte bancaire requise.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
          <button class="px-8 py-3.5 rounded-xl font-display font-bold bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-500/20">
            Créer un compte gratuit
          </button>
          <button class="px-8 py-3.5 rounded-xl font-medium border transition-all hover:-translate-y-0.5"
                  :class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800/50' : 'border-zinc-300 text-zinc-600 hover:border-zinc-400 hover:bg-white'">
            Parler à un expert  <flux:icon.chevron-right class="size-4 inline-block ml-1"/>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== FOOTER ===== -->
 <footer   :class="dark ? 'bg-zinc-900/50 border-zinc-800' : 'bg-white border-zinc-200'">
                <div class="mx-auto max-w-7xl px-5 lg:px-8">

                    {{-- ── Colonnes de liens ── --}}
                    <div class="grid grid-cols-2 gap-8 py-12 sm:grid-cols-2 lg:grid-cols-4">

                        {{-- Produit --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Produit</p>
                            <ul class="mt-4 space-y-3">
                                @foreach ([
                                    ['label' => 'Tarifs',        'href' => '#offres'],
                                    ['label' => 'Solution',      'href' => '#solution'],
                                    ['label' => 'Fonctionnalités','href' => '#solution'],
                                    ['label' => 'Sécurité',      'href' => '#securite'],
                                ] as $link)
                                    <li>
                                        <a href="{{ $link['href'] }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                        {{-- Légal --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Légal</p>
                            <ul class="mt-4 space-y-3">
                                @foreach ([
                                    ['label' => 'CGU',               'route' => 'legal.cgu'],
                                    ['label' => 'CGV',               'route' => 'legal.cgv'],
                                    ['label' => 'Code du travail','route' => 'legal.travail'],
                                    ['label' => 'Politique de cookies','route' => 'legal.cookies'],
                                ] as $link)
                                    <li>
                                        {{-- {{ route($link['route']) }} --}}
                                        <a href="#" wire:navigate class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Contact --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Contact</p>
                            <ul class="mt-4 space-y-3">
                                <li>
                                    <a href="#contact" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                        Demander une démo
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:contact@fallabolo.com" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                        contact@fallabolo.com
                                    </a>
                                </li>
                                <li>
                                    <a href="#newsletter" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                        Newsletter RH
                                    </a>
                                </li>
                            </ul>
                        </div>


                        {{-- Ressources --}}
                        <div>
                            <p class="text-sm font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ressources</p>
                            <ul class="mt-4 space-y-3">
                                @foreach ([
                                    ['label' => 'FAQ',            'href' => '#faq'],
                                    ['label' => 'Témoignages',    'href' => '#avis'],
                                ] as $link)
                                    <li>
                                        <a href="{{ $link['href'] }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- ── Barre inférieure : logo + copyright + réseaux ── --}}
                    <div class="border-t border-slate-100 py-6 dark:border-zinc-800">

                        {{-- Ligne logo + statut --}}
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            {{-- Logo --}}
                            <a href="#top" class="flex items-center gap-3">
                                <span class="grid size-8 place-items-center rounded-lg bg-slate-950 text-white dark:bg-zinc-50 dark:text-zinc-950">
                                    sq
                                </span>
                                <span class="text-base font-black  :class="dark ? 'text-zinc-100' : 'text-zinc-900'"" >fallabolo</span>
                            </a>

                            {{-- Statut opérationnel --}}
                            <div class="">
                            <div class="flex items-center gap-2">
                                <span class="size-2 rounded-full bg-emerald-500"></span>
                                <span class="text-sm font-semibold text-slate-500 dark:text-zinc-400">Tous les services sont opérationnels</span>
                            </div>
                            </div>

                        </div>

                        {{-- Ligne copyright + réseaux sociaux --}}
                        <div class="mt-5 flex flex-col gap-4 border-t border-slate-200/70 pt-5 dark:border-zinc-800 sm:flex-row sm:items-center sm:justify-between">

                            <p class="text-sm text-slate-400 dark:text-zinc-500">
                                © {{ date('Y') }} fallabolo. Tous droits réservés. Conçu pour les PME camerounaises.
                            </p>

                            {{-- Icônes réseaux sociaux --}}
                            <div class="flex items-center gap-4">
                                {{-- LinkedIn --}}
                                <a href="https://www.linkedin.com/company/fallabolo" aria-label="fallabolo sur LinkedIn" class="text-slate-400 transition hover:text-slate-950 dark:hover:text-zinc-50">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M19 3A2 2 0 0 1 21 5V19A2 2 0 0 1 19 21H5A2 2 0 0 1 3 19V5A2 2 0 0 1 5 3H19M18.5 18.5V13.2A3.26 3.26 0 0 0 15.24 9.94C14.39 9.94 13.4 10.46 12.92 11.24V10.13H10.13V18.5H12.92V13.57A1.46 1.46 0 0 1 14.38 12.11A1.46 1.46 0 0 1 15.84 13.57V18.5H18.5M6.88 8.56A1.68 1.68 0 0 0 8.56 6.88A1.68 1.68 0 0 0 6.88 5.2A1.68 1.68 0 0 0 5.2 6.88A1.68 1.68 0 0 0 6.88 8.56M8.27 18.5V10.13H5.5V18.5H8.27Z"/>
                                    </svg>
                                </a>
                                {{-- X / Twitter--}}
                                <a href="https://youtube.com/@fallabolo?si=1l9db4ZVM2HCUPxT" aria-label="fallabolo sur X" class="text-slate-400 transition hover:text-slate-950 dark:hover:text-zinc-50">
                                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                </a>
                                {{-- WhatsApp --}}
                                <a href="https://wa.me/237659005679" aria-label="fallabolo sur WhatsApp" class="text-slate-400 transition hover:text-slate-950 dark:hover:text-zinc-50">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                                    </svg>
                                </a>
                            </div>
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
