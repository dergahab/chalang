@extends('admin.layouts.main')

@section('heading_title', 'A/B Test Yaradın')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Experiment</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.experiments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Experiments
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.experiments.store') }}" method="POST" id="experimentForm">
                    @csrf
                    <div class="card-body">
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Experiment Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="key">Experiment Key *</label>
                                    <input type="text" class="form-control @error('key') is-invalid @enderror"
                                           id="key" name="key" value="{{ old('key') }}" required
                                           pattern="[a-zA-Z0-9_]+" title="Only letters, numbers, and underscores allowed">
                                    <small class="form-text text-muted">Unique identifier for this experiment</small>
                                    @error('key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Experiment Type *</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="page" {{ old('type') == 'page' ? 'selected' : '' }}>Page</option>
                                        <option value="component" {{ old('type') == 'component' ? 'selected' : '' }}>Component</option>
                                        <option value="feature" {{ old('type') == 'feature' ? 'selected' : '' }}>Feature</option>
                                        <option value="content" {{ old('type') == 'content' ? 'selected' : '' }}>Content</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="traffic_percentage">Traffic Percentage *</label>
                                    <input type="number" class="form-control @error('traffic_percentage') is-invalid @enderror"
                                           id="traffic_percentage" name="traffic_percentage"
                                           value="{{ old('traffic_percentage', 100) }}" min="0" max="100" required>
                                    <small class="form-text text-muted">Percentage of users to include in this experiment</small>
                                    @error('traffic_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Variants Section -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Experiment Variants</h5>
                                <small class="text-muted">Define the different versions to test</small>
                            </div>
                            <div class="card-body">
                                <div id="variants-container">
                                    <!-- Default variants will be added by JavaScript -->
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-variant">
                                    <i class="fas fa-plus"></i> Add Variant
                                </button>
                            </div>
                        </div>

                        <!-- Goals Section -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Experiment Goals</h5>
                                <small class="text-muted">Define what you want to measure</small>
                            </div>
                            <div class="card-body">
                                <div id="goals-container">
                                    <div class="goal-item mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="goals[0][name]"
                                                       placeholder="Goal name (e.g., Click Rate)">
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control" name="goals[0][type]">
                                                    <option value="conversion">Conversion</option>
                                                    <option value="engagement">Engagement</option>
                                                    <option value="revenue">Revenue</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="goals[0][target]"
                                                       placeholder="Target value (optional)">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm remove-goal">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-goal">
                                    <i class="fas fa-plus"></i> Add Goal
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Experiment
                        </button>
                        <a href="{{ route('admin.experiments.index') }}" class="btn btn-secondary ml-2">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let variantCount = 0;

    // Add default control and variant A
    addVariant(true, 'Control', 'control', 50, true);
    addVariant(false, 'Variant A', 'variant_a', 50, false);

    function addVariant(isFirst, name, key, weight, isControl) {
        const variantHtml = `
            <div class="variant-item card mb-3" data-variant-id="${variantCount}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Variant ${String.fromCharCode(65 + variantCount)}</h6>
                    ${!isFirst ? '<button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fas fa-trash"></i></button>' : ''}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" class="form-control" name="variants[${variantCount}][name]" value="${name}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Key *</label>
                                <input type="text" class="form-control" name="variants[${variantCount}][key]" value="${key}"
                                       pattern="[a-zA-Z0-9_]+" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Traffic Weight *</label>
                                <input type="number" class="form-control" name="variants[${variantCount}][traffic_weight]"
                                       value="${weight}" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Is Control</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="variants[${variantCount}][is_control]"
                                           value="1" ${isControl ? 'checked' : ''} ${variantCount === 0 ? 'disabled' : ''}>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="variants[${variantCount}][description]" placeholder="Optional">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Configuration (JSON)</label>
                        <textarea class="form-control" name="variants[${variantCount}][configuration]" rows="2"
                                  placeholder='{"button_color": "blue", "layout": "centered"}'></textarea>
                    </div>
                </div>
            </div>
        `;
        $('#variants-container').append(variantHtml);
        variantCount++;
    }

    // Add variant button
    $('#add-variant').click(function() {
        const name = `Variant ${String.fromCharCode(65 + variantCount)}`;
        const key = `variant_${String.fromCharCode(97 + variantCount - 1)}`;
        addVariant(false, name, key, 0, false);
    });

    // Remove variant
    $(document).on('click', '.remove-variant', function() {
        $(this).closest('.variant-item').remove();
        updateVariantNumbers();
    });

    function updateVariantNumbers() {
        $('.variant-item').each(function(index) {
            $(this).find('h6').text(`Variant ${String.fromCharCode(65 + index)}`);
        });
    }

    // Add goal button
    $('#add-goal').click(function() {
        const goalCount = $('.goal-item').length;
        const goalHtml = `
            <div class="goal-item mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="goals[${goalCount}][name]"
                               placeholder="Goal name (e.g., Click Rate)">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="goals[${goalCount}][type]">
                            <option value="conversion">Conversion</option>
                            <option value="engagement">Engagement</option>
                            <option value="revenue">Revenue</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="goals[${goalCount}][target]"
                               placeholder="Target value (optional)">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-goal">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#goals-container').append(goalHtml);
    });

    // Remove goal
    $(document).on('click', '.remove-goal', function() {
        $(this).closest('.goal-item').remove();
    });

    // Auto-generate key from name
    $('#name').on('input', function() {
        const name = $(this).val();
        const key = name.toLowerCase()
            .replace(/[^a-zA-Z0-9\s]/g, '')
            .replace(/\s+/g, '_')
            .substring(0, 50);
        $('#key').val(key);
    });

    // Form validation
    $('#experimentForm').submit(function(e) {
        // Check if at least one control variant exists
        const controlVariants = $('input[name*="[is_control]"]:checked').length;
        if (controlVariants === 0) {
            e.preventDefault();
            alert('You must have at least one control variant.');
            return false;
        }

        if (controlVariants > 1) {
            e.preventDefault();
            alert('You can only have one control variant.');
            return false;
        }

        // Check traffic weights sum
        let totalWeight = 0;
        $('input[name*="[traffic_weight]"]').each(function() {
            totalWeight += parseInt($(this).val()) || 0;
        });

        if (totalWeight !== 100) {
            e.preventDefault();
            alert('Traffic weights must sum to 100%.');
            return false;
        }
    });
});
</script>
@endsection