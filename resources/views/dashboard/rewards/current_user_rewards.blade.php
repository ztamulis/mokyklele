<x-app-layout>

    <div class="client--dashboard">
        <h3>Jūsų apdovanojimai</h3>
        <p>Apdovanojimai skiriami už puikų lankomumą ir gerus pasiekimus.</p>
        <div class="reward--list">
            @foreach($rewards as $reward)
                <div class="reward">
                    <div class="reward--image" style="background-image: url('/uploads/rewards/{{ $reward->file }}')"></div>
                    <div class="reward--info">
                        <h3>{{ $reward->name }}</h3>
                        Apdovanojimas gautas {{ $reward->pivot->created_at->format("Y-m-d") }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>