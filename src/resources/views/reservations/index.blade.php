@forelse ($reservations as $reservation)
    <div>{{ $reservation->title }} </div>
@empty
    <div>no reservations yet... </div>
@endforelse