@foreach ($users as $user)
{{ 'https://taskord.com/@'.$user->username }}
@endforeach
