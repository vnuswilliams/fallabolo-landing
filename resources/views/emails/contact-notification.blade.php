<x-mail::message>
# Nouvelle prise de contact MatchRH

Vous avez reçu un nouveau message depuis le formulaire de contact.

**Nom :** {{ $data['name'] }}  
**Email :** {{ $data['email'] }}  
**Objet :** {{ $data['subject'] }}

**Message :**  
{{ $data['message'] }}

Cordialement,  
L'équipe {{ config('app.name') }}
</x-mail::message>
