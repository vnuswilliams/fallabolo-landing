# MEGA-PROMPT : PLATEFORME MATCHRH — GUIDELINES DE DÉVELOPPEMENT LARAVEL

> Document de référence pour l’IA de coding — Usage interne — Juin 2026

-----

## 1. VISION ET PÉRIMÈTRE DU PROJET

Tu développes **MatchRH**, une plateforme SaaS de recrutement intelligent qui connecte recruteurs et candidats via un algorithme de matching automatique basé sur des critères structurés.

**Ce que la plateforme fait :**

- Calcule un score de compatibilité `candidat ↔ offre` en temps réel
- Élimine les candidats non qualifiés via des critères bloquants
- Classe les candidats qualifiés du plus au moins compatible
- Affiche le score au candidat AVANT qu’il postule
- Supprime CV et lettres de motivation du processus principal

**Ce que la plateforme ne fait PAS (MVP) :**

- Pas de messagerie interne entre recruteurs et candidats
- Pas de paiement en ligne automatisé (facturation manuelle en MVP)
- Pas d’IA générative dans le scoring (algorithme déterministe uniquement)

**Stack technique fixe — NE PAS suggérer d’alternatives :**

- **Backend & Frontend :** Laravel 11+ (Blade + Livewire ou Inertia/Vue selon le contexte)
- **Base de données :** MySQL 8+
- **Cache & Queues :** Redis
- **Jobs asynchrones :** Laravel Queue (driver Redis)
- **Auth :** Laravel Breeze ou Jetstream (selon complexité souhaitée)
- **Email :** Laravel Mail + Mailtrap (dev) / SMTP production
- **Paiement :** Laravel Cashier (Stripe) — optionnel MVP
- **Déploiement :** VPS Linux (Ubuntu), Nginx, PHP-FPM, Supervisor

-----

## 2. ARCHITECTURE LARAVEL — STRUCTURE DES DOSSIERS

Respecte strictement la structure Laravel standard avec les ajouts suivants :

```
app/
├── Console/
│   └── Commands/
│       └── RunMatchingEngine.php       # Commande artisan pour le moteur de matching
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                       # Gérés par Breeze/Jetstream
│   │   ├── RecruiterController.php
│   │   ├── CandidateController.php
│   │   ├── JobOfferController.php
│   │   ├── ApplicationController.php
│   │   └── DashboardController.php
│   ├── Middleware/
│   │   ├── EnsureProfileComplete.php   # Redirige si profil incomplet
│   │   ├── EnsureRecruiter.php
│   │   ├── EnsureCandidate.php
│   │   └── CheckSubscriptionLimit.php  # Freemium : limites d'usage
│   └── Requests/                       # Form Requests pour validation
│       ├── StoreJobOfferRequest.php
│       ├── UpdateCandidateProfileRequest.php
│       └── StoreApplicationRequest.php
├── Models/
│   ├── User.php
│   ├── RecruiterProfile.php
│   ├── CandidateProfile.php
│   ├── JobOffer.php
│   ├── BlockingCriterion.php
│   ├── BonusCriterion.php
│   ├── CandidateSkill.php
│   ├── Application.php
│   └── Subscription.php
├── Services/
│   ├── Matching/
│   │   ├── MatchingEngine.php          # Orchestrateur principal — NE PAS exposer la logique
│   │   ├── BlockingCriteriaChecker.php # Couche 1
│   │   ├── ScoreCalculator.php         # Couche 2 — Score principal pondéré
│   │   └── BonusDetector.php           # Couche 3 — Atouts informatifs
│   ├── NotificationService.php
│   └── SubscriptionService.php
├── Jobs/
│   └── CalculateMatchScoreJob.php      # Job asynchrone — dispatché en queue
├── Policies/
│   ├── JobOfferPolicy.php
│   └── ApplicationPolicy.php
└── Enums/
    ├── JobTemplate.php                 # Les 5 templates de poste
    ├── ExperiencePalier.php
    ├── FormationLevel.php
    ├── DisponibilitePalier.php
    └── SubscriptionPlan.php

database/
├── migrations/
│   ├── create_recruiter_profiles_table.php
│   ├── create_candidate_profiles_table.php
│   ├── create_job_offers_table.php
│   ├── create_blocking_criteria_table.php
│   ├── create_bonus_criteria_table.php
│   ├── create_candidate_skills_table.php
│   ├── create_applications_table.php
│   └── create_subscriptions_table.php
└── seeders/
    ├── SkillLibrarySeeder.php          # Bibliothèque de compétences fixe
    ├── CriteriaLibrarySeeder.php       # Bibliothèque de critères bloquants
    └── BonusLibrarySeeder.php          # Bibliothèque d'atouts

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php               # Layout principal connecté
│   │   └── guest.blade.php             # Layout public/auth
│   ├── recruiter/
│   │   ├── dashboard.blade.php
│   │   ├── job-offers/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── show.blade.php
│   │   └── applications/
│   │       └── index.blade.php         # Liste candidats classés par score
│   └── candidate/
│       ├── dashboard.blade.php
│       ├── profile/
│       │   └── edit.blade.php
│       └── offers/
│           ├── index.blade.php         # Offres compatibles avec score affiché
│           └── show.blade.php          # Détail offre + score détaillé avant candidature
└── livewire/                           # Composants Livewire si utilisés
    ├── skill-picker.blade.php
    ├── blocking-criteria-builder.blade.php
    └── match-score-display.blade.php
```

