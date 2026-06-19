@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Page Builder</h4>
            <div class="text-muted small">Edit blocks and drag to reorder.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost-secondary">Back</a>
            <button type="button" class="btn btn-primary" id="builder-save">Save Layout</button>
        </div>
    </div>

    <div class="row g-3 builder-shell">
        <div class="col-lg-3">
            <div class="card glass-card builder-panel">
                <div class="card-body">
                    <h6 class="mb-3">Block Library</h6>
                    <div class="d-grid gap-2" id="block-library">
                        <button type="button" class="btn btn-ghost-primary block-add-btn" data-block-type="hero">Hero</button>
                        <button type="button" class="btn btn-ghost-primary block-add-btn" data-block-type="text">Text</button>
                        <button type="button" class="btn btn-ghost-primary block-add-btn" data-block-type="image">Image</button>
                        <button type="button" class="btn btn-ghost-primary block-add-btn" data-block-type="cta">CTA</button>
                        <button type="button" class="btn btn-ghost-primary block-add-btn" data-block-type="spacer">Spacer</button>
                    </div>
                </div>
            </div>

            <div class="card glass-card builder-panel mt-3">
                <div class="card-body">
                    <h6 class="mb-2">Page Info</h6>
                    <div class="small text-muted">Title: <span class="text-light">{{ $page->title }}</span></div>
                    <div class="small text-muted">Slug: <span class="text-light">/{{ $page->slug }}</span></div>
                    <div class="small text-muted">Status: <span class="text-light">{{ $page->status }}</span></div>
                    <div class="small text-muted mt-2">Blocks: <span class="text-light" id="block-count">0</span></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card glass-card builder-panel builder-canvas">
                <div class="card-body">
                    <div id="builder-canvas" class="builder-canvas-list"></div>
                    <div class="builder-empty text-center text-muted" id="builder-empty">
                        No blocks yet. Use the library to add.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card glass-card builder-panel">
                <div class="card-body">
                    <h6 class="mb-3">Tips</h6>
                    <ul class="small text-muted mb-0">
                        <li>Drag the handle to reorder blocks.</li>
                        <li>Edit fields inside each block.</li>
                        <li>Save to persist layout.</li>
                    </ul>
                    <div class="small text-muted mt-3" id="builder-status">Ready.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .builder-shell .builder-panel {
        border-radius: 16px;
    }
    .builder-canvas {
        min-height: 540px;
    }
    .builder-canvas-list {
        display: grid;
        gap: 16px;
    }
    .builder-empty {
        padding: 40px 10px;
        border: 1px dashed rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        margin-top: 10px;
    }
    .builder-block {
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(15, 23, 42, 0.35);
        border-radius: 16px;
        padding: 16px;
    }
    .builder-block-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .builder-block-title {
        font-weight: 600;
    }
    .builder-drag {
        cursor: grab;
    }
    .builder-ghost {
        opacity: 0.6;
        background: rgba(124, 58, 237, 0.08);
        border: 1px dashed rgba(124, 58, 237, 0.45);
    }
    .builder-block-actions {
        display: flex;
        gap: 6px;
    }
    .builder-field label {
        font-size: 0.8rem;
        margin-bottom: 6px;
    }
    .builder-field + .builder-field {
        margin-top: 10px;
    }
</style>
@endsection

