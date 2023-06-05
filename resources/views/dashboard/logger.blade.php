<div class="card card-info">
    <div class="card-header border-transparent">
        <h3 class="card-title">Recent Activities</h3>
    </div>
    <div class="card-body card-comments">
        @foreach ($activities as $activity)
        <div class="card-comment">
            <div class="comment-text">
                {{ $activity->description . ' about ' . $activity->created_at->diffForHumans() }}
            </div>
        </div>
        @endforeach
    </div>
</div>