-----

## 3. MODÈLE DE DONNÉES — MIGRATIONS LARAVEL

### Table `users` (Laravel standard)

```php
// Champs additionnels à ajouter via migration
$table->enum('role', ['recruiter', 'candidate'])->after('email');
$table->boolean('email_verified')->default(false);
$table->timestamp('last_login_at')->nullable();
```

### Table `recruiter_profiles`

```php
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->string('company_name');
$table->string('company_size')->nullable();    // '1-10', '11-50', etc.
$table->string('industry')->nullable();
$table->string('city');
$table->string('country')->default('CM');
$table->boolean('is_verified')->default(false);
$table->timestamps();
```

### Table `candidate_profiles`

```php
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->string('first_name');
$table->string('last_name');
$table->string('main_job_title')->nullable();
$table->tinyInteger('experience_palier');      // 0=sans, 1=1-2ans, 2=3-4ans, 3=5-10ans, 4=+10ans
$table->tinyInteger('formation_level');        // 0=aucun, 1=CEPC, 2=BEPC, 3=BAC, 4=BTS/DUT, 5=Licence, 6=Master, 7=Doctorat
$table->tinyInteger('disponibilite_palier');   // 0=immédiate, 1=15j, 2=30j, 3=plus
$table->string('city');
$table->string('region')->nullable();
$table->string('country')->default('CM');
$table->unsignedInteger('salary_min')->nullable();
$table->unsignedInteger('salary_max')->nullable();
$table->enum('langue_mode', ['francophone', 'anglophone', 'bilingue'])->default('bilingue');
$table->boolean('profile_complete')->default(false);
$table->timestamps();
```

### Table `candidate_skills`

```php
$table->id();
$table->foreignId('candidate_profile_id')->constrained()->onDelete('cascade');
$table->foreignId('skill_id')->constrained();   // Référence bibliothèque fixe
$table->tinyInteger('level');                    // 1 à 5
$table->timestamps();
```

### Table `job_offers`

