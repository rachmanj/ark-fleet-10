<div class="card-body p-0">
    <div class="table-responsive">
        <table id="changes" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Date</th>
                    <th>Old No</th>
                    <th>New No</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded dynamically via AJAX -->
                <tr class="loading-indicator">
                    <td colspan="4" class="text-center py-4">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-primary mr-2" role="status"
                                style="width: 1.5rem; height: 1.5rem;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span>Loading data...</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
