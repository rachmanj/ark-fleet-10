<div class="card card-info">
    <div class="card-header border-transparent">
        <h3 class="card-title">Summary RFU / BD <small>(active units only)</small></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus table-collapse-btn"></i>
            </button>
            <button type="button" class="btn btn-tool" title="Expand Table">
                <i class="fas fa-expand" id="expandTable"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="sticky-table-wrapper">
            <table class="table m-0 table-striped table-bordered sticky-table">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">Plant Group Name</th>
                        @foreach ($projects_for_active_units as $project)
                            <th class="text-center" colspan="2">{{ $project->project_code }}</th>
                        @endforeach
                        <th class="text-center" rowspan="2">TOTAL</th>
                    </tr>
                    <tr>
                        @foreach ($projects_for_active_units as $project)
                            <th class="text-center">RFU</th>
                            <th class="text-center">BD</th>
                        @endforeach
                    </tr>
                </thead>
                 
                <tbody>
                    @foreach ($plant_groups as $group)
                        <tr>
                            <td>
                                <strong>{{ $group->name }}</strong>
                            </td>
                            @foreach ($projects_for_active_units as $project)
                                <td class="text-right">
                                    {{ $active_units->where('current_project_id', $project->id)->where('plant_group_id', $group->id)->where('is_rfu', 1)->count() }}
                                </td>
                                <td class="text-right">
                                    {{ $active_units->where('current_project_id', $project->id)->where('plant_group_id', $group->id)->where('is_rfu', 0)->count() }}
                                </td>
                        @endforeach
                            <td class="text-right">
                                <strong>{{ $active_units->where('plant_group_id', $group->id)->count() }}</strong>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <strong>TOTAL</strong>
                        </td>
                        @foreach ($projects_for_active_units as $project)
                        <td class="text-right">
                            <strong>{{ $active_units->where('current_project_id', $project->id)->where('is_rfu', 1)->count() }}</strong>
                        </td>
                        <td class="text-right">
                            <strong>{{ $active_units->where('current_project_id', $project->id)->where('is_rfu', 0)->count() }}</strong>
                        </td>
                        @endforeach
                        <td class="text-right">
                            <strong>{{ $active_units->count() }}</strong>
                        </td>
                    </tr> 
                </tbody>  
            </table>
        </div>
        <div class="card-footer text-muted small">
            <i class="fas fa-info-circle"></i> First column is sticky for easier horizontal scrolling. 
            Click <i class="fas fa-expand"></i> to fullscreen.
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expandBtn = document.getElementById('expandTable');
        if (expandBtn) {
            expandBtn.addEventListener('click', function() {
                const tableWrapper = document.querySelector('.sticky-table-wrapper');
                if (tableWrapper) {
                    if (!document.fullscreenElement) {
                        tableWrapper.requestFullscreen().catch(err => {
                            alert('Error attempting to enable fullscreen: ' + err.message);
                        });
                        this.classList.remove('fa-expand');
                        this.classList.add('fa-compress');
                    } else {
                        document.exitFullscreen();
                        this.classList.remove('fa-compress');
                        this.classList.add('fa-expand');
                    }
                }
            });
        }

        // Exit fullscreen handler
        document.addEventListener('fullscreenchange', function() {
            const expandBtn = document.getElementById('expandTable');
            if (expandBtn && !document.fullscreenElement) {
                expandBtn.classList.remove('fa-compress');
                expandBtn.classList.add('fa-expand');
            }
        });
    });
</script>