```php
$table->id();
$table->foreignId('recruiter_profile_id')->constrained()->onDelete('cascade');
$table->string('title');
$table->text('description')->nullable();
$table->enum('template', ['manouvre', 'technicien', 'agent_maitrise', 'cadre', 'dirigeant']);
$table->string('city');
$table->string('region')->nullable();
$table->string('country')->default('CM');
$table->tinyInteger('experience_required_palier');
$table->tinyInteger('formation_required_level');
$table->tinyInteger('disponibilite_max_palier');
$table->enum('langue_mode', ['francophone', 'anglophone', 'bilingue'])->default('bilingue');
$table->unsignedInteger('salary_budget_min')->nullable();
$table->unsignedInteger('salary_budget_max')->nullable();
$table->enum('status', ['draft', 'published', 'closed'])->default('draft');
$table->timestamps();
$table->softDeletes();
```

### Table `job_offer_skills` (compétences requises par offre)

```php
$table->id();
$table->foreignId('job_offer_id')->constrained()->onDelete('cascade');
$table->foreignId('skill_id')->constrained();
$table->tinyInteger('level_required');   // 1 à 5
$table->timestamps();
```

### Table `blocking_criteria` (critères bloquants par offre)

```php
$table->id();
$table->foreignId('job_offer_id')->constrained()->onDelete('cascade');
$table->foreignId('criterion_id')->constrained('criteria_library');  // Bibliothèque fixe
$table->string('value')->nullable();   // Ex: "B" pour permis B, "30" pour dispo max
$table->timestamps();
```

### Table `bonus_criteria` (atouts recherchés par offre)

```php
$table->id();
$table->foreignId('job_offer_id')->constrained()->onDelete('cascade');
$table->foreignId('bonus_id')->constrained('bonus_library');
$table->enum('priority', ['faible', 'moyen', 'fort']);
$table->timestamps();
```

### Table `applications` (candidatures)

```php
$table->id();
$table->foreignId('job_offer_id')->constrained()->onDelete('cascade');
$table->foreignId('candidate_profile_id')->constrained()->onDelete('cascade');
$table->decimal('score_principal', 5, 2)->default(0);   // Score couche 2 (0-100)
$table->boolean('blocked')->default(false);              // Couche 1 échouée
$table->string('blocked_reason')->nullable();
$table->json('score_detail')->nullable();                // Détail par bloc (JSON)
$table->json('atouts_detected')->nullable();             // Couche 3 informatif
$table->enum('status', ['pending', 'viewed', 'shortlisted', 'rejected'])->default('pending');
$table->timestamp('viewed_at')->nullable();
$table->unique(['job_offer_id', 'candidate_profile_id']);
$table->timestamps();
```

### Table `subscriptions`

```php
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->enum('plan', ['free', 'pro', 'enterprise'])->default('free');
$table->timestamp('started_at')->useCurrent();
$table->timestamp('expires_at')->nullable();
$table->enum('status', ['active', 'canceled', 'expired'])->default('active');
$table->timestamps();
```

-----

## 4. L’ALGORITHME DE MATCHING — RÈGLES ABSOLUES

> ⚠️ L’algorithme est le cœur compétitif de MatchRH. Ces règles ne sont JAMAIS contournées.

### Architecture en 3 couches

**Couche 1 — Critères bloquants** (`BlockingCriteriaChecker.php`)

- Vérifiés en premier, avant tout calcul
- Si UN SEUL critère échoue → `score = 0`, `blocked = true`, processus terminé
- Exemples : langue, permis, diplôme minimum, disponibilité maximale

**Couche 2 — Score principal pondéré** (`ScoreCalculator.php`)

- Score entre 0% et 100%
- Formule : `score_bloc = e^(-λ × écart)` (pénalité exponentielle)
- Les pondérations et les lambda sont **fixes par template** — le recruteur ne peut pas les modifier
- Blocs : Compétences, Expérience, Formation, Disponibilité, Localisation, Salaire

**Couche 3 — Atouts** (`BonusDetector.php`)

- N’entre dans AUCUN calcul de score
- Affichage informatif uniquement
- Deux catégories : atouts recherchés (définis recruteur) + compétences supplémentaires (auto-détectées)

### Les 5 templates — Pondérations et Lambda

