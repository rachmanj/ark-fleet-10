<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Expired Documents</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-6">
                <div class="description-block border-right">
                    @if($documents_expired['documents_will_expired'] > 0)
                        <span class="alert-badge alert-badge-warning">
                            <i class="fas fa-exclamation-triangle"></i> {{ $documents_expired['documents_will_expired'] }}
                        </span>
                    @endif
                    <span class="description-text">Will Expire within 2 months</span>
                    <h4 class="description-header">{{ $documents_expired['documents_will_expired'] }} docs</h4>
                    @if($documents_expired['documents_will_expired'] > 0)
                        <a href="{{ route('documents.index') }}" class="btn btn-sm btn-warning expiry-action-btn">
                            <i class="fas fa-eye"></i> Review Expiring
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 col-6">
                <div class="description-block">
                    @if($documents_expired['documents_expired'] > 0)
                        <span class="alert-badge alert-badge-danger">
                            <i class="fas fa-times-circle"></i> {{ $documents_expired['documents_expired'] }}
                        </span>
                    @endif
                    <span class="description-text">Already Expired</span>
                    <h4 class="description-header">{{ $documents_expired['documents_expired'] }} docs</h4>
                    @if($documents_expired['documents_expired'] > 0)
                        <a href="{{ route('documents.index') }}" class="btn btn-sm btn-danger expiry-action-btn">
                            <i class="fas fa-exclamation-circle"></i> Review Expired
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>