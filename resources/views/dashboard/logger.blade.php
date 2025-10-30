<div class="card card-info">
    <div class="card-header border-transparent">
        <h3 class="card-title">Recent Activities</h3>
        <div class="card-tools">
            <select id="activityFilter" class="form-control form-control-sm" style="width: 150px;">
                <option value="all">All Activities</option>
                <option value="created">Created</option>
                <option value="updated">Updated</option>
                <option value="IPA">IPA Related</option>
                <option value="equipment">Equipment Only</option>
            </select>
        </div>
    </div>
    <div class="card-body card-comments p-0" style="max-height: 400px; overflow-y: auto;">
        @php
            $groupedActivities = [];
            $now = \Carbon\Carbon::now();
            
            foreach ($activities as $activity) {
                $date = $activity->created_at;
                if ($date->isToday()) {
                    $group = 'Today';
                } elseif ($date->isYesterday()) {
                    $group = 'Yesterday';
                } elseif ($date->diffInDays($now) <= 7) {
                    $group = 'This Week';
                } else {
                    $group = 'Older';
                }
                
                if (!isset($groupedActivities[$group])) {
                    $groupedActivities[$group] = [];
                }
                $groupedActivities[$group][] = $activity;
            }
            
            $groupOrder = ['Today', 'Yesterday', 'This Week', 'Older'];
        @endphp

        @foreach ($groupOrder as $group)
            @if(isset($groupedActivities[$group]) && count($groupedActivities[$group]) > 0)
                <div class="activity-group">
                    <div class="activity-group-header">
                        <i class="fas fa-calendar-day"></i> {{ $group }}
                    </div>
                    @foreach ($groupedActivities[$group] as $activity)
                        @php
                            $desc = $activity->description;
                            $activityType = 'default';
                            $icon = 'fa-circle';
                            $iconColor = '#6c757d';
                            
                            if (str_contains($desc, 'created new equipment')) {
                                $activityType = 'equipment-created';
                                $icon = 'fa-truck';
                                $iconColor = '#28a745';
                            } elseif (str_contains($desc, 'updated equipment')) {
                                $activityType = 'equipment-updated';
                                $icon = 'fa-edit';
                                $iconColor = '#ffc107';
                            } elseif (str_contains($desc, 'created IPA')) {
                                $activityType = 'ipa-created';
                                $icon = 'fa-exchange-alt';
                                $iconColor = '#17a2b8';
                            } elseif (str_contains($desc, 'created') || str_contains($desc, 'added')) {
                                $activityType = 'created';
                                $icon = 'fa-plus-circle';
                                $iconColor = '#007bff';
                            } elseif (str_contains($desc, 'updated')) {
                                $activityType = 'updated';
                                $icon = 'fa-sync-alt';
                                $iconColor = '#ffc107';
                            } elseif (str_contains($desc, 'deleted')) {
                                $activityType = 'deleted';
                                $icon = 'fa-trash';
                                $iconColor = '#dc3545';
                            }
                            
                            // Make equipment numbers and IPA numbers clickable
                            $descWithLinks = preg_replace_callback(
                                '/\b([A-Z]{2,3}\s\d{3})\b/',
                                function($matches) {
                                    return '<a href="' . route('equipments.index') . '" class="activity-link equipment-link">' . $matches[1] . '</a>';
                                },
                                $desc
                            );
                            
                            $descWithLinks = preg_replace_callback(
                                '/\b(IPA\s\d{5}\/IPA\/[IVX]+\/\d{4})\b/',
                                function($matches) {
                                    return '<a href="' . route('movings.index') . '" class="activity-link ipa-link">' . $matches[1] . '</a>';
                                },
                                $descWithLinks
                            );
                        @endphp
                        <div class="card-comment activity-item" data-type="{{ $activityType }}">
                            <div class="activity-icon">
                                <i class="fas {{ $icon }}" style="color: {{ $iconColor }}"></i>
                            </div>
                            <div class="comment-text ml-3">
                                <span class="activity-description">{!! $descWithLinks !!}</span>
                                <span class="activity-time">
                                    <i class="far fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</div>

<style>
    .activity-group {
        margin-bottom: 1rem;
    }

    .activity-group-header {
        background-color: rgba(0, 123, 255, 0.1);
        padding: 8px 15px;
        font-weight: 600;
        font-size: 0.875rem;
        color: #007bff;
        border-left: 3px solid #007bff;
    }

    .dark-mode .activity-group-header {
        background-color: rgba(0, 123, 255, 0.2);
        color: #4da3ff;
        border-left-color: #4da3ff;
    }

    .activity-item {
        display: flex;
        align-items: start;
        padding: 12px 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: background-color 0.2s;
    }

    .activity-item:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .dark-mode .activity-item {
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    .dark-mode .activity-item:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }

    .activity-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dark-mode .activity-icon {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .activity-icon i {
        font-size: 1rem;
    }

    .activity-description {
        display: block;
        font-size: 0.9rem;
        line-height: 1.4;
        color: #212529;
    }

    .dark-mode .activity-description {
        color: #c2c7d0;
    }

    .activity-time {
        display: block;
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 4px;
    }

    .dark-mode .activity-time {
        color: #adb5bd;
    }

    .activity-link {
        color: #007bff;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px dotted #007bff;
    }

    .activity-link:hover {
        color: #0056b3;
        border-bottom-style: solid;
        text-decoration: none;
    }

    .dark-mode .activity-link {
        color: #4da3ff;
        border-bottom-color: #4da3ff;
    }

    .dark-mode .activity-link:hover {
        color: #80bdff;
    }

    .equipment-link {
        color: #28a745;
        border-bottom-color: #28a745;
    }

    .ipa-link {
        color: #17a2b8;
        border-bottom-color: #17a2b8;
    }

    #activityFilter {
        background-color: rgba(255, 255, 255, 0.9);
    }

    .dark-mode #activityFilter {
        background-color: rgba(52, 58, 64, 0.9);
        color: #c2c7d0;
        border-color: rgba(255, 255, 255, 0.2);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('activityFilter');
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const filterValue = this.value;
                const activities = document.querySelectorAll('.activity-item');
                
                activities.forEach(activity => {
                    const type = activity.getAttribute('data-type');
                    
                    if (filterValue === 'all') {
                        activity.style.display = 'flex';
                    } else if (filterValue === 'created' && type.includes('created')) {
                        activity.style.display = 'flex';
                    } else if (filterValue === 'updated' && type.includes('updated')) {
                        activity.style.display = 'flex';
                    } else if (filterValue === 'IPA' && type.includes('ipa')) {
                        activity.style.display = 'flex';
                    } else if (filterValue === 'equipment' && type.includes('equipment')) {
                        activity.style.display = 'flex';
                    } else {
                        activity.style.display = 'none';
                    }
                });
            });
        }
    });
</script>