|Bloc             |Manœuvre  |Technicien|Agent maîtrise|Cadre     |Dirigeant |
|-----------------|----------|----------|--------------|----------|----------|
|**Compétences**  |30% / λ0.2|45% / λ0.4|40% / λ0.6    |35% / λ0.8|25% / λ1.0|
|**Expérience**   |25% / λ0.2|25% / λ0.4|30% / λ0.6    |35% / λ0.8|45% / λ1.0|
|**Formation**    |5% / λ0.2 |10% / λ0.4|10% / λ0.6    |15% / λ0.8|15% / λ1.0|
|**Disponibilité**|20% / λ0.1|10% / λ0.1|8% / λ0.2     |4% / λ0.2 |3% / λ0.3 |
|**Localisation** |15% / λ0.1|5% / λ0.1 |7% / λ0.2     |3% / λ0.2 |2% / λ0.3 |
|**Salaire**      |5% / λ0.1 |5% / λ0.1 |5% / λ0.2     |8% / λ0.3 |10% / λ0.4|

### Calcul du bloc compétences (pondération par niveau requis)

```
score_compétence_i = e^(-λ × max(0, niveau_requis_i - niveau_candidat_i))
score_bloc = Σ(score_compétence_i × niveau_requis_i) / Σ(niveau_requis_i)
```

### Calcul du bloc salaire

```
chevauchement = min(budget_max, salary_max) - max(budget_min, salary_min)
Si chevauchement ≥ 0 → score 100%
Si salary_max < budget_min → score 100% (recruteur peut négocier à la hausse)
Si chevauchement < 0 → écart_normalisé = |chevauchement| / budget_max
                       score = e^(-λ × écart_normalisé)
```

### Règles d’implémentation obligatoires

- Les constantes lambda et les pondérations doivent être dans des **fichiers de config** (`config/matching.php`), pas en dur dans le code
- Le `MatchingEngine` doit être invocable en **synchrone** (pour affichage immédiat du score) ET en **asynchrone** via `CalculateMatchScoreJob`
- Le détail du calcul par bloc est **stocké en JSON** dans `applications.score_detail` pour l’affichage côté recruteur et candidat
- **Jamais exposer** les valeurs de lambda ou les formules dans les vues Blade ou les réponses JSON publiques

-----

## 5. FONCTIONNALITÉS DÉTAILLÉES ET RÈGLES MÉTIER

### Module 5.1 — Authentification & Rôles

**Implémentation Laravel :**

- Utiliser Laravel Breeze (simple) ou Jetstream (si 2FA requis)
- Middleware custom `EnsureRecruiter` et `EnsureCandidate` — utiliser `$request->user()->role`
- Après inscription, rediriger vers la completion de profil obligatoire

**Règles métier :**

- Email unique, vérifié avant accès complet
- Mot de passe : min 8 caractères (adapter selon politique locale)
- Un user a soit un `RecruiterProfile` soit un `CandidateProfile` — jamais les deux
- Rate limiting sur login : `RateLimiter::for('login', ...)` dans `AppServiceProvider`

**Routes à protéger :**

```php
// routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('role:recruiter')->prefix('recruteur')->group(...);
    Route::middleware('role:candidate')->prefix('candidat')->group(...);
});
```

-----

### Module 5.2 — Profils Utilisateurs

**Candidat — Champs obligatoires pour activer le matching :**

- Prénom, Nom, Ville, Pays
- Au moins 1 compétence avec niveau
- Palier d’expérience
- Niveau de formation
- Disponibilité
- Mode langue (francophone / anglophone / bilingue)

**Recruteur — Champs obligatoires pour publier une offre :**

- Nom de l’entreprise, Ville, Pays
- L’offre elle-même doit avoir au moins 1 compétence requise et 1 critère bloquant

**Middleware `EnsureProfileComplete` :**

- Vérifie `candidate_profiles.profile_complete = true` avant d’accéder aux offres
- Si incomplet → redirect vers `candidate.profile.edit` avec message flash

-----

