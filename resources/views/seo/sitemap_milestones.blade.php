@foreach ($milestones as $milestone)
    {{ 'https://taskord.com/milestones/' . $milestone->id }}
@endforeach
