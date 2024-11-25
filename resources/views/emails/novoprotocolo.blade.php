@component('mail::message')
Prezado {{$nome}}

<p>Seu protocolo foi gerado com sucesso! </p>

<p>Nº do Protocolo: {{$protocolo}}</p>

<p>Acompanhe o andamento do protocolo por meio do sistema <a href="http://localhost/hsweb/sistemas/cidadao/public/">hsCidadao</a></p> 

<p>Atenciosamente,</p>

<p>Equipe HardSoft</p>

@endcomponent