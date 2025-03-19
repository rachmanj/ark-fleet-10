<div class="card-body p-0">
    <div class="table-responsive">
        <table id="others" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Document No</th>
                    <th>Type</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded dynamically via AJAX -->
                <tr class="loading-indicator">
                    <td colspan="7" class="text-center py-4">
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
