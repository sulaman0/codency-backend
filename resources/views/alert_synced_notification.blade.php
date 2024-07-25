@php
    $isAllAudioSynced =  \App\AppHelper\AppHelper::isAllAudioSynced();
@endphp
@if(!$isAllAudioSynced['isSynced'])
    <div class="col-xl-12">
        <div class="alert alert-danger" role="alert">
            All alerts audio is in syncing process, Remaining alerts are
            {{ $isAllAudioSynced['unSynced'] }}
        </div>
    </div>
@endif
