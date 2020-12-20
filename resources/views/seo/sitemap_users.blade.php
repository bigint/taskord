@foreach ($users as $user)
{{ 'https://taskord.com/@'.$user->username }}
{{ 'https://taskord.com/@'.$user->username.'/pending' }}
{{ 'https://taskord.com/@'.$user->username.'/products' }}
{{ 'https://taskord.com/@'.$user->username.'/questions' }}
{{ 'https://taskord.com/@'.$user->username.'/answers' }}
{{ 'https://taskord.com/@'.$user->username.'/following' }}
{{ 'https://taskord.com/@'.$user->username.'/followers' }}
@endforeach