<div class="card-body border border-dashed border-end-0 border-start-0">
    <form>
        <div class="row g-3">
            <div class="col-xxl-5 col-sm-12">
                <div class="search-box">
                    <input type="text" class="form-control search bg-light border-light" placeholder="Search for tasks or something...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
            <!--end col-->

            <div class="col-xxl-3 col-sm-4">
                <input type="text" class="form-control bg-light border-light" id="demo-datepicker" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="Select date range">
            </div>
            <!--end col-->

            <div class="col-xxl-3 col-sm-4">
                <div class="input-light">
                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                        <option value="">Status</option>
                        <option value="all" selected>All</option>
                        <option value="New">New</option>
                        <option value="Pending">Pending</option>
                        <option value="Inprogress">Inprogress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            </div>
            <!--end col-->
            <div class="col-xxl-1 col-sm-4">
                <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                    Filters
                </button>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
</div>