### Module 5.3 — Offres d’Emploi

**Création d’offre — Étapes (wizard multi-step recommandé avec Livewire) :**

1. Choix du template de poste (détermine pondérations et lambda)
1. Informations générales (titre, description, localisation, salaire, langue)
1. Compétences requises (sélection depuis bibliothèque + niveau 1-5)
1. Critères bloquants (sélection depuis bibliothèque + valeur si applicable)
1. Atouts recherchés / bonus (optionnel, depuis bibliothèque + priorité)
1. Récapitulatif → Publication

**Règles métier :**

- Un recruteur FREE peut publier **2 offres actives** simultanément
- Un recruteur PRO : **illimité**
- Une offre publiée déclenche automatiquement le calcul de matching (`CalculateMatchScoreJob::dispatch($jobOffer)`)
- Une offre fermée (`status = closed`) n’apparaît plus dans les résultats candidats

-----

### Module 5.4 — Candidature et Matching

**Flux de candidature côté candidat :**

1. Candidat browse les offres → score de compatibilité affiché sur la card
1. Candidat ouvre le détail → score détaillé par bloc + atouts détectés
1. Candidat clique “Je suis intéressé” → validation des critères bloquants en temps réel
1. Si tous les bloquants OK → candidature enregistrée dans `applications`
1. Recruteur notifié par email groupé (digest quotidien)

**Flux de consultation côté recruteur :**

- Dashboard offre → liste des candidatures classées par `score_principal DESC`
- Affichage : nom (anonymisé en FREE), score %, atouts détectés, statut
- Recruteur PRO : nom complet + contact + détail complet du score

**Règles métier importantes :**

- Le score est calculé une fois à la candidature et **stocké** — il n’est pas recalculé à chaque consultation
- Si le candidat met à jour son profil APRÈS avoir postulé, le score n’est PAS automatiquement mis à jour (le score reflète le profil au moment de la candidature)
- Un candidat ne peut pas postuler deux fois à la même offre (`UNIQUE` constraint)

-----

### Module 5.5 — Notifications

**Events & Listeners Laravel (ne pas utiliser de package tiers en MVP) :**

|Event                 |Listener                         |Déclencheur         |
|----------------------|---------------------------------|--------------------|
|`ApplicationSubmitted`|`NotifyRecruiterOfNewApplication`|Nouvelle candidature|
|`JobOfferPublished`   |`CalculateInitialMatches`        |Publication d’offre |
|`UserRegistered`      |`SendWelcomeEmail`               |Inscription         |

**Notifications email :**

- Digest quotidien recruteur (résumé des nouvelles candidatures qualifiées du jour)
- Email de bienvenue candidat avec guide de completion de profil
- Rappel recruteur si offre publiée depuis 7j sans candidature qualifiée

**Implémentation :**

```php
// Utiliser Laravel Notifications avec le channel 'mail'
// Scheduler dans app/Console/Kernel.php
$schedule->job(new SendRecruiterDailyDigest)->dailyAt('08:00');
```

-----

### Module 5.6 — Freemium & Abonnements

**Plans MVP :**

|Feature                    |Gratuit|Pro (49 000 FCFA/mois)|Entreprise|
|---------------------------|-------|----------------------|----------|
|Offres actives             |2      |Illimité              |Illimité  |
|Candidatures visibles/offre|10     |Illimité              |Illimité  |
|Identité candidats         |Masquée|Complète              |Complète  |
|Détail score par bloc      |Non    |Oui                   |Oui       |
|Export CSV                 |Non    |Oui                   |Oui       |
|Support                    |Email  |Prioritaire           |Dédié     |

**Implémentation Laravel :**

- `CheckSubscriptionLimit` middleware vérifie le plan avant chaque action limitée
- Middleware injecte `$user->subscription` via `with()` dans le controller
- En MVP : facturation manuelle → `subscription.plan` mis à jour manuellement par admin
- Prévoir `SubscriptionService::upgrade($user, $plan)` pour future intégration Cashier/Stripe

