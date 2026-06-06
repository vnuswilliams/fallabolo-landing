<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use Flux\Flux;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotificationMail;

new class extends Component
{
    use UsesSpamProtection;

    public HoneypotData $honeypotData;

    public function mount()
    {
        $this->honeypotData = new HoneypotData();
    }

    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string|min:5')]
    public string $subject = '';

    #[Validate('required|string|min:10')]
    public string $message = '';

    public function save()
    {
        $this->protectAgainstSpam();
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];

        try {
            Mail::to('payongvenus@icloud.com')->send(new ContactNotificationMail($data));

            Flux::toast(
                heading: 'Message envoyé',
                text: 'Merci ' . $this->name . ', nous vous répondrons très prochainement.',
                variant: 'success',
            );

            $this->reset();
        } catch (\Exception $e) {
             Flux::toast(
                heading: 'Erreur',
                description: 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.',
                variant: 'danger',
            );
        }
    }
};
?>

<div class="p-8 rounded-2xl border transition-all duration-300"
     x-bind:class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
    <form wire:submit="save" class="space-y-6">
        @honeypot(wire:model="honeypotData")

        <div class="grid gap-6 sm:grid-cols-2">
            <flux:input
                wire:model="name"
                label="Nom complet"
                placeholder="Votre nom"
                required
                x-bind:class="dark ? 'bg-zinc-950 border-zinc-800 text-zinc-100' : ''"
            />
            <flux:input
                wire:model="email"
                label="Adresse email"
                type="email"
                placeholder="votre@email.com"
                required
                x-bind:class="dark ? 'bg-zinc-950 border-zinc-800 text-zinc-100' : ''"
            />
        </div>

        <flux:input
            wire:model="subject"
            label="Objet"
            placeholder="Sujet de votre message"
            required
            x-bind:class="dark ? 'bg-zinc-950 border-zinc-800 text-zinc-100' : ''"
        />

        <flux:textarea
            wire:model="message"
            label="Message"
            placeholder="Comment pouvons-nous vous aider ?"
            rows="5"
            required
            x-bind:class="dark ? 'bg-zinc-950 border-zinc-800 text-zinc-100' : ''"
        />

        <div class="flex justify-center">
            <button type="submit"
                    class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-display font-bold bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-500/20">
                Envoyer le message
            </button>
        </div>
    </form>
</div>
