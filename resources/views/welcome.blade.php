<!DOCTYPE html>
<html lang="fr" x-data="{ dark: localStorage.getItem('theme') !== 'light', mobileOpen: false }" :class="dark ? 'dark' : ''" class="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MatchRH Recrutement Intelligent</title>
<meta name="description" content="MatchRH est la plateforme de recrutement intelligente qui utilise un scoring algorithmique transparent pour connecter les talents et les entreprises sans tri manuel de CV au Cameroun.">
<meta name="keywords" content="recrutement, RH, matching, algorithme, emploi, Cameroun, sans CV, scoring, recrutement intelligent">
<meta property="og:title" content="MatchRH - Recrutement Intelligent sans CV">
<meta property="og:description" content="Connectez-vous aux meilleurs talents grâce au matching algorithmique transparent.">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="MatchRH - Recrutement Intelligent sans CV">
<meta name="twitter:description" content="La plateforme qui met fin au tri manuel des CV.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

  @fluxAppearance

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

       @php
    $faqs = [
        [
            'question' => 'Dois-je obligatoirement envoyer un CV pour postuler ?',
            'answer'   => 'Non, le CV est entièrement optionnel sur MatchRH. Vous créez un profil structuré (compétences notées /5, expériences vérifiables, langues, disponibilité) et c\'est lui qui génère votre score de compatibilité. Si vous avez un CV, vous pouvez l\'attacher, mais il n\'est jamais un prérequis pour postuler.',
        ],
        [
            'question' => 'Comment est calculé mon score de compatibilité ?',
            'answer'   => 'Le score est entièrement transparent et déterministe pas de boîte noire. Il repose sur 6 dimensions pondérées : compétences (50 %), expérience (20 %), formation (10 %), langues (10 %), disponibilité (5 %) et localisation (5 %). Des points bonus s\'ajoutent pour les certifications et expertises rares. Chaque critère est visible avant même que vous postuliez.',
        ],
        [
            'question' => 'Puis-je voir mon score avant de postuler à une offre ?',
            'answer'   => 'Oui, c\'est l\'une des fonctionnalités clés de MatchRH. Avant chaque candidature, vous voyez votre compatibilité estimée et sa décomposition détaillée. Vous pouvez ainsi postuler en connaissance de cause ou améliorer votre profil pour augmenter votre score.',
        ],
        [
            'question' => 'Je suis recruteur : combien coûte la plateforme ?',
            'answer'   => 'MatchRH est entièrement gratuit, sans limite cachée. Offres illimitées, candidatures illimitées, classement automatique, notifications temps réel tout est inclus sans carte bancaire requise. La gratuité totale est notre avantage stratégique : elle permet d\'agréger rapidement la masse critique de candidats et de recruteurs.',
        ],
        [
            'question' => 'Qu\'est-ce qu\'un critère bloquant et comment ça fonctionne ?',
            'answer'   => 'Un critère bloquant est une exigence non-négociable définie par le recruteur permis de conduire, niveau d\'expérience minimum, localisation, etc. Si le candidat ne satisfait pas ce critère, son score tombe automatiquement à 0 et sa candidature n\'apparaît pas dans le classement. Les recruteurs ne voient que des profils réellement éligibles.',
        ],
        [
            'question' => 'Comment MatchRH protège-t-il mes données personnelles ?',
            'answer'   => 'Vos données sont hébergées conformément à la loi camerounaise sur la protection des données personnelles (2024). Les accès sont contrôlés par rôle, les actions importantes sont tracées, et vous pouvez demander la suppression de votre profil à tout moment. Vos informations ne sont jamais revendues à des tiers.',
        ],
        [
            'question' => 'Qu\'est-ce que l\'intégration MCP annoncée sur la plateforme ?',
            'answer'   => 'MCP (Model Context Protocol) est un protocole qui permettra d\'interagir avec MatchRH directement depuis des assistants IA (Claude, ChatGPT, Cursor…). Recruteurs et candidats pourront consulter des classements, publier des offres et recevoir des recommandations en langage naturel, sans quitter leur outil habituel. Cette fonctionnalité est en cours de développement.',
        ],
        [
            'question' => 'L\'algorithme de matching est-il biaisé ?',
            'answer'   => 'Le scoring de MatchRH est intentionnellement déterministe et documenté pour minimiser les biais. Il n\'évalue pas la photo, le nom, le sexe ou l\'âge uniquement les compétences, l\'expérience et les critères objectifs définis par le recruteur. Chaque score est décomposé et contestable. L\'objectif : le meilleur profil gagne, pas le meilleur CV designer.',
        ],
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
        <div class="flex items-center justify-between border-b border-slate-200/80 px-5 py-4 dark:border-zinc-800 " >
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
            class="transition-all duration-300 ease-in-out w-full "
            :class="scrolled
                ? 'mx-4 max-w-5xl rounded-full  shadow-[0_8px_32px_-4px_rgba(0,0,0,0.12),0_0_0_1px_rgba(0,0,0,0.04)] backdrop-blur-md   dark:shadow-[0_8px_32px_-4px_rgba(16,185,129,0.2),0_0_24px_0_rgba(16,185,129,0.15)] px-4 py-2'
                : 'backdrop-blur px-5 py-4 lg:px-8'"
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
                    <span                        class="font-black tracking-normal text-slate-950 dark:text-zinc-400 transition-all duration-300"                        :class="scrolled ? 'text-base ' : 'text-lg'"                    >fallabolo</span>
                </a>

                {{-- Liens desktop --}}
                <div
                    class="hidden items-center text-slate-600 dark:text-zinc-400 md:flex transition-all duration-300"
                    :class="scrolled ? 'gap-5 text-sm font-medium' : 'gap-7 text-sm font-semibold'"
                >

                <a href="#valeur"          :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Proposition de valeur</a>
                <a href="#probleme"        :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Problème</a>
                <a href="#solution"        :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Solution</a>
                <a href="#fonctionnalites" :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Fonctionnalités</a>
                <a href="#mcp"             :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">MCP</a>
                <a href="#tarifs"          :class="dark ? ' text-zinc-300 hover:text-emerald-400' : 'text-zinc-600 hover:text-emerald-600'">Tarifs</a>
               <button @click="dark=!dark; localStorage.setItem('theme', dark ? 'dark' : 'light')"
                        class="w-9 h-9 flex items-center justify-center rounded-xl  text-sm transition-all cursor-pointer"
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
<div class="h-16.25"></div>



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
{{-- ═══════════════════════════════════════════════════════════════════════
     SECTION TÉMOIGNAGES
     — À insérer après #utilisateurs, avant #tarifs
     — Le script Alpine est dans resources/js/testimonial-carousel.js
       (importé dans app.js via : import './testimonial-carousel')
     ═══════════════════════════════════════════════════════════════════════ --}}

@php
$testimonials = [
    [
        'initials' => 'MK',
        'name'     => 'Marie Kamga',
        'role'     => 'Responsable RH',
        'company'  => 'TechCom Cameroun',
        'color'    => 'emerald',
        'stars'    => 5,
        'badge'    => 'Recruteur',
        'quote'    => 'En 3 ans de recrutement je n\'avais jamais reçu des candidatures aussi qualifiées dès le premier jour. Le classement automatique m\'a fait économiser deux jours de travail sur notre dernière campagne.',
    ],
    [
        'initials' => 'JN',
        'name'     => 'Jean-Paul Nkoa',
        'role'     => 'Développeur Full Stack',
        'company'  => 'Indépendant, Yaoundé',
        'color'    => 'indigo',
        'stars'    => 5,
        'badge'    => 'Candidat',
        'quote'    => 'Voir mon score avant de postuler a tout changé. Je cible uniquement les offres où je dépasse 80 %. J\'ai décroché mon poste actuel en 12 jours.',
    ],
    [
        'initials' => 'SB',
        'name'     => 'Sophie Bello',
        'role'     => 'DG',
        'company'  => 'Agence Digit+ Douala',
        'color'    => 'amber',
        'stars'    => 5,
        'badge'    => 'Recruteur',
        'quote'    => 'On avait l\'habitude de recevoir 150 CVs par poste. Avec MatchRH on en reçoit 25, toutes pertinentes. Les critères bloquants font le filtre à notre place.',
    ],
    [
        'initials' => 'AM',
        'name'     => 'Alain Mfoumou',
        'role'     => 'Comptable Senior',
        'company'  => 'Bafoussam',
        'color'    => 'sky',
        'stars'    => 5,
        'badge'    => 'Candidat',
        'quote'    => 'Sans CV obligatoire, j\'ai pu me concentrer sur ce que je sais vraiment faire. Mon profil reflète mes vraies compétences — le recruteur m\'a rappelé en 48 h.',
    ],
    [
        'initials' => 'FE',
        'name'     => 'Fatima Essomba',
        'role'     => 'Head of Talent',
        'company'  => 'FinServ Africa',
        'color'    => 'rose',
        'stars'    => 5,
        'badge'    => 'Recruteur',
        'quote'    => 'L\'algorithme est transparent — chaque score est décomposé, explicable. Nos équipes l\'ont adopté sans résistance parce qu\'elles comprennent la logique. Pas de boîte noire.',
    ],
    [
        'initials' => 'PN',
        'name'     => 'Patrick Nguema',
        'role'     => 'Ingénieur Réseaux',
        'company'  => 'Douala',
        'color'    => 'teal',
        'stars'    => 5,
        'badge'    => 'Candidat',
        'quote'    => 'J\'ai passé des mois à adapter mon CV sans résultats. Sur MatchRH j\'ai rempli mon profil une fois et les offres viennent à moi. Le système de recommandations est vraiment efficace.',
    ],
];

// Palette par couleur : classes Tailwind pour dark / light
$palette = [
    'emerald' => [
        'avatar_dark'  => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/25',
        'avatar_light' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'badge_dark'   => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
        'badge_light'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'stars'        => 'text-emerald-400',
    ],
    'indigo'  => [
        'avatar_dark'  => 'bg-indigo-500/15 text-indigo-300 border-indigo-500/25',
        'avatar_light' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'badge_dark'   => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
        'badge_light'  => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'stars'        => 'text-indigo-400',
    ],
    'amber'   => [
        'avatar_dark'  => 'bg-amber-500/15 text-amber-300 border-amber-500/25',
        'avatar_light' => 'bg-amber-50 text-amber-700 border-amber-200',
        'badge_dark'   => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
        'badge_light'  => 'bg-amber-50 text-amber-700 border-amber-200',
        'stars'        => 'text-amber-400',
    ],
    'sky'     => [
        'avatar_dark'  => 'bg-sky-500/15 text-sky-300 border-sky-500/25',
        'avatar_light' => 'bg-sky-50 text-sky-700 border-sky-200',
        'badge_dark'   => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
        'badge_light'  => 'bg-sky-50 text-sky-700 border-sky-200',
        'stars'        => 'text-sky-400',
    ],
    'rose'    => [
        'avatar_dark'  => 'bg-rose-500/15 text-rose-300 border-rose-500/25',
        'avatar_light' => 'bg-rose-50 text-rose-700 border-rose-200',
        'badge_dark'   => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
        'badge_light'  => 'bg-rose-50 text-rose-700 border-rose-200',
        'stars'        => 'text-rose-400',
    ],
    'teal'    => [
        'avatar_dark'  => 'bg-teal-500/15 text-teal-300 border-teal-500/25',
        'avatar_light' => 'bg-teal-50 text-teal-700 border-teal-200',
        'badge_dark'   => 'bg-teal-500/10 text-teal-400 border-teal-500/20',
        'badge_light'  => 'bg-teal-50 text-teal-700 border-teal-200',
        'stars'        => 'text-teal-400',
    ],
];
@endphp

<section id="avis" class="py-24 overflow-hidden transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">

    {{-- ── En-tête (centré, max-w pour lisibilité) ── --}}
    <div class="max-w-5xl mx-auto px-5 mb-12 text-center reveal">
        <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
             :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
            Témoignages
        </div>
        <h2 class="font-display font-bold leading-tight mb-3"
            style="font-size:clamp(1.8rem,4.5vw,3rem)"
            :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
            Ils ont arrêté de trier des CVs.<br>
            <span class="grad-text">Ils recrutent mieux.</span>
        </h2>
        <p class="text-base max-w-md mx-auto"
           :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            Candidats et recruteurs partagent leur expérience MatchRH.
        </p>
    </div>

    {{-- ── Carrousel pleine largeur ── --}}
    <div
        x-data="testimonialCarousel({{ count($testimonials) }})"
        x-init="init()"
        class="relative w-full"
    >
        {{-- Masques de fondu — pleine hauteur, pleine largeur de fenêtre --}}
        <div class="pointer-events-none absolute inset-y-0 left-0 w-20 z-10"
             :style="dark
                 ? 'background:linear-gradient(to right,#09090b 0%,transparent 100%)'
                 : 'background:linear-gradient(to right,#f8fafc 0%,transparent 100%)'">
        </div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-20 z-10"
             :style="dark
                 ? 'background:linear-gradient(to left,#09090b 0%,transparent 100%)'
                 : 'background:linear-gradient(to left,#f8fafc 0%,transparent 100%)'">
        </div>

        {{-- Piste de défilement — déborde volontairement hors du viewport --}}
        <div
            id="testimonial-track"
            class="flex gap-5 pb-2"
            style="will-change:transform; touch-action:pan-y;"
            @mouseenter="pause()"
            @mouseleave="play()"
            @touchstart.passive="onTouchStart($event)"
            @touchmove.passive="onTouchMove($event)"
            @touchend="onTouchEnd($event)"
        >
            {{-- Les cards réelles --}}
            @foreach ($testimonials as $t)
                @php $c = $palette[$t['color']]; @endphp
                <div class="testimonial-card flex-shrink-0 w-[300px] sm:w-[340px] rounded-2xl border p-6 flex flex-col gap-4 transition-colors duration-200 cursor-default"
                     :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">

                    {{-- Avatar + nom + badge --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="grid size-10 shrink-0 place-items-center rounded-xl border font-bold text-sm font-display"
                                 :class="dark ? '{{ $c['avatar_dark'] }}' : '{{ $c['avatar_light'] }}'">
                                {{ $t['initials'] }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-display font-bold text-sm leading-tight truncate"
                                   :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
                                    {{ $t['name'] }}
                                </p>
                                <p class="text-xs mt-0.5 truncate"
                                   :class="dark ? 'text-zinc-500' : 'text-zinc-400'">
                                    {{ $t['role'] }} · {{ $t['company'] }}
                                </p>
                            </div>
                        </div>
                        <span class="shrink-0 px-2.5 py-1 rounded-lg border text-xs font-semibold"
                              :class="dark ? '{{ $c['badge_dark'] }}' : '{{ $c['badge_light'] }}'">
                            {{ $t['badge'] }}
                        </span>
                    </div>

                    {{-- Étoiles --}}
                    <div class="flex gap-0.5 {{ $c['stars'] }}">
                        @for ($s = 0; $s < $t['stars']; $s++)
                            <flux:icon.star class="size-4" />
                        @endfor
                    </div>

                    {{-- Citation --}}
                    <blockquote class="text-sm leading-relaxed flex-1"
                                :class="dark ? 'text-zinc-300' : 'text-zinc-600'">
                        "{{ $t['quote'] }}"
                    </blockquote>
                </div>
            @endforeach
            {{-- Les clones Before/After sont injectés dynamiquement par le JS --}}
        </div>

        {{-- ── Contrôles : dots + flèches + play/pause ── --}}
        <div class="max-w-5xl mx-auto px-5 mt-7 flex items-center justify-between gap-4">

            {{-- Dots (un par card réelle) --}}
            <div class="flex items-center gap-2">
                @foreach ($testimonials as $i => $t)
                    <button
                        @click="goTo({{ $i }})"
                        :class="current === {{ $i }}
                            ? (dark ? 'bg-emerald-400 w-5' : 'bg-emerald-500 w-5')
                            : (dark ? 'bg-zinc-700 w-2 hover:bg-zinc-500' : 'bg-zinc-300 w-2 hover:bg-zinc-400')"
                        class="h-2 rounded-full transition-all duration-300 focus-visible:outline-none"
                        :aria-label="'Aller au témoignage ' + ({{ $i }} + 1)"
                        :aria-current="current === {{ $i }} ? 'true' : 'false'"
                    ></button>
                @endforeach
            </div>

            {{-- Flèches + Play/Pause --}}
            <div class="flex items-center gap-2">

                <button
                    @click="prev()"
                    class="grid size-9 place-items-center rounded-xl border transition-all"
                    :class="dark
                        ? 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-zinc-600 hover:text-zinc-100'
                        : 'border-zinc-200 bg-white text-zinc-500 hover:border-zinc-400 hover:text-zinc-800'"
                    aria-label="Témoignage précédent"
                >
                    <flux:icon.arrow-left class="size-4" />
                </button>

                <button
                    @click="togglePlay()"
                    class="grid size-9 place-items-center rounded-xl border transition-all"
                    :class="dark
                        ? 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-zinc-600 hover:text-zinc-100'
                        : 'border-zinc-200 bg-white text-zinc-500 hover:border-zinc-400 hover:text-zinc-800'"
                    :aria-label="playing ? 'Mettre en pause' : 'Reprendre le défilement'"
                >
                    <template x-if="playing">
                        <flux:icon.pause class="size-4" />
                    </template>
                    <template x-if="!playing">
                        <flux:icon.play class="size-4" />
                    </template>
                </button>

                <button
                    @click="next()"
                    class="grid size-9 place-items-center rounded-xl border transition-all"
                    :class="dark
                        ? 'border-zinc-800 bg-zinc-900 text-zinc-400 hover:border-zinc-600 hover:text-zinc-100'
                        : 'border-zinc-200 bg-white text-zinc-500 hover:border-zinc-400 hover:text-zinc-800'"
                    aria-label="Témoignage suivant"
                >
                    <flux:icon.arrow-right class="size-4" />
                </button>

            </div>
        </div>
    </div>

</section>
<!-- ===== CONTACT ===== -->
<section id="contact" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-3xl mx-auto">
    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Contactez-nous
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Une question ?<br><span class="grad-text">Parlons-en.</span>
      </h2>
      <p class="text-base max-w-md mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Que vous soyez recruteur ou candidat, notre équipe est là pour vous accompagner.
      </p>
    </div>

    <div class="reveal">
        <livewire:contact-form />
    </div>
  </div>
</section>

   {{-- ═══════════════════════════════════════════════════
                     FAQ Réponses enrichies
                ═══════════════════════════════════════════════════ --}}
            <section id="faq" class="border-y transition-colors duration-300"
         :class="dark ? 'border-zinc-800 bg-zinc-950' : 'border-zinc-200 bg-slate-50'">
    <div class="mx-auto max-w-3xl px-5 py-14 sm:py-20 lg:px-8">

        {{-- En-tête --}}
        <div class="mb-10 text-center">
            <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
                 :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
                Foire aux questions
            </div>
            <h2 class="font-display font-bold leading-tight mb-3" style="font-size:clamp(1.6rem,4vw,2.4rem)"
                :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
                Tout ce que vous voulez savoir<br class="hidden sm:block"> avant de vous lancer.
            </h2>
            <p class="text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
                Candidats et recruteurs vos questions les plus fréquentes.
            </p>
        </div>

        {{-- Accordéon --}}
        <div class="space-y-3">
            @foreach ($faqs as $index => $faq)
                <details
                    class="group rounded-2xl border transition-colors duration-200"
                    :class="dark
                        ? 'bg-zinc-900 border-zinc-800 open:border-emerald-500/30'
                        : 'bg-white border-zinc-200 open:border-emerald-300'"
                    @if ($index === 0) open @endif
                >
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 sm:py-5">
                        <span class="font-semibold text-sm leading-snug sm:text-base"
                              :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
                            {{ $faq['question'] }}
                        </span>
                        <span class="grid size-7 shrink-0 place-items-center rounded-lg border transition-all duration-200
                                     group-open:rotate-45"
                              :class="dark
                                  ? 'border-zinc-700 bg-zinc-800 text-zinc-300 group-open:border-emerald-500/30 group-open:bg-emerald-500/10 group-open:text-emerald-400'
                                  : 'border-zinc-200 bg-zinc-100 text-zinc-500 group-open:border-emerald-300 group-open:bg-emerald-50 group-open:text-emerald-600'">
                            <flux:icon.plus class="size-3.5" />
                        </span>
                    </summary>

                    <div class="border-t px-5 pb-5 pt-4 text-sm leading-relaxed"
                         :class="dark ? 'border-zinc-800 text-zinc-400' : 'border-zinc-100 text-zinc-500'">
                        {{ $faq['answer'] }}
                    </div>
                </details>
            @endforeach
        </div>

        {{-- CTA bas --}}
        <div class="mt-8 rounded-2xl border p-6 text-center"
             :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
            <p class="font-semibold text-sm mb-4"
               :class="dark ? 'text-zinc-200' : 'text-zinc-700'">
                Vous avez une question spécifique à votre situation ?
            </p>
            <a href="#contact"
               class="inline-flex items-center gap-2 px-7 py-3 rounded-xl font-display font-bold text-sm
                      bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all
                      hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/20">
                Parlez-nous directement
            </a>
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
                                    ['label' => 'Tarifs',        'href' => '#tarifs'],
                                    ['label' => 'Solution',      'href' => '#solution'],
                                    ['label' => 'Fonctionnalités','href' => '#fonctionnalites'],
                                    ['label' => 'FAQ',           'href' => '#faq'],
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
                                    ['label' => 'CGU',               'slug' => 'cgu'],
                                    ['label' => 'CGV',               'slug' => 'cgv'],
                                    ['label' => 'Politique de cookies','slug' => 'cookies'],
                                ] as $link)
                                    <li>
                                        <a href="{{ route('legal.show', $link['slug']) }}" class="text-sm text-slate-500 transition hover:text-slate-950 dark:text-zinc-400 dark:hover:text-zinc-50">
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