-----

## 6. SÉCURITÉ — RÈGLES NON NÉGOCIABLES

### Validation

- **Toujours** utiliser des `FormRequest` pour toute requête POST/PUT — jamais valider dans le controller
- Utiliser `$table->unsignedTinyInteger()` pour les niveaux et paliers — rejeter toute valeur hors plage
- Sanitiser toutes les entrées texte libres avec `strip_tags()`

### Autorisation

- Utiliser les **Laravel Policies** pour toute action sur une ressource (ex: `JobOfferPolicy::update`)
- Un recruteur ne voit JAMAIS les offres ou données d’un autre recruteur
- Un candidat ne voit JAMAIS les données d’un autre candidat
- Vérification dans les policies : `$user->id === $recruiterProfile->user_id`

### Protection des données (Loi camerounaise 2024)

- Les données candidats sont déclaratives — l’afficher clairement dans les CGU
- Permettre la suppression de compte → anonymiser `candidate_profiles` (name → “Utilisateur supprimé”, email → null)
- Ne pas logger les scores et détails de matching dans les fichiers de log Laravel

### Sécurité générale

- CSRF activé par défaut sur toutes les routes web (ne pas désactiver)
- Rate limiting sur les routes d’auth et de candidature
- `APP_ENV=production` et `APP_DEBUG=false` en production — vérifier avant déploiement
- Headers de sécurité dans la config Nginx (X-Frame-Options, X-Content-Type-Options, etc.)

-----

## 7. PERFORMANCE & ARCHITECTURE

### Indexation base de données (à ajouter dans les migrations)

```php
// Table applications — requêtes fréquentes
$table->index(['job_offer_id', 'score_principal']); // Classement par score
$table->index(['candidate_profile_id', 'status']);

// Table candidate_skills
$table->index(['candidate_profile_id', 'skill_id']);

// Table job_offers
$table->index(['status', 'created_at']);
$table->index(['recruiter_profile_id', 'status']);
```

### Cache Redis

```php
// Mettre en cache les résultats de matching 6h
// Invalider si candidat modifie son profil
Cache::tags(['matching', "candidate_{$candidateId}"])->remember(
    "score_{$offerId}_{$candidateId}",
    now()->addHours(6),
    fn() => $this->matchingEngine->calculate($offer, $candidate)
);
```

### Queues pour les calculs lourds

```php
// Dispatcher le calcul en queue — ne jamais bloquer la requête HTTP
CalculateMatchScoreJob::dispatch($jobOffer)
    ->onQueue('matching')
    ->delay(now()->addSeconds(5)); // Petit délai pour laisser la transaction se finaliser
```

### Configuration Supervisor (production)

```ini
[program:matchrh-worker]
command=php /var/www/matchrh/artisan queue:work redis --queue=matching,default --tries=3
numprocs=2
autostart=true
autorestart=true
```

-----

## 8. DESIGN SYSTEM — IDENTITÉ VISUELLE

### Palette (cohérente avec la landing page)

```css
/* Variables CSS — à inclure dans app.blade.php */
:root {
    --color-bg-primary: #0a0a0f;          /* Fond principal sombre */
    --color-bg-secondary: #12121a;         /* Cartes et sections */
    --color-bg-tertiary: #1a1a26;          /* Inputs, tableaux */
    --color-accent-gold: #c9a84c;          /* Or — accent principal */
    --color-accent-amber: #e8c46a;         /* Ambre — hover états */
    --color-text-primary: #f5f0e8;         /* Blanc cassé */
    --color-text-secondary: #a89880;       /* Gris doré */
    --color-border: rgba(201, 168, 76, 0.2); /* Bordures subtiles */

    /* Sémantique matching */
    --color-score-high: #10b981;           /* Score ≥ 70% — vert */
    --color-score-mid: #f59e0b;            /* Score 50-70% — ambre */
    --color-score-low: #ef4444;            /* Score < 50% — rouge */
    --color-blocked: #6b7280;              /* Candidature bloquée — gris */
}
```

