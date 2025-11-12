<?php $__env->startSection('title', 'Edit Produk - Admin Panel'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit me-2"></i>Edit Produk</h2>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Produk</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="name" 
                               name="name" 
                               value="<?php echo e(old('name', $product->name)); ?>" 
                               required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4"><?php echo e(old('deskripsi', $product->deskripsi)); ?></textarea>
                        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga Normal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="harga" 
                                           name="harga" 
                                           value="<?php echo e(old('harga', $product->harga)); ?>" 
                                           min="0" 
                                           required>
                                </div>
                                <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga_diskon" class="form-label">Harga Diskon</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control <?php $__errorArgs = ['harga_diskon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="harga_diskon" 
                                           name="harga_diskon" 
                                           value="<?php echo e(old('harga_diskon', $product->harga_diskon)); ?>" 
                                           min="0">
                                </div>
                                <?php $__errorArgs = ['harga_diskon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Kosongkan jika tidak ada diskon</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['id_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="id_kategori" 
                                        name="id_kategori" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" 
                                                <?php echo e(old('id_kategori', $product->id_kategori) == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->nama_kategori); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['id_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="stok" 
                                       name="stok" 
                                       value="<?php echo e(old('stok', $product->stok)); ?>" 
                                       min="0" 
                                       required>
                                <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Produk</label>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/*">
                        <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                        
                        <?php if($product->gambar): ?>
                            <div class="mt-3">
                                <label class="form-label">Gambar Saat Ini:</label>
                                <img src="<?php echo e(asset('storage/'.$product->gambar)); ?>" 
                                     alt="<?php echo e($product->name); ?>" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px;">
                            </div>
                        <?php endif; ?>
                        
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <label class="form-label">Preview Gambar Baru:</label>
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combinable Options -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Opsi Papan Gabungan</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_combinable" name="is_combinable" value="1" <?php echo e(old('is_combinable', $product->is_combinable) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_combinable">
                            Produk ini dapat digabungkan
                        </label>
                        <small class="form-text text-muted d-block">Centang jika produk ini dapat digabungkan dengan produk lain.</small>
                    </div>

                    <div class="mb-3" id="combinedPriceMultiplierField" style="<?php echo e(old('is_combinable', $product->is_combinable) ? '' : 'display: none;'); ?>">
                        <label for="combined_price_multiplier" class="form-label">Pengali Harga Gabungan</label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['combined_price_multiplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="combined_price_multiplier" 
                                   name="combined_price_multiplier" 
                                   value="<?php echo e(old('combined_price_multiplier', $product->combined_price_multiplier)); ?>" 
                                   step="0.01" 
                                   min="0.01" 
                                   max="10.00">
                        </div>
                        <?php $__errorArgs = ['combined_price_multiplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Faktor pengali untuk harga jika papan digabungkan (misal: 1.8 untuk 2 papan berarti harga total 1.8x harga normal per papan). Kosongkan jika harga dihitung secara otomatis.</small>
                    </div>

                    <div class="mb-3" id="combinedDescriptionField" style="<?php echo e(old('is_combinable', $product->is_combinable) ? '' : 'display: none;'); ?>">
                        <label for="combined_description" class="form-label">Deskripsi Gabungan</label>
                        <textarea class="form-control <?php $__errorArgs = ['combined_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="combined_description" 
                                  name="combined_description" 
                                  rows="4"><?php echo e(old('combined_description', $product->combined_description)); ?></textarea>
                        <?php $__errorArgs = ['combined_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Deskripsi khusus yang ditampilkan jika produk ini dibeli sebagai papan gabungan.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').style.display = 'none';
    }
});

// Toggle combinable fields
document.addEventListener('DOMContentLoaded', function() {
    const isCombinableCheckbox = document.getElementById('is_combinable');
    const combinedPriceMultiplierField = document.getElementById('combinedPriceMultiplierField');
    const combinedDescriptionField = document.getElementById('combinedDescriptionField');

    function toggleCombinableFields() {
        if (isCombinableCheckbox.checked) {
            combinedPriceMultiplierField.style.display = 'block';
            combinedDescriptionField.style.display = 'block';
        } else {
            combinedPriceMultiplierField.style.display = 'none';
            combinedDescriptionField.style.display = 'none';
        }
    }

    isCombinableCheckbox.addEventListener('change', toggleCombinableFields);
    toggleCombinableFields(); // Set initial state
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>