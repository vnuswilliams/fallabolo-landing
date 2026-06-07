Tu vas développer

# MEGA-PROMPT : PLATEFORME DE MATCHING RH INTELLIGENT

Tu vas développer une plateforme web de matching automatique entre recruteurs et candidats, fonctionnant sur un modèle freemium. L'application doit suggérer des appairages intelligents basés sur des critères précis (salaire, domaine, localisation, compétences) sans gérer la communication directe entre utilisateurs.

## 1. VISION ET VALEUR DU PROJET

Tu crées une plateforme SaaS de recrutement intelligent qui :
- Connecte recruteurs et candidats via un algorithme de matching automatique
- Fonctionne en mode freemium (limites d'usage pour version gratuite, accès illimité payant)
- Génère des suggestions pertinentes sans intervalle manuel d'admin/modérateur
- Stocke des données minimales (pas de CV détaillés, pas de données bancaires)
- Lance en MVP avec capacité <1 000 utilisateurs simultanés
- Offre une expérience web mobile-compatible (évolution vers apps natives ultérieure)

## 2. STACK TECHNIQUE RECOMMANDÉE

### Backend
- **Framework** : Node.js + Express (ou Fastify pour performance)
- **Langage** : TypeScript (typage fort, maintenabilité)
- **Base de données** : PostgreSQL (relations complexes, matching, performances)
- **Cache** : Redis (suggestions pré-calculées, sessions, rate limiting)
- **Authentification** : JWT + refresh tokens + httpOnly cookies
- **Algorithme de matching** : Logique TypeScript côté serveur (calculé à la demande ou cronjob)

### Frontend
- **Framework** : React 18+ (ou Next.js pour SSR/SSG)
- **Styling** : Tailwind CSS (rapidité, cohérence)
- **State management** : TanStack Query (pour requêtes API) + Zustand (état global minimal)
- **Validation** : Zod ou Yup
- **Composants** : Shadcn/ui ou Headless UI

### Déploiement & Infra
- **Hosting** : Vercel (frontend), Railway/Render (backend), ou AWS EC2 (simple)
- **Base de données** : Managed PostgreSQL (Vercel Postgres, Supabase, ou managed)
- **Monitoring** : Sentry (erreurs), LogRocket (sessions utilisateurs)
- **CI/CD** : GitHub Actions
- **Email** : SendGrid ou Resend (notifications, confirmations)

## 3. STRUCTURE DES DOSSIERS ET FICHIERS

```
project-root/
├── backend/
│   ├── src/
│   │   ├── config/
│   │   │   ├── database.ts
│   │   │   ├── env.ts (variables d'environnement)
│   │   │   └── constants.ts
│   │   ├── middleware/
│   │   │   ├── auth.ts (vérification JWT)
│   │   │   ├── errorHandler.ts
│   │   │   ├── rateLimit.ts
│   │   │   └── cors.ts
│   │   ├── routes/
│   │   │   ├── auth.ts (login, register, refresh token)
│   │   │   ├── users.ts (profil recruteur/candidat)
│   │   │   ├── matching.ts (suggestions, historique)
│   │   │   ├── subscriptions.ts (freemium, upgrades)
│   │   │   └── admin.ts (stats, logs)
│   │   ├── controllers/
│   │   │   ├── authController.ts
│   │   │   ├── userController.ts
│   │   │   ├── matchingController.ts
│   │   │   └── subscriptionController.ts
│   │   ├── services/
│   │   │   ├── userService.ts
│   │   │   ├── matchingService.ts (algorithme core)
│   │   │   ├── authService.ts (hash, JWT)
│   │   │   ├── emailService.ts
│   │   │   └── cacheService.ts
│   │   ├── models/
│   │   │   ├── User.ts (schema validation)
│   │   │   ├── Recruiter.ts
│   │   │   ├── Candidate.ts
│   │   │   ├── Match.ts
│   │   │   └── Subscription.ts
│   │   ├── utils/
│   │   │   ├── validators.ts (emails, salaires, etc.)
│   │   │   ├── helpers.ts
│   │   │   └── crypto.ts (chiffrement optionnel)
│   │   ├── jobs/
│   │   │   └── matchingCronjob.ts (calcul asynce des suggestions)
│   │   └── server.ts (entrée principale)
│   ├── tests/
│   │   ├── unit/
│   │   └── integration/
│   ├── .env.example
│   ├── docker-compose.yml (PostgreSQL local)
│   ├── package.json
│   └── tsconfig.json

├── frontend/
│   ├── src/
│   │   ├── components/
│   │   │   ├── Layout/
│   │   │   │   ├── Header.tsx
│   │   │   │   ├── Sidebar.tsx
│   │   │   │   └── Footer.tsx
│   │   │   ├── Auth/
│   │   │   │   ├── LoginForm.tsx
│   │   │   │   ├── RegisterForm.tsx
│   │   │   │   └── ProtectedRoute.tsx
│   │   │   ├── Dashboard/
│   │   │   │   ├── RecruiterDashboard.tsx
│   │   │   │   └── CandidateDashboard.tsx
│   │   │   ├── Matching/
│   │   │   │   ├── MatchingCard.tsx
│   │   │   │   ├── MatchingList.tsx
│   │   │   │   └── FilterPanel.tsx
│   │   │   ├── Profile/
│   │   │   │   ├── EditProfile.tsx
│   │   │   │   └── ProfileView.tsx
│   │   │   ├── Subscription/
│   │   │   │   ├── PricingPlans.tsx
│   │   │   │   └── UpgradeModal.tsx
│   │   │   └── Common/
│   │   │       ├── Button.tsx
│   │   │       ├── Card.tsx
│   │   │       ├── Modal.tsx
│   │   │       └── Toast.tsx
│   │   ├── hooks/
│   │   │   ├── useAuth.ts
│   │   │   ├── useMatching.ts
│   │   │   └── useFetch.ts
│   │   ├── store/
│   │   │   ├── authStore.ts (Zustand)
│   │   │   └── userStore.ts
│   │   ├── api/
│   │   │   ├── client.ts (axios/fetch config)
│   │   │   ├── auth.ts
│   │   │   ├── matching.ts
│   │   │   └── users.ts
│   │   ├── pages/
│   │   │   ├── LoginPage.tsx
│   │   │   ├── RegisterPage.tsx
│   │   │   ├── DashboardPage.tsx
│   │   │   ├── MatchingPage.tsx
│   │   │   ├── ProfilePage.tsx
│   │   │   └── PricingPage.tsx
│   │   ├── styles/
│   │   │   ├── globals.css
│   │   │   └── variables.css
│   │   ├── App.tsx
│   │   ├── main.tsx
│   │   └── types/
│   │       └── index.ts (types TypeScript globaux)
│   ├── public/
│   ├── .env.example
│   ├── vite.config.ts
│   ├── tailwind.config.js
│   ├── package.json
│   └── tsconfig.json

├── .gitignore
├── README.md
└── docker-compose.yml (toute l'app)
```

## 4. MODÈLES DE DONNÉES COMPLETS

### Schéma PostgreSQL

```sql
-- Table Users (base de tous les utilisateurs)
CREATE TABLE users (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  email VARCHAR(255) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL, -- bcrypt hash
  role ENUM('recruiter', 'candidate') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  last_login TIMESTAMP,
  is_active BOOLEAN DEFAULT TRUE,
  is_email_verified BOOLEAN DEFAULT FALSE
);

-- Table Recruiters
CREATE TABLE recruiters (
  id UUID PRIMARY KEY,
  user_id UUID NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
  company_name VARCHAR(255) NOT NULL,
  company_size ENUM('1-10', '11-50', '51-200', '200+'),
  industry VARCHAR(100), -- secteur activité
  job_openings INT DEFAULT 0,
  hiring_budget_min INT, -- salaire min offert
  hiring_budget_max INT, -- salaire max offert
  location_cities TEXT[], -- array de villes
  preferred_experience_level ENUM('junior', 'mid', 'senior') DEFAULT 'mid',
  required_skills TEXT[], -- array de compétences
  bio TEXT,
  verified_company BOOLEAN DEFAULT FALSE,
  subscription_plan ENUM('free', 'pro', 'enterprise') DEFAULT 'free',
  subscription_until TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table Candidates
CREATE TABLE candidates (
  id UUID PRIMARY KEY,
  user_id UUID NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  current_job_title VARCHAR(150),
  years_experience INT, -- années d'expérience
  salary_expectation_min INT,
  salary_expectation_max INT,
  current_location VARCHAR(255),
  willing_to_relocate BOOLEAN DEFAULT FALSE,
  remote_preference ENUM('on-site', 'hybrid', 'remote'),
  industry_preferences TEXT[], -- array de secteurs
  technical_skills TEXT[], -- array de compétences
  soft_skills TEXT[],
  experience_level ENUM('junior', 'mid', 'senior'),
  bio TEXT,
  preferred_industries TEXT[],
  available_start_date DATE,
  notice_period INT, -- jours
  subscription_plan ENUM('free', 'pro', 'enterprise') DEFAULT 'free',
  subscription_until TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table Matches (historique des suggestions)
CREATE TABLE matches (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  recruiter_id UUID NOT NULL REFERENCES recruiters(id) ON DELETE CASCADE,
  candidate_id UUID NOT NULL REFERENCES candidates(id) ON DELETE CASCADE,
  match_score DECIMAL(5, 2), -- 0 à 100, pourcentage de compatibilité
  salary_match BOOLEAN, -- salaire dans fourchette
  skill_match_count INT, -- nombre de compétences en commun
  location_match BOOLEAN, -- compatible géographiquement
  experience_match BOOLEAN, -- niveau compatible
  matching_reasons TEXT[], -- raisons du matching
  status ENUM('suggested', 'viewed', 'rejected', 'contacted_external') DEFAULT 'suggested',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  viewed_at TIMESTAMP,
  UNIQUE(recruiter_id, candidate_id)
);

-- Table Subscriptions
CREATE TABLE subscriptions (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID NOT NULL UNIQUE REFERENCES users(id) ON DELETE CASCADE,
  plan ENUM('free', 'pro', 'enterprise') NOT NULL,
  started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  expires_at TIMESTAMP,
  renewal_auto BOOLEAN DEFAULT FALSE,
  payment_method VARCHAR(50), -- 'card', 'paypal', etc.
  stripe_subscription_id VARCHAR(255), -- optionnel
  status ENUM('active', 'canceled', 'expired') DEFAULT 'active'
);

-- Table API Keys (pour éventuels partenaires)
CREATE TABLE api_keys (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  key_hash VARCHAR(255) NOT NULL UNIQUE,
  name VARCHAR(100),
  last_used TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_active BOOLEAN DEFAULT TRUE
);

-- Indexes pour performances
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_recruiters_user_id ON recruiters(user_id);
CREATE INDEX idx_candidates_user_id ON candidates(user_id);
CREATE INDEX idx_matches_recruiter ON matches(recruiter_id);
CREATE INDEX idx_matches_candidate ON matches(candidate_id);
CREATE INDEX idx_matches_created ON matches(created_at DESC);
CREATE INDEX idx_subscriptions_user ON subscriptions(user_id);
```

### Types TypeScript Globaux

```typescript
// types/index.ts

export type Role = 'recruiter' | 'candidate';
export type SubscriptionPlan = 'free' | 'pro' | 'enterprise';
export type ExperienceLevel = 'junior' | 'mid' | 'senior';
export type RemotePreference = 'on-site' | 'hybrid' | 'remote';
export type MatchStatus = 'suggested' | 'viewed' | 'rejected' | 'contacted_external';

export interface User {
  id: string;
  email: string;
  role: Role;
  createdAt: Date;
  updatedAt: Date;
  lastLogin?: Date;
  isActive: boolean;
  isEmailVerified: boolean;
}

export interface Recruiter extends User {
  companyName: string;
  companySize?: string;
  industry?: string;
  jobOpenings: number;
  hiringBudgetMin?: number;
  hiringBudgetMax?: number;
  locationCities: string[];
  preferredExperienceLevel: ExperienceLevel;
  requiredSkills: string[];
  bio?: string;
  verifiedCompany: boolean;
  subscriptionPlan: SubscriptionPlan;
  subscriptionUntil?: Date;
}

export interface Candidate extends User {
  firstName: string;
  lastName: string;
  currentJobTitle?: string;
  yearsExperience: number;
  salaryExpectationMin?: number;
  salaryExpectationMax?: number;
  currentLocation: string;
  willingToRelocate: boolean;
  remotePreference: RemotePreference;
  industryPreferences: string[];
  technicalSkills: string[];
  softSkills: string[];
  experienceLevel: ExperienceLevel;
  bio?: string;
  preferredIndustries: string[];
  availableStartDate?: Date;
  noticePeriod: number;
  subscriptionPlan: SubscriptionPlan;
  subscriptionUntil?: Date;
}

export interface Match {
  id: string;
  recruiterId: string;
  candidateId: string;
  matchScore: number; // 0-100
  salaryMatch: boolean;
  skillMatchCount: number;
  locationMatch: boolean;
  experienceMatch: boolean;
  matchingReasons: string[];
  status: MatchStatus;
  createdAt: Date;
  viewedAt?: Date;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface RegisterRequest {
  email: string;
  password: string;
  role: Role;
  // Champs additionnels spécifiques au rôle
}

export interface AuthResponse {
  accessToken: string;
  refreshToken: string;
  user: User;
}
```

## 5. FONCTIONNALITÉS DÉTAILLÉES ET RÈGLES MÉTIER

### Module 5.1 : Authentification & Autorisation

**Fonctionnalités :**
- Inscription avec email + mot de passe (rôle recruteur ou candidat)
- Vérification email (lien de confirmation)
- Login avec JWT (accès token 15min) + refresh token (7 jours en httpOnly cookie)
- Logout et révocation de token
- Récupération de mot de passe (lien temporaire 1h)
- Authentification multi-facteurs (optionnel MVP v2)

**Règles métier :**
- Mot de passe : min 12 caractères, majuscule, minuscule, chiffre, caractère spécial
- Email unique dans la DB
- Token JWT contient : userId, role, expiresAt
- Refresh token stocké en BD avec hash, comparaison sécurisée
- Rate limiting : 5 tentatives de login en 15 min par IP
- Session utilisateur : timeout 30 jours inactivité

**Sécurité :**
- Hash bcrypt (rounds=12) pour tous les mots de passe
- HTTPS obligatoire en production
- Headers : Strict-Transport-Security, X-Content-Type-Options: nosniff, X-Frame-Options: DENY
- CSRF token pour les formulaires POST/PUT/DELETE (cookie + body)
- Pas de données sensibles en localStorage (tokens en httpOnly cookies)
- Valider et sanitiser tous les inputs (Zod backend + frontend)
- SQL injection : requêtes paramétrées + ORM (Prisma, TypeORM)

### Module 5.2 : Gestion des Profils Utilisateurs

**Recruteur :**
- Créer/éditer profil entreprise (nom, taille, secteur, localisation, budget salarial)
- Lister les critères de recherche (compétences, secteurs, niveaux d'expérience)
- Ajouter/supprimer offres d'emploi (optionnel MVP, juste pour contexte)
- Voir suggestions de matching (nombre limité en freemium)
- Marquer candidats comme "vu" ou "rejeté"

**Candidat :**
- Créer/éditer profil personnel (expérience, compétences, attentes salariales, localisation, préférences)
- Lister préférences de recherche (secteurs, localités, télétravail)
- Voir suggestions de matching (nombre limité en freemium)
- Marquer recruteurs comme "intéressé" ou "non pertinent"

**Règles métier :**
- Profil incomplet → limiter les suggestions de matching (max 30% suggestions)
- Candidat doit avoir au minimum : nom, prénom, localisation, compétences (3+), expérience
- Recruteur doit avoir : nom entreprise, localisation, budget, secteur
- Données immutables : créatedAt, userId
- Édition : updatedAt mis à jour, historique optionnel
- Suppression compte → anonymiser données (RGPD), garder matches historiques

### Module 5.3 : Algorithme de Matching Intelligent

**Critères de scoring (pondérés) :**

```
match_score = (
  salary_compatibility * 0.30 +
  skill_alignment * 0.35 +
  location_fit * 0.15 +
  experience_match * 0.15 +
  industry_preference * 0.05
) * 100
```

**Détail des critères :**

1. **Salaire (30%)** :
   - Fourchette candidat chevauchant fourchette recruteur → 100%
   - Écart <20% → 80%
   - Écart 20-40% → 50%
   - Écart >40% → 0%

2. **Compétences techniques (35%)** :
   - Intersection(skills_candidat, skills_recruiter) / max(len, lenRec) * 100
   - Minimum 2 compétences en commun
   - Pondération : skills requis = +10%, skills additionnels = +5%

3. **Localisation (15%)** :
   - Candidat dans ville recruiter → 100%
   - Candidat dispose-t-il remote si offre remote → 50%
   - Candidat willing_to_relocate + compatible → 70%
   - Sinon → 0%

4. **Expérience (15%)** :
   - Exact match (junior→junior, etc.) → 100%
   - Un cran écart (junior vers mid) → 80%
   - Deux crans+ → 40%

5. **Industrie (5%)** :
   - Intersection secteurs → 100%, sinon 0%

**Seuil minimum de matching :** score ≥ 35 pour suggestion, affichage si score ≥ 50 par défaut

**Exécution :**
- Cronjob toutes les heures : calcul matches pour tous les recruteurs actifs
- Cache Redis : résultats 6h (invalidation si profil modifié)
- Async job pour ne pas bloquer requêtes utilisateurs

**Règles métier :**
- Chaque recruteur voit max 5 suggestions/jour en freemium (illimité en pro)
- Chaque candidat voit max 5 suggestions/jour en freemium (illimité en pro)
- Un match recruteur→candidat ne doit apparaître qu'une fois (UNIQUE constraint)
- Matches expirés après 30 jours (statut "expired")
- Pas de duplicate suggestions (vérifier candidateId + recruiterId)

### Module 5.4 : Système Freemium & Abonnements

**Plans :**

| Feature | Free | Pro | Enterprise |
|---------|------|-----|------------|
| Suggestions/jour | 5 | Illimité | Illimité + API |
| Profil | Oui | Oui | Oui |
| Historique matches | 30 jours | 1 an | Illimité |
| Support | Email 48h | Chat temps réel | Dédié |
| Export données | Non | CSV | API + JSON |
| Tarif | 0€ | 29€/mois | Devis |

**Règles métier :**
- Freemium actif par défaut à l'inscription
- Passage Pro : paiement mensuel ou annuel (-20%)
- Renouvellement auto si payment_method valide
- Downgrade possible fin de mois (remboursement prorata si annual)
- Limite API : 1000 req/jour freemium, 10k req/jour pro
- Email de rappel : 7j avant expiration (2 emails)

**Gestion des limites :**
```typescript
// Vérifier si user peut voir suggestions
const canViewMatches = (user: User): boolean => {
  const plan = user.subscriptionPlan;
  const suggestionsToday = await countSuggestionsToday(user.id);
  
  if (plan === 'free') return suggestionsToday < 5;
  return true; // pro/enterprise
};
```

### Module 5.5 : Notifications & Communication

**Notifications (email) :**
- Confirmation d'email (signup)
- Suggestion de matching (1 email/jour groupé, max 5)
- Profil vu par recruteur (optionnel, anonyme)
- Abonnement expire dans 7j
- Nouvel abonnement confirmé

**Règles métier :**
- Fréquence max : 1 email/jour par utilisateur (sauf critical)
- Désabonnement possible (unsubscribe link)
- Pas de SMS (MVP)

### Module 5.6 : Dashboard & Statistiques

**Recruiter Dashboard :**
- Nombre de suggestions générées ce mois
- Taux d'action (vus / rejetés / suggestions)
- Qualité moyennes des matches
- Filtrer/chercher candidats dans historique

**Candidate Dashboard :**
- Nombre de suggestions générées ce mois
- Profils de recruteurs intéressants
- Statistiques profil (vue/jour)

**Admin Dashboard (optionnel MVP) :**
- Nombre utilisateurs (recruteurs/candidats)
- Activité globale (matches créés/jour)
- Revenue (abonnements)
- Santé serveur (uptime, latence DB)

## 6. GESTION DES RÔLES ET PERMISSIONS

```typescript
// services/authService.ts - ACL (Access Control List)

interface Permission {
  resource: string; // 'matching', 'profile', 'subscription'
  action: string; // 'view', 'create', 'edit', 'delete'
  condition?: (user: User, context: any) => boolean;
}

const PERMISSIONS: Record<Role, Permission[]> = {
  candidate: [
    { resource: 'profile', action: 'view', condition: (u, ctx) => u.id === ctx.profileId },
    { resource: 'profile', action: 'edit', condition: (u, ctx) => u.id === ctx.profileId },
    { resource: 'matching', action: 'view' },
    { resource: 'matching', action: 'reject' },
    { resource: 'subscription', action: 'view' },
    { resource: 'subscription', action: 'upgrade' },
  ],
  recruiter: [
    { resource: 'profile', action: 'view', condition: (u, ctx) => u.id === ctx.profileId },
    { resource: 'profile', action: 'edit', condition: (u, ctx) => u.id === ctx.profileId },
    { resource: 'matching', action: 'view' },
    { resource: 'matching', action: 'mark_as_viewed' },
    { resource: 'subscription', action: 'view' },
    { resource: 'subscription', action: 'upgrade' },
  ],
};

// Middleware : vérifier permission
export const authorize = (resource: string, action: string) => {
  return async (req, res, next) => {
    const user = req.user; // via JWT middleware
    const userPerms = PERMISSIONS[user.role];
    const permitted = userPerms.some(p => 
      p.resource === resource && 
      p.action === action && 
      (!p.condition || p.condition(user, req.body || req.params))
    );
    
    if (!permitted) return res.status(403).json({ error: 'Forbidden' });
    next();
  };
};
```

**Matrice d'accès :**

| Ressource | Candidat | Recruteur | Admin |
|-----------|----------|-----------|-------|
| Son profil | RW | RW | R |
| Autres profils | R (anonyme) | R (anonyme) | RW |
| Ses suggestions | R | R | R |
| Validation profil | - | - | RW |
| Statistiques | R | R | RW |
| Gestion abonnements | R | R | RW |

## 7. DESIGN SYSTEM

### Palette de couleurs

```css
/* Primaires */
--color-primary: #6366F1; /* Indigo (confiance pro) */
--color-primary-dark: #4F46E5;
--color-primary-light: #818CF8;

/* Secondaires */
--color-success: #10B981; /* Vert (match) */
--color-warning: #F59E0B; /* Ambre (attention) */
--color-danger: #EF4444; /* Rouge (rejet) */
--color-info: #3B82F6; /* Bleu (infos) */

/* Neutres */
--color-bg-primary: #FFFFFF;
--color-bg-secondary: #F9FAFB;
--color-bg-tertiary: #F3F4F6;
--color-text-primary: #111827;
--color-text-secondary: #6B7280;
--color-text-tertiary: #9CA3AF;
--color-border: #E5E7EB;

/* Sémantique */
--color-match-positive: #10B981; /* Vert pour match > 70% */
--color-match-neutral: #F59E0B; /* Ambre pour 50-70% */
--color-match-negative: #EF4444; /* Rouge pour < 50% */
```

### Typographie

```css
/* Fonts */
font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;

/* Échelle */
--font-size-xs: 0.75rem; /* 12px */
--font-size-sm: 0.875rem; /* 14px */
--font-size-base: 1rem; /* 16px */
--font-size-lg: 1.125rem; /* 18px */
--font-size-xl: 1.25rem; /* 20px */
--font-size-2xl: 1.5rem; /* 24px */
--font-size-3xl: 1.875rem; /* 30px */

/* Poids */
--font-weight-normal: 400;
--font-weight-medium: 500;
--font-weight-semibold: 600;
--font-weight-bold: 700;

/* Line heights */
--line-height-tight: 1.2;
--line-height-normal: 1.5;
--line-height-relaxed: 1.75;
```

### Composants UI de base

**Button** :
- Variant : primary, secondary, danger, ghost
- Size : sm, md, lg
- State : default, hover, active, disabled, loading
- Interaction : ripple effect, 200ms transition

**Card** :
- Padding : 24px
- Border radius : 8px
- Box shadow : 0 1px 3px rgba(0,0,0,0.1)
- Hover : shadow augmente

**Input** :
- Border : 1px solid --color-border
- Border radius : 6px
- Focus : border-color → primary, outline none
- Placeholder : --color-text-tertiary
- Disabled : background grisé, opacity 0.5

**Modal** :
- Backdrop : rgba(0,0,0,0.5)
- Animation : scale 0.95→1, opacity 0→1, 200ms
- Close button : top-right

**Toast** :
- Position : bottom-right
- Auto-hide : 5s
- Couleur par type : success (vert), error (rouge), info (bleu)

### Spacing scale

```
4px, 8px, 12px, 16px, 24px, 32px, 48px, 64px
```

### Breakpoints responsive

```
Mobile: < 640px (sm)
Tablet: 640px - 1024px (md)
Desktop: 1024px+ (lg)
Wide: 1280px+ (xl)
```

## 8. CAS LIMITES & VALIDATIONS

### Validations Front-end (Zod)

```typescript
// Schémas de validation
import { z } from 'zod';

export const LoginSchema = z.object({
  email: z.string().email('Email invalide'),
  password: z.string().min(1, 'Mot de passe requis'),
});

export const CandidateProfileSchema = z.object({
  firstName: z.string().min(2, 'Min 2 caractères'),
  lastName: z.string().min(2, 'Min 2 caractères'),
  yearsExperience: z.number().int().min(0).max