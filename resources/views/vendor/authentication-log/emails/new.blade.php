@component('mail::message')
# Olá!

Você se convectiou em um novo dispositivo.

> **Email:** {{ $account->email }}<br>
> **Data Hora:** {{ $time->toCookieString() }}<br>
> **Endereço IP:** {{ $ipAddress }}<br>
> **Navegador:** {{ $browser }}

If this was you, you can ignore this alert. If you suspect any suspicious activity on your account, please change your password.

Se for você, então pode ignorar esse alerta.
Porém ee você suspeitar de qualquer atividade incomum em sua conta, altere sua senha.

Agradecimentos,<br>{{ config('app.name') }}
@endcomponent