### Typographie

```css
/* Titres : Cormorant Garamond (élégance) */
/* Corps : DM Sans (lisibilité) */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap');

body { font-family: 'DM Sans', sans-serif; }
h1, h2, h3 { font-family: 'Cormorant Garamond', serif; }
```

### Composant score — Affichage cohérent

Le score doit toujours être affiché avec :

- Le pourcentage en grand (chiffre principal)
- Une couleur sémantique (vert/ambre/rouge)
- Le détail par bloc en dessous (recruteur PRO uniquement)
- Les atouts en section séparée avec icônes ✓ / ✗

-----

## 9. CONVENTIONS DE CODE LARAVEL

### Nommage

- **Models** : PascalCase singulier (`JobOffer`, `CandidateProfile`)
- **Controllers** : PascalCase + `Controller` (`JobOfferController`)
- **Routes** : kebab-case (`/offres-emploi/{id}`)
- **Variables** : camelCase dans PHP, snake_case dans les migrations et colonnes DB
- **Routes nommées** : `recruiter.offers.index`, `candidate.profile.edit`

### Controllers — Règle de légèreté

- Le controller ne contient PAS de logique métier — il délègue au Service
- Maximum : récupérer la requête, appeler le service, retourner la vue

```php
// ✅ Correct
public function store(StoreJobOfferRequest $request, JobOfferService $service)
{
    $offer = $service->create($request->validated(), auth()->user());
    return redirect()->route('recruiter.offers.show', $offer)->with('success', 'Offre publiée.');
}

// ❌ Incorrect — logique métier dans le controller
public function store(Request $request)
{
    $lambda = config('matching.templates.cadre.competences.lambda');
    // ... 50 lignes de calcul ici
}
```

### Services — Responsabilité unique

- `MatchingEngine` : orchestre uniquement, ne calcule pas lui-même
- `ScoreCalculator` : calcule uniquement le score principal, ne dispatche pas de job
- `BonusDetector` : détecte uniquement les atouts, n’accède pas au score

### Gestion des erreurs

- Utiliser les **Laravel Exception Handlers** pour les erreurs métier custom
- Logger les erreurs de matching dans un channel dédié (`config/logging.php`)
- Ne jamais retourner de stack trace à l’utilisateur final

-----

## 10. COMMANDES ARTISAN UTILES

```bash
# Recalculer le score d'une offre spécifique (debug)
php artisan matching:recalculate --offer=ID

# Générer le digest quotidien recruteur (peut être appelé manuellement)
php artisan notifications:recruiter-digest

# Vérifier la cohérence des scores (audit)
php artisan matching:audit --date=2026-06-01

# Importer la bibliothèque de compétences depuis un CSV
php artisan import:skills-library storage/skills.csv
```

-----

## 11. CE QUE TU NE DOIS JAMAIS FAIRE

- ❌ Suggérer Node.js, Next.js, React, Vue (standalone), TypeScript, Prisma, ou tout autre stack non-Laravel
- ❌ Proposer de la logique de matching dans un controller ou une vue Blade
- ❌ Exposer les valeurs lambda ou les formules dans les réponses JSON ou les vues front
- ❌ Utiliser `DB::statement()` brut pour des requêtes qui peuvent être faites avec Eloquent
- ❌ Mettre des clés d’API ou secrets dans le code — toujours via `.env`
- ❌ Créer des relations Eloquent sans les index correspondants dans les migrations
- ❌ Retourner des données d’un autre utilisateur (vérifier ownership dans chaque policy)
- ❌ Modifier les pondérations ou lambda sans mise à jour explicite de `config/matching.php`
- ❌ Permettre la suppression physique des candidatures (`softDeletes` obligatoire sur `applications`)

-----

*MatchRH — Document confidentiel — Usage interne — Juin 2026*