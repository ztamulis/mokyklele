<x-app-layout>
    @if(isset($error))
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="alert alert-primary text-center" role="alert"><span>{{ $error }}</span></div>
            </div>
        </div>
    @endif
</x-app-layout>