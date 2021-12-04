<div>
    <h1>{{ $character->name }}</h1>
    <ul>
        <li><strong>Health</strong>: {{$character->health}}/{{$character->max_health}}</li>
        <li><strong>Experience</strong>: {{$character->experience}}/{{$character->experience_to_next_level}}</li>
    </ul>
    {{-- <h1>Attributes</h1>
    <ul>
        <li>Strength: {{$character->strength}}</li>
        <li>Dexterity: {{$character->dexterity}}</li>
        <li>Constitution: {{$character->constitution}}</li>
        <li>Intelligence: {{$character->intelligence}}</li>
        <li>Luck: {{$character->luck}}</li>
    </ul> --}}
</div>
