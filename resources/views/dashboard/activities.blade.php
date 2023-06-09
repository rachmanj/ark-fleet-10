<div class="card card-info">
    <div class="card-header border-transparent">
        <h3 class="card-title">Recent Activities</h3>
    </div>
    <div class="card-body card-comments">
        @foreach ($activities as $activity)
        <div class="card-comment">
            <div class="comment-text">
                @if ($activity->activity_type === "create")
                <strong>{{ $activity->user->name }}</strong> created new 
                    @if ($activity->model === "Equipment")
                        {{ ' Equipment ' . \App\Models\Equipment::find($activity->model_id)->unit_no }}
                    @elseif ($activity->model === "Moving")
                        {{ 'IPA ' . \App\Models\Moving::find($activity->model_id)->ipa_no }}
                    @elseif ($activity->model === "Document")
                        {{ \App\Models\Document::find($activity->model_id)->document_type->name . ' ' . \App\Models\Document::find($activity->model_id)->document_no }}
                    @elseif ($activity->model === "Photo")
                        {{ 'Photo of ' . \App\Models\Equipment::find($activity->model_id)->unit_no }}
                    @endif
                @elseif ($activity->activity_type === "update")
                <strong>{{ $activity->user->name }}</strong> updated {{ $activity->model }} 
                    @if ($activity->model === "Equipment")
                        {{ \App\Models\Equipment::find($activity->model_id)->unit_no }}
                    @elseif ($activity->model === "Document")
                        {{ \App\Models\Document::find($activity->model_id)->document_type->name . ' ' . \App\Models\Document::find($activity->model_id)->document_no }}
                    @endif
                @elseif ($activity->activity_type === "delete")
                <strong>{{ $activity->user->name }}</strong> deleted {{ $activity->model }} 
                    @if ($activity->model === "Equipment")
                        {{ \App\Models\Equipment::find($activity->model_id)->unit_no }}
                    @elseif ($activity->model === "Document")
                        {{ \App\Models\Document::find($activity->model_id)->document_type->name . ' ' . \App\Models\Document::find($activity->model_id)->document_no }}
                    @elseif ($activity->model === "Photo")
                        {{ \App\Models\Equipment::find($activity->model_id)->unit_no }}
                    @endif
                @endif
                {{ ' about ' . $activity->created_at->diffForHumans() }}
            </div>
        </div>
        @endforeach
    </div>
</div>