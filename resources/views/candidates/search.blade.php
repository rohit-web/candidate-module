@foreach ($candidates as $candidate)
    <div class="card" style="border: 1px solid #e0e0e0;border-radius: 10px;">
        <div class="card-body">
            <h5 class="card-title">{{ $candidate->name }} (<small>{{ $candidate->location }}</small>)</h5>
            
            <p class="card-text">{{ $candidate->cover_letter }}</p>
            <button type="button" class="btn btn-primary modelBtnClass" data-id="{{ $candidate->uuid }}">More</button>
        </div>
    </div>
@endforeach