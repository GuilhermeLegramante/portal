@component('mail::message')
# Prezado Usuário

<p>Seus novos dados de acesso ao sistema {{env('APP_CONTRACHEQUE_NAME')}}: </p>

<p>CPF: <strong>{{$cpf}}</strong> </p>
<p>Código PIN: <strong>{{$pin}}</strong></p>

<p>Obs: Esses dados de acesso somente serão válidos para este município
</p>

<p>Atenciosamente,</p>

<p>Equipe HardSoft</p>

@endcomponent