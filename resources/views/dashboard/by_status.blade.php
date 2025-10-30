<div class="card card-info">
    <div class="card-header border-transparent">
        <h3 class="card-title">Summary by Unit Status <small>(excl SOLD)</small></h3>
        <div class="card-tools">
            <span id="filterStatus" class="badge badge-info"></span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="unitStatusTable" class="table m-0 table-striped">
                <thead>
                    <tr>
                        <th>Projects</th>
                        @foreach ($unit_status as $status)
                            <th class="text-right">{{ $status->name }}</th>
                        @endforeach
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>
                                <strong>{{ $project->project_code }}</strong>
                            </td>
                            @foreach ($unit_status as $status)
                                <td class="text-right">
                                    {{ $equipments->where('current_project_id', $project->id)->where('unitstatus_id', $status->id)->count() }}
                                </td>
                            @endforeach
                            <td class="text-right">
                                <strong>{{ $equipments->where('current_project_id', $project->id)->count() }}</strong>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            <strong>Total</strong>
                        </td>
                        @foreach ($unit_status as $status)
                        <td class="text-right">
                            <strong>{{ $equipments->where('unitstatus_id', $status->id)->count() }}</strong>
                        </td>
                        @endforeach
                        <td class="text-right">
                            <strong>{{ $equipments->count() }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>