@push('js_stack')
<script src="{{ asset('admin_assets/assets/libs/sortablejs/Sortable.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('builder-canvas');
        const emptyState = document.getElementById('builder-empty');
        const statusEl = document.getElementById('builder-status');
        const countEl = document.getElementById('block-count');

        const blockTypes = {
            hero: {
                label: 'Hero',
                fields: [
                    { key: 'title', label: 'Title', type: 'text', placeholder: 'Hero title' },
                    { key: 'subtitle', label: 'Subtitle', type: 'textarea', placeholder: 'Short subtitle' },
                    { key: 'buttonText', label: 'Button Text', type: 'text', placeholder: 'Get started' },
                    { key: 'buttonUrl', label: 'Button URL', type: 'text', placeholder: '/contact' }
                ]
            },
            text: {
                label: 'Text',
                fields: [
                    { key: 'heading', label: 'Heading', type: 'text', placeholder: 'Section heading' },
                    { key: 'body', label: 'Body', type: 'textarea', placeholder: 'Write content...' }
                ]
            },
            image: {
                label: 'Image',
                fields: [
                    { key: 'url', label: 'Image URL', type: 'text', placeholder: 'https://...' },
                    { key: 'alt', label: 'Alt Text', type: 'text', placeholder: 'Description' }
                ]
            },
            cta: {
                label: 'CTA',
                fields: [
                    { key: 'title', label: 'Title', type: 'text', placeholder: 'Call to action' },
                    { key: 'description', label: 'Description', type: 'textarea', placeholder: 'Short description' },
                    { key: 'buttonText', label: 'Button Text', type: 'text', placeholder: 'Contact us' },
                    { key: 'buttonUrl', label: 'Button URL', type: 'text', placeholder: '/contact' }
                ]
            },
            spacer: {
                label: 'Spacer',
                fields: [
                    { key: 'height', label: 'Height (px)', type: 'text', placeholder: '40' }
                ]
            }
        };

        const createId = () => 'blk_' + Math.random().toString(36).slice(2, 9) + Date.now();
        let blocks = Array.isArray(@json($page->content ?? [])) ? @json($page->content ?? []) : [];
        const blockMap = {};

        const normalizeBlock = (block) => {
            if (!block || typeof block !== 'object') {
                return null;
            }
            const normalized = { ...block };
            if (!normalized.id) normalized.id = createId();
            if (!normalized.type || !blockTypes[normalized.type]) normalized.type = 'text';
            if (!normalized.data || typeof normalized.data !== 'object') normalized.data = {};
            blockMap[normalized.id] = normalized;
            return normalized;
        };

        blocks = blocks.map(normalizeBlock).filter(Boolean);

        const updateEmptyState = () => {
            emptyState.style.display = blocks.length ? 'none' : 'block';
            countEl.textContent = blocks.length.toString();
        };

        const createField = (block, field) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'builder-field';
            const label = document.createElement('label');
            label.className = 'form-label text-muted';
            label.textContent = field.label;
            wrapper.appendChild(label);

            let input;
            if (field.type === 'textarea') {
                input = document.createElement('textarea');
                input.rows = 3;
            } else {
                input = document.createElement('input');
                input.type = 'text';
            }
            input.className = 'form-control';
            input.dataset.field = field.key;
            input.value = block.data[field.key] ?? '';
            if (field.placeholder) {
                input.placeholder = field.placeholder;
            }
            wrapper.appendChild(input);
            return wrapper;
        };

        const renderBlock = (block) => {
            const blockDef = blockTypes[block.type];
            const wrapper = document.createElement('div');
            wrapper.className = 'builder-block';
            wrapper.dataset.blockId = block.id;

            const head = document.createElement('div');
            head.className = 'builder-block-head';

            const title = document.createElement('div');
            title.className = 'builder-block-title';
            title.textContent = blockDef.label;

            const actions = document.createElement('div');
            actions.className = 'builder-block-actions';
            actions.innerHTML = `
                <button type="button" class="btn btn-sm btn-ghost-secondary builder-drag" data-action="drag">
                    <i class="ri-drag-move-2-line"></i>
                </button>
                <button type="button" class="btn btn-sm btn-ghost-primary" data-action="duplicate">
                    <i class="ri-file-copy-line"></i>
                </button>
                <button type="button" class="btn btn-sm btn-ghost-danger" data-action="delete">
                    <i class="ri-delete-bin-6-line"></i>
                </button>
            `;

            head.appendChild(title);
            head.appendChild(actions);
            wrapper.appendChild(head);

            blockDef.fields.forEach((field) => {
                wrapper.appendChild(createField(block, field));
            });

            return wrapper;
        };

        const renderCanvas = () => {
            canvas.innerHTML = '';
            blocks.forEach((block) => {
                canvas.appendChild(renderBlock(block));
            });
            updateEmptyState();
        };

        const addBlock = (type) => {
            const def = blockTypes[type];
            const block = normalizeBlock({ id: createId(), type, data: {} });
            def.fields.forEach((field) => {
                block.data[field.key] = '';
            });
            blocks.push(block);
            canvas.appendChild(renderBlock(block));
            updateEmptyState();
            statusEl.textContent = 'Added ' + def.label + ' block.';
        };

        document.querySelectorAll('.block-add-btn').forEach((btn) => {
            btn.addEventListener('click', () => addBlock(btn.dataset.blockType));
        });

        canvas.addEventListener('input', (event) => {
            const target = event.target;
            if (!target || !target.dataset.field) return;
            const blockEl = target.closest('.builder-block');
            if (!blockEl) return;
            const block = blockMap[blockEl.dataset.blockId];
            if (!block) return;
            block.data[target.dataset.field] = target.value;
            statusEl.textContent = 'Editing...';
        });

        canvas.addEventListener('click', (event) => {
            const actionBtn = event.target.closest('[data-action]');
            if (!actionBtn) return;
            const blockEl = actionBtn.closest('.builder-block');
            if (!blockEl) return;
            const blockId = blockEl.dataset.blockId;

            if (actionBtn.dataset.action === 'delete') {
                blocks = blocks.filter((b) => b.id !== blockId);
                delete blockMap[blockId];
                blockEl.remove();
                updateEmptyState();
                statusEl.textContent = 'Block removed.';
            }

            if (actionBtn.dataset.action === 'duplicate') {
                const source = blockMap[blockId];
                if (!source) return;
                const clone = normalizeBlock({
                    id: createId(),
                    type: source.type,
                    data: { ...source.data }
                });
                const index = blocks.findIndex((b) => b.id === blockId);
                blocks.splice(index + 1, 0, clone);
                renderCanvas();
                statusEl.textContent = 'Block duplicated.';
            }
        });

        Sortable.create(canvas, {
            animation: 150,
            ghostClass: 'builder-ghost',
            handle: '.builder-drag',
            onEnd: () => {
                const ordered = [];
                canvas.querySelectorAll('.builder-block').forEach((el) => {
                    const block = blockMap[el.dataset.blockId];
                    if (block) ordered.push(block);
                });
                blocks = ordered;
                statusEl.textContent = 'Order updated.';
            }
        });

        const saveLayout = async () => {
            const saveBtn = document.getElementById('builder-save');
            saveBtn.disabled = true;
            statusEl.textContent = 'Saving...';
            try {
                const response = await fetch("{{ route('admin.pages.update', $page->id) }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content
                    },
                    body: JSON.stringify({ content: blocks })
                });
                if (!response.ok) {
                    throw new Error('Save failed');
                }
                statusEl.textContent = 'Saved.';
                toastr.success('Layout saved');
            } catch (err) {
                statusEl.textContent = 'Save failed.';
                toastr.error('Save failed');
            } finally {
                saveBtn.disabled = false;
            }
        };

        document.getElementById('builder-save').addEventListener('click', saveLayout);

        document.addEventListener('keydown', (event) => {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 's') {
                event.preventDefault();
                saveLayout();
            }
        });

        renderCanvas();
    });
</script>
@endpush
