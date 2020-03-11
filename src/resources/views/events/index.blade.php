@forelse ($events as $event)
    <div>{{ $event->title }} </div>
@empty
    <div>no events yet... </div>
@endforelse